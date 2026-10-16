<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Linker</title>

    <link rel="icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('build/manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
    <meta name="theme-color" content="#fafaff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1c1c1c" media="(prefers-color-scheme: dark)">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Linker">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500&family=Instrument+Sans:wght@400;500;600&family=Instrument+Serif&display=swap">

    <script>
        (function () {
            var t = null;
            try { t = localStorage.getItem('theme'); } catch (e) {}
            if (t !== 'dark' && t !== 'light') {
                t = matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.classList.toggle('dark', t === 'dark');
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
