@extends('layout.pdf')
@section('main')
<img src=" {{ gambar('bg.png') }} " alt="Watermark" width="100%" />
@include('document.bak.doc.home');
@endsection
