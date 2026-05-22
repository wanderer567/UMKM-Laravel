<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>HOYOHOYO - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-hoyohoyo-login {
                background-image: url("{{ asset('storage/bg/bgform.png') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-hoyohoyo-login relative">
            
            <!-- Overlay Gelap -->
            <div class="absolute inset-0 bg-black opacity-40 z-0"></div>

            <div class="z-20 text-center">
                <a href="{{ route('home') }}">
                    <h1 class="text-4xl font-bold text-yellow-400 drop-shadow-lg mb-4">HOYOHOYO</h1>
                </a>
            </div>

            <!-- Panel Transparan -->
            <div class="w-full sm:max-w-md mt-2 px-6 py-8 shadow-2xl overflow-hidden sm:rounded-2xl z-20"
                 style="background: rgba(255, 255, 255, 0.15); 
                        backdrop-filter: blur(15px); 
                        -webkit-backdrop-filter: blur(15px); 
                        border: 1px solid rgba(255, 255, 255, 0.2); 
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);">
                
                {{-- Isi Form Login/Register --}}
                {{ $slot }}

                <!-- Tombol Kembali dimasukkan ke dalam Panel -->
                <div class="mt-8 pt-6 border-t border-white/20">
                    <a href="{{ route('home') }}" 
                       class="flex items-center justify-center w-full px-4 py-2 bg-gray-800/50 hover:bg-gray-800 text-white rounded-lg transition duration-200 text-sm font-semibold shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>