<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMARTCLASS - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
        
        .pixel-font {
            font-family: 'Press Start 2P', cursive;
        }
        
        .pixel-border {
            border: 3px solid #1a1a1a;
            box-shadow: 3px 3px 0px #1a1a1a;
        }
        
        .pixel-card {
            border: 4px solid #1a1a1a;
            box-shadow: 4px 4px 0px #1a1a1a;
            background: #ffffff;
        }
        
        .pixel-button {
            border: 3px solid #1a1a1a;
            box-shadow: 3px 3px 0px #1a1a1a;
            transition: all 0.1s;
            cursor: pointer;
            font-weight: bold;
            display: inline-block;
            text-decoration: none;
        }
        
        .pixel-button:hover {
            transform: translate(1px, 1px);
            box-shadow: 2px 2px 0px #1a1a1a;
            text-decoration: none;
        }
        
        .pixel-button:active {
            transform: translate(3px, 3px);
            box-shadow: 0px 0px 0px #1a1a1a;
        }
        
        body {
            background: linear-gradient(135deg, #cacacb 0%, #9da6e9 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        
        /* Fix untuk layout grid */
        .grid {
            display: grid;
        }
        
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        
        @media (min-width: 1024px) {
            .lg\:col-span-1 { grid-column: span 1 / span 1; }
            .lg\:col-span-2 { grid-column: span 2 / span 2; }
            .lg\:col-span-3 { grid-column: span 3 / span 3; }
            .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }
        
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-base { font-size: 1rem; line-height: 1.5rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        
        .font-bold { font-weight: 700; }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        
        .border-t-4 { border-top-width: 4px; }
        .border-b-4 { border-bottom-width: 4px; }
        .border-4 { border-width: 4px; }
        .border-black { border-color: #000000; }
        
        .bg-blue-100 { background-color: #dbeafe; }
        .bg-green-100 { background-color: #d1fae5; }
        .bg-yellow-100 { background-color: #fef3c7; }
        .bg-blue-400 { background-color: #60a5fa; }
        .bg-red-400 { background-color: #f87171; }
        .bg-green-400 { background-color: #4ade80; }
        .bg-yellow-400 { background-color: #facc15; }
        
        .text-black { color: #000000; }
        .text-white { color: #ffffff; }
        .text-gray-600 { color: #4b5563; }
        .text-green-600 { color: #16a34a; }
        .text-red-600 { color: #dc2626; }
        .text-blue-600 { color: #2563eb; }
        .text-yellow-600 { color: #7c7b78; }
        .text-blue-800 { color: #1e40af; }
        .text-green-800 { color: #166534; }
        .text-yellow-800 { color: #92400e; }
        
        .max-w-7xl { max-width: 80rem; }
        .max-w-6xl { max-width: 72rem; }
        
        .mx-auto { margin-left: auto; margin-right: auto; }
    </style>
</head>
<body>
    <!-- Main Content -->
    <main style="width: 100%; height: 100vh; overflow-y: auto;">
        @yield('content')
    </main>
</body>
</html>