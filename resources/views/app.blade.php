<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="/dist/app.css" >
    <script src="/dist/manifest.js" defer></script>
    <script src="/dist/vendor.js" defer></script>
    <script src="/dist/app.js" defer></script>
</head>

<body>

<div id="app"></div>
</body>

</html>
