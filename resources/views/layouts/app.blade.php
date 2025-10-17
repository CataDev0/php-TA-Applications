<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
    <title>TApp</title>
</head>
<body>
<header class="text-3xl font-bold p-1 mb-1 pb-2 bg-gray-200 text-center"><a href="/">TApp</a></header>
<main class="">
    @yield('content')
</main>
<footer class="bottom-0 w-full fixed text-center bg-gray-200">Copyright 2025</footer>
</body>
</html>
