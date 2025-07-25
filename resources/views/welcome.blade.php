<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Welcome to CentaChat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SwiperJS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }

        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .fade-up {
            animation: fadeUp 1.2s ease-out forwards;
        }

        .swiper {
            width: 100%;
            height: 100vh;
        }

        .swiper-slide {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background-color: #0f172a; /* dark slate bg */
        }

        .swiper-slide img {
            width: 250px;
            height: auto;
            margin-bottom: 1.5rem;
        }

        .swiper-slide h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
        }

        .swiper-slide p {
            font-size: 1rem;
            color: #cbd5e1;
            max-width: 400px;
            text-align: center;
        }

        .swiper-pagination-bullet {
            background: white !important;
        }

        .btn-started {
            margin-top: 2rem;
            padding: 0.75rem 2rem;
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            border-radius: 0.5rem;
            transition: background 0.3s;
        }

        .btn-started:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body class="dark:bg-gray-900 text-white">

    <!-- Swiper Container -->
    <div class="swiper">
        <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide fade-up">
                <img src="https://iili.io/FhGQITl.md.png" alt="Logo">
                <h2>Welcome to <span class="text-indigo-400">CentaChat</span></h2>
                <p>Chat in real-time. Connect instantly with modern UI.</p>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide fade-up">
                <img src="{{ asset('layouts/assets/images/whatsapp.png') }}" alt="Chat Example">
                <h2>Real-Time Messaging</h2>
                <p>Send and receive messages instantly like WhatsApp.</p>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide fade-up">
                <img src="{{ asset('layouts/assets/images/whatsapp2.png') }}" alt="Dark Mode UI">
                <h2>Responsif</h2>
                <p>Dengan berkirim pesan dan gambar secara privat, Anda bisa menjadi diri sendiri, berbicara dengan bebas, dan merasa dekat dengan orang-orang terpenting dalam hidup Anda di mana pun mereka berada.</p>
                <a href="{{ route('login') }}" class="btn-started">Get Started</a>
            </div>

        </div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <!-- SwiperJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>

</body>
</html>
