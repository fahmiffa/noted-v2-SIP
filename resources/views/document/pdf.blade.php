<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merge and Display PDFs</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
</head>
<body>
    <iframe id="pdf-frame" style="width: 100%; height: 600px; display: none;"></iframe>

    <script>
        (async () => {
            const { PDFDocument } = PDFLib;

            // URL PDF yang ingin digabungkan
            const pdfUrls = [
                '{{ route('bak.doc', ['id' => md5($head->bak->id)]) }}',
                '{{ route('barp.doc', ['id' => md5($head->barp->id)]) }}'
            ];


            const mergedPdf = await PDFDocument.create();

            for (const pdfUrl of pdfUrls) {
                const pdfBytes = await fetch(pdfUrl).then(res => res.arrayBuffer());
                const pdfDoc = await PDFDocument.load(pdfBytes);
                const copiedPages = await mergedPdf.copyPages(pdfDoc, pdfDoc.getPageIndices());
                copiedPages.forEach(page => mergedPdf.addPage(page));
            }

            const pdfDataUri = await mergedPdf.saveAsBase64({ dataUri: true });

            // Menampilkan PDF yang digabungkan di iframe
            const iframe = document.getElementById('pdf-frame');
            iframe.src = pdfDataUri;
            iframe.style.display = 'block';
        })();
    </script>
</body>
</html>
