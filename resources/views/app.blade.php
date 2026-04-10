<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Linker</title>

    <link rel="icon" href="{{ asset('logo.png') }}">

    <script>
        (function () {
            var theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.classList.toggle('dark', theme === 'dark');
            document.body && document.body.setAttribute('data-theme', theme);
        })();
    </script>

    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        <App />
    </div>
</body>

</html>
