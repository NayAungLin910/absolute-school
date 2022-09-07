@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/teacher-student/your-subjects/view/' . $section->subject->id) }}"
                class="btn btn-sm btn-primary mb-3"><i class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white text-center">{{ $section->subject->name }}</h4>
            <h5 class="text-white text-center">Rename Section</h5>
            <h5 class="text-white text-center">{{ $section->name }}</h5>
            <form action="{{ url('/teacher/edit-section') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $section->id }}" name="section_id">
                <div class="form-group">
                    <label for="" class="text-white">Rename section</label>
                    <input type="text" value="{{ $section->name }}" name="name" class="form-control" />
                    @if ($errors->has('name'))
                        <span class="text-danger bg-white">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Save</button>
            </form>
        </div>
    </div>
@endsection
