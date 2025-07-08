<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Wazuh Audit Dashboard' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

  <div class="flex">
    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

  </div>
      {{-- Konten Utama --}}
    <div class="p-4 sm:ml-64 pt-24 min-h-screen">
      @yield('content')
    </div>

  {{-- Script --}}
  @yield('scripts')

</body>
</html>
