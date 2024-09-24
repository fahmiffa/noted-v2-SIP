<!DOCTYPE html>
<html>

<head>
    <title>{{ env('APP_NAME') }} | {{ env('APP_TAG') }}</title>
</head>
<style>
    body {
        font-size: 8.5pt;
        position: relative;
        margin: 0;
        padding: 0;
        height: 100vh;
        overflow: hidden;
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

    .watermark {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url({{asset('watermak.png')}});
        /* Ganti dengan path gambar Anda */
        background-repeat: repeat;
        opacity: 0.1;
        /* Sesuaikan transparansi watermark */
        pointer-events: none;
        /* Agar tidak mengganggu interaksi */
        z-index: 9999;
        transform: rotate(-45deg);
        /* Memutar watermark */
        transform-origin: 0 0;
        /* Titik awal rotasi */
    }

    .img {
        object-fit: cover;
        width: 50px;
        height: 50px;
    }

    .page-break {
        page-break-after: always;
    }

    p {
        overflow-wrap: break-word;
        white-space: normal;
    }

    .footer {
        position: fixed;
        bottom: -40px;
        left: 0px;
        right: 0px;
        height: 20px;

        color: black;
        /* text-align: center; */
        /* line-height: 35px; */
    }
</style>

<body>
    @yield('main')
</body>

</html>
