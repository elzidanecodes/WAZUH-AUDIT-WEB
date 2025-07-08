<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login - Wazuh Audit' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">

    {{-- Konten login/register --}}
    <main class="">
        @yield('content')
    </main>

</body>
</html>