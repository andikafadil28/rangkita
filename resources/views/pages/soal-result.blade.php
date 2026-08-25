@extends('layouts.app')

@section('title', 'Hasil ' . $package->name . ' - Rangkita')

@section('content')
    <section class="page">
        <h1 class="page-title">Hasil Quiz</h1>

        <div class="result-hero card">
            <div class="result-score-wrap">
                <span class="result-score">{{ $session->score }}</span>
                <span class="result-score-unit">/ 100</span>
            </div>

            <div class="result-stats">
                <div class="stat-box stat-correct">
                    <strong>{{ $correctCount }}</strong>
                    <span>Benar</span>
                </div>
                <div class="stat-box stat-wrong">
                    <strong>{{ $wrongCount }}</strong>
                    <span>Salah</span>
                </div>
                <div class="stat-box stat-skipped">
                    <strong>{{ $skippedCount }}</strong>
                    <span>Kosong</span>
                </div>
            </div>

            <p class="result-meta">
                {{ $package->name }} ·
                Mode {{ $session->mode === 'test' ? 'Test' : 'Latihan' }}
                @if ($session->time_spent)
                    · Waktu: {{ intdiv($session->time_spent, 60) }} menit {{ $session->time_spent % 60 }} detik
                @endif
            </p>
        </div>

        <h2 class="section-subtitle">Pembahasan Per Soal</h2>

        <div class="recap-list">
            @foreach ($recap as $item)
                @php
                    $question = $item['question'];
                    $answerLetter = $question->correct_answer;
                    $correctText = $question->{'option_' . $answerLetter};
                    $userText = $item['user_answer'] ? $question->{'option_' . $item['user_answer']} : null;
                @endphp

                <article class="card recap-item">
                    <header class="recap-header">
                        <span class="question-number question-number-sm">{{ $loop->iteration }}</span>

                        @if ($item['is_skipped'])
                            <span class="badge status-skipped">Tidak dijawab</span>
                        @elseif ($item['is_correct'])
                            <span class="badge badge-success">✓ Benar</span>
                        @else
                            <span class="badge status-wrong">✗ Salah</span>
                        @endif
                    </header>

                    <p class="question-text">{{ $question->question_text }}</p>

                    <ul class="recap-answers">
                        <li>
                            <strong>Jawaban kamu:</strong>
                            {{ $item['user_answer'] ? strtoupper($item['user_answer']) . '. ' . $userText : '— (kosong)' }}
                        </li>
                        <li>
                            <strong>Jawaban benar:</strong>
                            {{ strtoupper($answerLetter) }}. {{ $correctText }}
                        </li>
                    </ul>

                    @if ($question->explanation)
                        <div class="explanation-box">
                            <strong>Pembahasan:</strong> {{ $question->explanation }}
                        </div>
                    @endif
                </article>
            @endforeach
        </div>

        <div class="quiz-submit-row">
            <a href="{{ route('soal.quiz', [$package, 'mode' => $session->mode]) }}" class="btn-secondary">
                Ulangi Quiz
            </a>
            <a href="{{ route('soal.history') }}" class="btn-secondary">
                Lihat Riwayat
            </a>
            <a href="{{ route('soal.category', $package->soalCategory) }}" class="btn-primary">
                Balik ke Kategori
            </a>
        </div>
    </section>
@endsection
