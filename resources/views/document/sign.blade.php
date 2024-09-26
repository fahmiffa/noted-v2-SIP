@extends('layout.base')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf_viewer.min.css">
    <style>
        .imgs {
            object-fit: cover;
            width: 50px;
            height: 50px;
        }
    </style>
@endpush
@section('main')
    <div class="container">
        <div class="row">
            @php
                $uri = [];
                if ($head->bak && $head->bak->status == 1) {
                    array_push($uri, 0);
                }
                if ($head->barp && $head->barp->status == 1) {
                    array_push($uri, 1);
                }
            @endphp

            @foreach ($uri as $val)
                <div class="col-md-6">
                    <div class="mx-auto text-center my-1" id="toolbar{{ $val }}">
                        <button id="prev{{ $val }}" class="btn btn-dark btn-sm">Previous</button>
                        <span>Page: <span id="page-num{{ $val }}"></span> / <span
                                id="page-count{{ $val }}"></span></span>
                        <button id="next{{ $val }}" class="btn btn-dark btn-sm">Next</button>
                    </div>
                    <div id="loading{{ $val }}" class="text-center my-5">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <canvas id="pdf-canvas{{ $val }}" style="display: none;" class="border border-light"></canvas>

                    @if ($head->bak->primary == 'TPT' && $head->do == 0)
                        <button type="button" data-val="{{ $val }}"
                            class="btn btn-primary btn-sm rounded-pill mx-auto d-block my-3 signs">Tanda
                            Tangan</button>
                    @endif
                </div>
            @endforeach

            @if ($head->do == 0 && $head->bak->primary == 'TPA')
                <div class="col-md-12">
                    <button type="button"
                        class="btn btn-success btn-sm rounded-pill mx-auto d-block my-3 ver text-center">Verifikasi</button>
                </div>
            @endif

            <div class="modal fade sign" id="signature" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tanda Tangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('ba.signed', ['id' => md5($head->id)]) }}" method="post">
                                @csrf
                                <canvas class="border border-light mx-auto d-block canvas" width="450"
                                    height="200"></canvas>
                                <input type="hidden" name="sign">
                                <input type="hidden" name="type" id="type">

                                <button type="button" id="clear"
                                    class="btn btn-dark btn-sm my-3 rounded-pill clear">Clear</button>
                                <button type="submit" class="btn btn-success rounded-pill btn-sm save">Approve</button>
                                <button type="button" class="btn btn-danger rounded-pill btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#reject">Reject</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="verifikasi">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Verifikasi Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('ba.ver', ['id' => md5($head->id)]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill btn-sm">Approve</button>
                                {{-- <button type="button" class="btn btn-danger rounded-pill btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#reject">Reject</button> --}}
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="reject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Menolak Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('ba.reject', ['id' => md5($head->id)]) }}" method="post">
                                @csrf
                                <p class="mb-3">Anda akan menolak dokumen ini ?
                                <p>
                                    <label>Catatan : </label>
                                    <textarea class="form-control" name="noted" required></textarea>
                                    <input type="hidden" name="type" id="typer">
                                    <button class="btn btn-success rounded-pill mt-3">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf_viewer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>

    <script>
        let pilePDF = [];

        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.worker.min.js';

        window.addEventListener('DOMContentLoaded', function() {

            pile().then((res)=>{
                console.log(res);
                res.map(function(val, i) {
                    genPDF(val, i);
                });
            }).catch((e)=>{
                console.log(e);
            });

        });

        function genPDF(val, i) {

            let pdfDoc = null,
                pageNum = 1,
                pageRendering = false,
                pageNumPending = null,
                scale = 1.5;

            document.getElementById('prev' + i).addEventListener('click', onPrevPage);
            document.getElementById('next' + i).addEventListener('click', onNextPage);
            document.getElementById('loading' + i).style.display = 'block';

            var canvas = document.getElementById('pdf-canvas' + i);
            var ctx = canvas.getContext('2d');


            pdfjsLib.getDocument(val).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                document.getElementById('page-count' + i).textContent = pdfDoc.numPages;

                renderPage(pageNum, canvas, i, ctx);

                document.getElementById('loading' + i).style.display = 'none';
                if (pdfDoc.numPages < 2) {
                    document.getElementById('prev' + i).style.display = 'none';
                    document.getElementById('next' + i).style.display = 'none';

                }
                canvas.style.display = 'block';
                canvas.style.height = '800px';
            }, function(reason) {
                console.log(reason);
                document.getElementById('loading' + i).textContent = "Failed to load Data.";
            });

            function renderPage(num, canvas, i, ctx) {
                pageRendering = true;
                pdfDoc.getPage(num, canvas).then(function(page) {
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

                document.getElementById('page-num' + i).textContent = num;
            }

            function queueRenderPage(num, canvas, i, ctx) {
                if (pageRendering) {
                    pageNumPending = num;
                } else {
                    renderPage(num, canvas, i, ctx);
                }
            }

            function onPrevPage() {
                if (pageNum <= 1) {
                    return;
                }
                pageNum--;
                queueRenderPage(pageNum, canvas, i, ctx);
            }

            function onNextPage() {
                if (pageNum >= pdfDoc.numPages) {
                    return;
                }
                pageNum++;
                queueRenderPage(pageNum, canvas, i, ctx);
            }
        }

        const canvas = document.querySelector(".canvas");
        var signaturePad = new SignaturePad(canvas);

        $('.signs').on('click', function() {
            var id = $(this).attr('data-val');
            $('#type').val(id);
            $('#typer').val(id);
            var myModal = new bootstrap.Modal(document.getElementById('signature'));
            myModal.show();
            signaturePad.clear();
        });

        $('.ver').on('click', function() {
            var id = $(this).attr('data-val');
            // $('#verifikasi').show();
            var myModal = new bootstrap.Modal(document.getElementById('verifikasi'));
            myModal.show();
        });

        $('.clear').on('click', function() {
            signaturePad.clear();
        });

        $('.save').on('click', function(e) {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
                e.preventDefault();
            } else {
                var signatureData = signaturePad.toDataURL();
                $('input[name="sign"]').attr('value', signatureData);
            }
        });

        async function pile() {
            let uri = [];            
            const {
                PDFDocument
            } = PDFLib;

            const mergedPdf = await PDFDocument.create();
       
            @if ($head->bak && $head->bak->status == 1)
                @if ($head->bak->files)
                    @php
                        $uri = [route('bak.doc', ['id' => md5($head->bak->id)]), asset('storage/' . $head->bak->files)];
                    @endphp

                    const pdfUrls = @json($uri);
                    
                    for (const pdfUrl of pdfUrls) {
                        const pdfBytes = await fetch(pdfUrl).then(res => res.arrayBuffer());
                        const pdfDoc = await PDFDocument.load(pdfBytes);
                        const copiedPages = await mergedPdf.copyPages(pdfDoc, pdfDoc.getPageIndices());
                        copiedPages.forEach(page => mergedPdf.addPage(page));
                    }
        
                    const pdfDataUri = await mergedPdf.saveAsBase64({
                        dataUri: true
                    });

                    uri.push(pdfDataUri);
                @else
                    uri.push("{{ route('bak.doc', ['id' => md5($head->bak->id)]) }}");
                @endif
            @endif

            @if ($head->barp && $head->barp->status == 1)
                uri.push("{{ route('barp.doc', ['id' => md5($head->barp->id)]) }}");
            @endif
            return uri;
        }

    </script>
@endpush
