<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog на Slim</title>
</head>
<body>
<header class="header">
    @yield('header')
</header>
<main class="main">
    @yield('content')
</main>
<footer class="footer">
    Blog на SLIM 2024 DEMO
</footer>
</body>
</html>