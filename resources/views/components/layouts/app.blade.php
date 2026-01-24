<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Menu Digital' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Paleta basada en el logo Panetto
                        'panetto-orange': '#F97316', // Naranja vibrante principal
                        'panetto-light': '#FFF7ED', // Fondo claro (crema/blanco roto)
                        'panetto-dark': '#1F2937', // Texto oscuro y fondos de admin
                        'panetto-accent': '#FFEDD5', // Naranja muy claro para fondos secundarios
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Ocultar scrollbar para Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Ocultar scrollbar para IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #FFF7ED;
            /* panetto-light */
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #F97316;
            /* panetto-orange */
            border-radius: 20px;
        }
    </style>
</head>

<body class="bg-panetto-light text-panetto-dark font-sans antialiased">
    {{ $slot }}
</body>

</html>
