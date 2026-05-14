<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Inkwell</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink: #0f0e0c;
            --paper: #faf8f4;
            --cream: #f2ede4;
            --gold: #c9963a;
            --muted: #8a8070;
            --border: #ddd6c8;
            --white: #ffffff;
            --error: #c0392b;
            --success: #27ae60;
            --radius: 14px;
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
            line-height: 1.6;
        }

        a { color: var(--gold); text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* Alerts */
        .alert {
            padding: 1rem; margin-bottom: 1rem; border-radius: 8px; border-left: 4px solid;
        }
        .alert-success { background: #d4edda; border-color: var(--success); color: #155724; }
        .alert-error { background: #f8d7da; border-color: var(--error); color: #721c24; }

        @yield('extra_styles')
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
