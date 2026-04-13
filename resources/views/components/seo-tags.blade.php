@php
    $appName = \App\Models\Setting::get('app_name', config('app.name', 'HA Tech Portfolio Generator'));
    $metaDesc = \App\Models\Setting::get('meta_description', 'HA Tech - The Gen Z Hustler. Launch premium portfolio generators.');
    $faviconPath = \App\Models\Setting::get('favicon_path');
    
    // Provide a fallback title if a specific page title isn't yielded
    $pageTitle = app('view')->hasSection('title') ? app('view')->getSection('title') . ' — ' . $appName : $appName;
@endphp

<title>{{ $pageTitle }}</title>

<!-- Standard SEO -->
<meta name="description" content="{{ $metaDesc }}">
<meta name="author" content="HA Tech">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:site_name" content="{{ $appName }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">

<!-- Favicon -->
@if($faviconPath)
    <link rel="icon" href="{{ Storage::url($faviconPath) }}">
    <link rel="apple-touch-icon" href="{{ Storage::url($faviconPath) }}">
@else
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
@endif
