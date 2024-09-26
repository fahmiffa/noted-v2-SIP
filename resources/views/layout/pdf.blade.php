<!DOCTYPE html>
<html>

<head>
    <title>{{ env('APP_NAME') }} | {{ env('APP_TAG') }}</title>
</head>
<style>
    body {
        font-size: 10pt;
        margin: 0;
        padding: 0;
        height: 100vh;
        width: 100%;
        background: white;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    td {
        border: 1px solid black;
        vertical-align: top;
    }

    .warp {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-all;
        white-space: normal;
    }

    .img {
        object-fit: cover;
        width: 50px;
        height: 50px;
    }

    .page-break {
        page-break-after: always;
    }

    .watermark {
        position: fixed;
        top: 50%;
        left: 45%;
        transform: translate(-50%, -50%);
        opacity: 0.07;
        z-index: -1;
    }

    p {
        overflow-wrap: break-word;
        white-space: normal;
    }

    .footer {
        position: fixed;
        bottom: 0%;
        left: 0px;
        right: 0px;
        height: 20px;
        color: black;
    }

    .table-bordered{        
        width: 30%;
    }

    .table-bordered td{
        border: none;        
    }

</style>

<body>
    <img class="watermark" src="{{ gambar('watermak.png') }}" width="75%" />
    @yield('main')
</body>

</html>
