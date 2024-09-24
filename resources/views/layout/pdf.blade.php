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
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.1;
        z-index: -9999;
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
