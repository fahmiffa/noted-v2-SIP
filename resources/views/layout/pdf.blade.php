<!DOCTYPE html>
<html>

<head>
    <title>{{ env('APP_NAME') }} | {{ env('APP_TAG') }}</title>
</head>
<style>
    body {
        font-size: 8.5pt;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    td {
        border: 1px solid black;
    }

    .img {
        object-fit: cover;
        width: 50px;
        height: 50px;
    }

    .page-break {
        page-break-after: always;
    }
</style>

<body>
    @yield('main')    
</body>
</html>