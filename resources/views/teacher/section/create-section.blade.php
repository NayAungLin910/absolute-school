@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/teacher-student/your-subjects/view/' . $subject->id) }}" class="btn btn-sm btn-primary mb-3"><i
                    class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white text-center">{{ $subject->name }}</h4>
            <h5 class="text-white text-center">Create Section</h5>
            <form action="{{ url('/teacher/create-section') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $subject->id }}" name="subject_id">
                <div class="form-group">
                    <label for="" class="text-white">Enter section name</label>
                    <input type="text" name="name" class="form-control" />
                    @if ($errors->has('name'))
                        <span class="text-danger bg-white">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Create</button>
            </form>
        </div>
    </div>
@endsection
