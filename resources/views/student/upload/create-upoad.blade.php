@extends('layout.dashboard')
@section('dash-content')
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
        <i class="fa-solid fa-angle-left" style="margin-right: 3px"></i>
        Back
    </a>
    <div id="root"></div>
@endsection
@section('script')
    <script>
        window.form = @json($form)
    </script>
    <script src="{{ mix('js/createUpload.js') }}"></script>
@endsection
