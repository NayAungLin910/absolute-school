@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/teacher-student/your-subjects/view/' . $subject->id) }}" class="btn btn-sm btn-primary mb-3"><i
                    class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white text-center">{{ $subject->name }}</h4>
            <h5 class="text-white text-center">Update Zoom Information</h5>
            <form action="{{ url('/teacher/edit-zoom-info') }}" method="POST">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                @csrf
                <div class="form-group">
                    <label for="" class="text-white">Enter meeting id</label>
                    <input value="{{ $subject->meeting_id }}" type="text" name="meeting_id" class="form-control" />
                    @if ($errors->has('meeting_id'))
                        <span class="text-danger bg-white">{{ $errors->first('meeting_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="text-white">Enter meeting password</label>
                    <input value="{{ $subject->meeting_password }}" type="text" name="meeting_password"
                        class="form-control" />
                    @if ($errors->has('meeting_password'))
                        <span class="text-danger bg-white">{{ $errors->first('meeting_password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="text-white">Enter meeting link</label>
                    <input type="text" value="{{ $subject->meeting_link }}" name="meeting_link" class="form-control" />
                    @if ($errors->has('meeting_link'))
                        <span class="text-danger bg-white">{{ $errors->first('meeting_link') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Update</button>
            </form>
        </div>
    </div>
@endsection
