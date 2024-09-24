@extends('layout.pdf')
@section('main')
<img src=" {{ asset('kab.png') }} " alt="Watermark" width="100%" />
@include('document.bak.doc.home');
@endsection
