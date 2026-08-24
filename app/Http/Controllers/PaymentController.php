<?php

namespace App\Http\Controllers;

use App\Models\QuestionPackage;
use App\Models\Transaction;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class PaymentController extends Controller
{
    public function create(QuestionPackage $package)
    {
        if ($package->isFree() || $this->hasAccess($package)) {
            return redirect()->route('soal.quiz', [$package, 'mode' => 'test']);
        }

        $transaction = Transaction::where('user_id', auth()->id())
            ->where('package_id', $package->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($transaction) {
            $status = $this->syncWithMidtrans($transaction);

            if ($status === 'paid') {
                UserAccess::firstOrCreate(
                    [
                        'user_id' => $transaction->user_id,
                        'package_id' => $transaction->package_id,
                    ],
                    ['transaction_id' => $transaction->id]
                );

                return redirect()->route('soal.quiz', [$package, 'mode' => 'test']);
            }

            if (in_array($status, ['expired', 'cancelled', 'failed'])) {
                $transaction->update(['status' => $status]);
                $transaction = null;
            }
        }

        if (! $transaction || ! $transaction->snap_token) {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = (bool) config('midtrans.is_production');

            $orderId = sprintf(
                'RANGKITA-%d-%s-%s',
                auth()->id(),
                now()->format('ymdHis'),
                Str::upper(Str::random(6))
            );

            $snap = Snap::createTransaction([
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $package->price,
                ],
                'item_details' => [[
                    'id' => $package->id,
                    'price' => $package->price,
                    'quantity' => 1,
                    'name' => 'Quiz '.$package->name,
                ]],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'callbacks' => [
                    'finish' => route('payment.success'),
                    'unfinish' => route('payment.success'),
                    'error' => route('payment.success'),
                ],
            ]);

            $payload = [
                'user_id' => auth()->id(),
                'package_id' => $package->id,
                'order_id' => $orderId,
                'gross_amount' => $package->price,
                'status' => 'pending',
                'snap_token' => $snap->token,
            ];

            if ($transaction) {
                $transaction->update($payload);
            } else {
                $transaction = Transaction::create($payload);
            }
        }

        return view('pages.soal-payment', [
            'package' => $package,
            'snapToken' => $transaction->snap_token,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        $notif = new Notification();
        $transaction = Transaction::where('order_id', $notif->order_id)->first();

        if (! $transaction) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $expectedSignature = hash(
            'sha512',
            $notif->order_id.$notif->status_code.$notif->gross_amount.config('midtrans.server_key')
        );

        if (! hash_equals($expectedSignature, $notif->signature_key)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $status = $this->mapStatus($notif->transaction_status);

        $transaction->update([
            'status' => $status,
            'payment_type' => $notif->payment_type ?? null,
        ]);

        if ($status === 'paid') {
            UserAccess::firstOrCreate(
                [
                    'user_id' => $transaction->user_id,
                    'package_id' => $transaction->package_id,
                ],
                ['transaction_id' => $transaction->id]
            );
        }

        return response()->json(['message' => 'ok']);
    }

    public function success(Request $request)
    {
        $transaction = Transaction::with('package')
            ->where('user_id', auth()->id())
            ->when($request->query('order_id'), fn ($q, $orderId) => $q->where('order_id', $orderId))
            ->latest()
            ->first();

        if ($transaction && $transaction->status === 'pending') {
            $status = $this->syncWithMidtrans($transaction);

            if ($status === 'paid') {
                $transaction->update(['status' => 'paid']);

                UserAccess::firstOrCreate(
                    [
                        'user_id' => $transaction->user_id,
                        'package_id' => $transaction->package_id,
                    ],
                    ['transaction_id' => $transaction->id]
                );
            } elseif ($status !== 'pending') {
                $transaction->update(['status' => $status]);
            }
        }

        return view('pages.soal-payment-success', [
            'package' => $transaction?->package,
            'status' => $transaction?->status,
        ]);
    }

    private function hasAccess(QuestionPackage $package): bool
    {
        return auth()->user()
            ->userAccess()
            ->where('package_id', $package->id)
            ->exists();
    }

    private function syncWithMidtrans(Transaction $transaction): string
    {
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = (bool) config('midtrans.is_production');

            $status = MidtransTransaction::status($transaction->order_id);

            return $this->mapStatus($status->transaction_status);
        } catch (\Throwable) {
            return 'pending';
        }
    }

    private function mapStatus(string $midtransStatus): string
    {
        return match ($midtransStatus) {
            'capture', 'settlement' => 'paid',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'cancelled',
            default => 'pending',
        };
    }
}
