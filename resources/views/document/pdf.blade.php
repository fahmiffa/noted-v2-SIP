<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merge PDFs</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
</head>
<body>
    <button id="merge-pdfs">Merge PDFs</button>
    <iframe id="pdf-frame" style="width: 100%; height: 600px; display: none;"></iframe>

    <script>
        document.getElementById('merge-pdfs').addEventListener('click', async () => {
            const { PDFDocument } = PDFLib;

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

            // Menampilkan PDF yang digabungkan
            const link = document.createElement('a');
            link.href = pdfDataUri;
            link.download = 'merged.pdf';
            link.innerText = 'Download Merged PDF';
            document.body.appendChild(link);

            const iframe = document.getElementById('pdf-frame');
            iframe.src = pdfDataUri;
            iframe.style.display = 'block';
        });
    </script>
</body>
</html>
