<!DOCTYPE html>
<html class="h-full dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Copyright © 2025 - Garfaludica APS - MIT License -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="Garfaludica APS">
    <meta name="creator" content="Garfaludica APS">
    <meta name="creator" content="Niccolò Scatena">
    <meta name="publisher" content="Garfaludica APS">
    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">

    <title inertia>{{ config('app.name', 'Garfaludica APS') }}</title>

    @vite(['resources/js/app.ts'])
    @inertiaHead
</head>

<body class="h-full font-sans antialiased bg-background">
    @inertia
</body>

</html>
