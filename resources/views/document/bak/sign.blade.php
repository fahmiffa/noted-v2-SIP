@extends('layout.base')
@push('css')
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
        <div class="card card-body">
            <div class="col-12">

                <div class="row">
                    @if ($doc == 'bak' && $lead)
                        <div class="col-6 col-sm-6 mx-auto">
                            <div class="card text-center border border-dark fw-bold">
                                <div class="card-header">Pemohon</div>
                                <div class="card-body">
                                    @if ($news->signs)
                                        <img src="{{ $news->signs }}" class="mx-auto d-block img-fluid">
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary btn-sm rounded-pill mx-auto d-block signs"
                                        data-id="pemohon" type="button">Tanda Tangan</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="divider">
                    <div class="divider-text">{{ $lead ? 'Ketua' : 'Anggota' }}</div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6 mx-auto">
                        <div class="card text-center border border-dark fw-bold">
                            <div class="card-header">{{ $sign->users->name }}</div>
                            <div class="card-body">
                                @if ($sign->bak)
                                    <img src="{{ $sign->bak }}" class="mx-auto d-block img-fluid">
                                @endif
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-sm rounded-pill mx-auto d-block signs"
                                    data-id="{{ md5($sign->user) }}" type="button">Tanda Tangan</button>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($lead)
                    <form
                        action="{{ $doc == 'bak' ? route('pub.bak', ['id' => md5($news->id)]) : route('pub.barp', ['id' => md5($news->id)]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm rounded-pill text-center">
                            <i class="bi bi-send"></i>
                            Publish
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="modal fade" id="signatureModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tanda Tangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form
                            action="{{ $doc == 'bak' ? route('signed.news', ['id' => md5($news->id)]) : route('signed.meet', ['id' => md5($news->id)]) }}"
                            id="sign" method="post">
                            @csrf
                            <canvas id="signatureCanvas" class="border border-light mx-auto d-block mb-3" width="450"
                                height="200"></canvas>
                            <button type="button" id="clear"
                                class="btn btn-dark btn-sm my-3 rounded-pill">Clear</button>
                            <input type="hidden" name="sign" id="signed">
                            <input type="hidden" name="user" id="user">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary submit">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

    <script>
        $(document).ready(function() {
            var canvas = document.getElementById('signatureCanvas');
            var signaturePad = new SignaturePad(canvas);

            $('#clear').on('click', function() {
                signaturePad.clear();
            });

            $('.submit').on('click', function(e) {

                if (signaturePad.isEmpty()) {
                    alert("Please provide a signature first.");
                    e.preventDefault();
                } else {
                    var signatureData = signaturePad.toDataURL();
                    $('#signed').val(signatureData);
                    document.getElementById('sign').submit();
                }

            });
        });

        $('.signs').on('click', function(e) {
            e.preventDefault();
            $('#user').val($(this).attr('data-id'));
            var myModal = new bootstrap.Modal(document.getElementById('signatureModal'));
            myModal.show();
        });
    </script>
@endpush
