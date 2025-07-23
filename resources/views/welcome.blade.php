<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Welcome to CentaChat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .fade-up {
            animation: fadeUp 1.2s ease-out forwards;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white px-4">

    <div class="text-center fade-up">
        <img src="https://iili.io/FhGQITl.md.png" alt="CentaChat Logo" class="w-24 h-24 mx-auto mb-6">

        <h1 class="text-4xl font-bold tracking-tight mb-3">
            Welcome to <span class="text-indigo-600 dark:text-indigo-400">CentaChat</span>
        </h1>

        <p class="text-lg text-gray-600 dark:text-black-300 mb-8">
            Chat in real-time. Connect instantly.
        </p>
        <br>

        <a href="{{ route('login') }}"
           class=" text-center inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-black font-semibold rounded-lg  shadow transition duration-300">
            Get Started
        </a>
    </div>

</body>
</html>
