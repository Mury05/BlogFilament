<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Blog')</title>
    @vite(['resources/css/app.css']) {{-- Pour Tailwind CSS --}}
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-lg font-bold">Mon Blog</h1>
        </div>
    </header>

    <main class="container mx-auto py-8">
        @yield('content')
    </main>
</body>
</html>
