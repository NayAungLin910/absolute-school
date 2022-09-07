@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/teacher-student/your-subjects/view/' . $section->subject->id) }}"
                class="btn btn-sm btn-primary mb-3"><i class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white text-center">{{ $section->name }}</h4>
            <h5 class="text-white text-center">Upload File</h5>
            <form action="{{ url('/teacher/add-file') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $section->id }}" name="section_id">
                <div class="form-group">
                    <div class="mb-3">
                        <label for="formFile" class="form-label text-white">Upload File</label>
                        <input name="file" class="form-control" type="file" id="formFile">
                    </div>
                    @if ($errors->has('file'))
                        <span class="text-danger bg-white">{{ $errors->first('file') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Upload</button>
            </form>
        </div>
    </div>
@endsection
