@vite('resources/css/app.css')
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>CRM Platforma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white border-b shadow p-4 mb-6">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-semibold text-indigo-600">CRM Platforma</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
