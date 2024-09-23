<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOKUMEN {{ $head->nomor }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf_viewer.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        #toolbar {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        #pdf-viewer {
            position: relative;
            width: 100%;
            height: calc(100vh - 50px);
            overflow: auto;
            background-color: #eee;
        }

        #canvas-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #loading {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            color: #333;
            z-index: 100;
        }

        canvas {
            border: 1px solid black;
            background-color: white;
        }

        @media (max-width: 576px) {
            #pdf-viewer {
                position: relative;
                width: 100%;
                max-height: 100vh;
                overflow: auto;
                background-color: #eee;
            }

            #canvas-container {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: auto;
            }

            canvas {
                width: 100%;
                height: auto;
                border: 1px solid black;
                background-color: white;
            }
        }
    </style>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf_viewer.min.js"></script>
</head>

<body>

    <div id="loading">Loading PDF...</div>

    <div id="toolbar">
        <button id="prev">Previous</button>
        <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
        <button id="next">Next</button>
        <button id="download">Download</button>
    </div>

    <div id="pdf-viewer">
        <div id="canvas-container">
            <canvas id="pdf-canvas" style="display: none;"></canvas>
        </div>
    </div>

    <script>
        (async () => {
            const {
                PDFDocument
            } = PDFLib;

            let pdfDoc = null,
                pageNum = 1,
                pageRendering = false,
                pageNumPending = null,
                scale = 1,
                canvas = document.getElementById('pdf-canvas'),
                ctx = canvas.getContext('2d');

            const pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc =
                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.worker.min.js';

            document.getElementById('loading').style.display = 'block';

            const pdfUrls = [
                '{{ route('req.dok', ['id' => md5($head->id), 'par'=>'bak']) }}',
                '{{ route('req.dok', ['id' => md5($head->id), 'par'=>'barp']) }}',
                '{{ route('req.dok', ['id' => md5($head->id), 'par'=>'attach']) }}',
                '{{ route('req.dok', ['id' => md5($head->id), 'par'=>'tax']) }}',
            ];

            const mergedPdf = await PDFDocument.create();

            for (const pdfUrl of pdfUrls) {
                const pdfBytes = await fetch(pdfUrl).then(res => res.arrayBuffer());
                const pdfDoc = await PDFDocument.load(pdfBytes);
                const copiedPages = await mergedPdf.copyPages(pdfDoc, pdfDoc.getPageIndices());
                copiedPages.forEach(page => mergedPdf.addPage(page));
            }

            const pdfDataUri = await mergedPdf.saveAsBase64({
                dataUri: true
            });

            function downloadPdf() {
                const link = document.createElement('a');
                link.href = pdfDataUri;
                link.download = 'document.pdf';
                link.click();
            }

            function renderPage(num) {
                pageRendering = true;
                pdfDoc.getPage(num).then(function(page) {
                    const viewport = page.getViewport({
                        scale: scale
                    });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    const renderTask = page.render(renderContext);

                    renderTask.promise.then(function() {
                        pageRendering = false;
                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }
                    });
                });

                document.getElementById('page-num').textContent = num;
            }

            function queueRenderPage(num) {
                if (pageRendering) {
                    pageNumPending = num;
                } else {
                    renderPage(num);
                }
            }

            function onPrevPage() {
                if (pageNum <= 1) {
                    return;
                }
                pageNum--;
                queueRenderPage(pageNum);
            }

            function onNextPage() {
                if (pageNum >= pdfDoc.numPages) {
                    return;
                }
                pageNum++;
                queueRenderPage(pageNum);
            }

            document.getElementById('prev').addEventListener('click', onPrevPage);
            document.getElementById('next').addEventListener('click', onNextPage);
            document.getElementById('download').addEventListener('click', downloadPdf);

            pdfjsLib.getDocument(pdfDataUri).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                document.getElementById('page-count').textContent = pdfDoc.numPages;

                renderPage(pageNum);

                document.getElementById('loading').style.display = 'none';
                canvas.style.display = 'block';
            }, function(reason) {
                document.getElementById('loading').textContent = "Failed to load PDF.";
            });


        })();
    </script>
</body>

</html>
