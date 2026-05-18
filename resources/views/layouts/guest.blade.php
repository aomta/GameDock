<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            [x-cloak] { display: none !important; }
            .auth-cover {
                background:
                    linear-gradient(90deg, rgba(3, 18, 41, .88), rgba(3, 14, 30, .72) 52%, rgba(2, 8, 18, .9)),
                    linear-gradient(180deg, rgba(2, 8, 18, .28), rgba(2, 8, 18, .68)),
                    url('/images/heroBackImage_desktop.webp') center right / cover no-repeat;
            }
            .auth-page {
                min-height: 100vh; padding: 2rem 1.25rem; color: white;
            }
            @media (min-width: 640px) { .auth-page { padding: 2rem 3.125rem; } }
            @media (min-width: 1024px) { .auth-page { padding: 3.5rem 6.25rem; } }
            .auth-stage {
                display: flex; align-items: center; min-height: calc(100vh - 4rem);
                width: 100%; max-width: 80rem; margin-left: auto; margin-right: auto;
            }
            .auth-panel {
                width: 100%; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);
                background: rgba(7,23,42,0.8); padding: 2rem 1.5rem;
                box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
                backdrop-filter: blur(12px);
            }
            @media (min-width: 640px) { .auth-panel { padding: 2.5rem 2rem; } }
            @media (min-width: 1024px) { .auth-panel { padding: 2.5rem 3.125rem; } }
            .auth-heading {
                margin-bottom: 2rem; font-size: 1.875rem; font-weight: 900;
                line-height: 1.2; letter-spacing: -0.025em; color: white;
            }
            @media (min-width: 640px) { .auth-heading { font-size: 2.25rem; } }
            @media (min-width: 1024px) { .auth-heading { font-size: 3rem; } }
            .auth-error-summary {
                margin-bottom: 1.5rem; border-radius: 0.5rem; border: 1px solid rgba(239,68,68,0.45);
                background: rgba(69,10,10,0.55); padding: 0.75rem 1rem;
                font-size: 0.875rem; line-height: 1.625; color: #fef2f2;
            }
            .auth-label {
                display: block; margin-bottom: 0.5rem; font-size: 0.875rem;
                font-weight: 800; text-transform: uppercase; letter-spacing: 0; color: #bae6fd;
            }
            @media (min-width: 640px) { .auth-label { font-size: 1rem; } }
            .auth-field {
                display: block; width: 100%; border-radius: 0.375rem; border: 1px solid rgba(186,230,253,0.2);
                background: rgba(33,61,99,0.85); padding: 0 1rem; font-size: 1rem; color: white;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05); outline: none; height: 3rem;
                transition: border-color 0.15s, box-shadow 0.15s;
            }
            .auth-field::placeholder { color: rgba(255,255,255,0.45); }
            .auth-field:focus { border-color: #7dd3fc; background: rgba(41,75,117,0.9); box-shadow: 0 0 0 2px rgba(125,211,252,0.3); }
            @media (min-width: 640px) { .auth-field { padding: 0 1.25rem; font-size: 1.125rem; height: 3.25rem; } }
            .auth-field-error {
                border-color: rgba(252,165,165,0.7); background: rgba(69,10,10,0.7);
            }
            .auth-field-error:focus { border-color: #fca5a5; background: rgba(69,10,10,0.7); box-shadow: 0 0 0 2px rgba(252,165,165,0.3); }
            .auth-button {
                display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
                border-radius: 0.5rem; background: linear-gradient(to right, #3157b7, #4d9be3);
                padding: 0 2rem; font-size: 1rem; font-weight: 900; text-transform: uppercase;
                color: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.25);
                transition: background 0.15s; height: 3rem; width: 100%;
            }
            .auth-button:hover { background: linear-gradient(to right, #3d6bd1, #62aef0); }
            .auth-button:focus { outline: none; box-shadow: 0 0 0 2px #7dd3fc, 0 0 0 4px rgba(125,211,252,0.3); }
            @media (min-width: 640px) { .auth-button { font-size: 1.125rem; max-width: 315px; } }
            .qr-code {
                width: 260px; height: 260px; background-color: #fff;
                background-image:
                    linear-gradient(90deg, #15171c 50%, transparent 50%),
                    linear-gradient(#15171c 50%, transparent 50%);
                background-position: 0 0, 0 0;
                background-size: 26px 26px, 26px 26px;
                mask:
                    radial-gradient(circle at 32px 32px, transparent 0 18px, #000 19px 34px, transparent 35px 48px, #000 49px) 0 0 / 78px 78px no-repeat,
                    radial-gradient(circle at 228px 32px, transparent 0 18px, #000 19px 34px, transparent 35px 48px, #000 49px) 0 182px / 78px 78px no-repeat,
                    radial-gradient(circle at 32px 228px, transparent 0 18px, #000 19px 34px, transparent 35px 48px, #000 49px) 0 182px / 78px 78px no-repeat,
                    linear-gradient(45deg, #000 25%, transparent 25% 38%, #000 38% 49%, transparent 49% 62%, #000 62% 74%, transparent 74%) center / 104px 104px repeat;
            }
        </style>
    </head>
<body class="font-sans bg-[#0b1b2b] text-white antialiased min-h-screen flex flex-col" style="background:#0b1b2b;">
        {{ $slot }}
        @include('components.site-footer')
    </body>
</html>
