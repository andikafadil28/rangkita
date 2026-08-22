<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Payment Gateway
    |--------------------------------------------------------------------------
    |
    | Konfigurasi Snap API untuk pembayaran quiz CPNS.
    | Key didapat dari Midtrans Dashboard -> Settings -> Access Keys.
    | Key sandbox berprefix SB-Mid-server / SB-Mid-client.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY'),

    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    // false = sandbox (testing), true = production (jangan sampai salah set!)
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

];
