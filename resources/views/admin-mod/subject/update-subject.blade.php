@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/admin-mod/subject') }}" class="btn btn-sm btn-primary mb-3"><i class="fa-solid fa-angle-left"
                    style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white">Update Subject</h4>
            <form action="{{ url('/admin-mod/subject/edit') }}" method="POST">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                @csrf
                <div class="form-group">
                    <label for="" class="text-white">Enter subject name</label>
                    <input value="{{ $subject->name }}" type="text" name="name" class="form-control" />
                    @if ($errors->has('name'))
                        <span class="text-danger bg-white">{{ $errors->first('name') }}</span>
                    @endif
                </div>
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
                <div class="form-group mt-3">
                    <select class="form-select" name="teacher" aria-label="Default select example">
                        <option selected disabled hidden>Choose teacher</option>
                        @foreach ($teachers as $t)
                            <option value="{{ $t->id }}" @if ($t->id == $subject->teacher->id) selected @endif>
                                {{ $t->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('teacher'))
                        <span class="text-danger bg-white">{{ $errors->first('teacher') }}</span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <select class="form-select" name="batch" aria-label="Default select example">
                        <option selected disabled hidden>Choose batch</option>
                        @foreach ($batches as $b)
                            <option value="{{ $b->id }}" @if ($b->id == $subject->batch->id) selected @endif>
                                {{ $b->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('batch'))
                        <span class="text-danger bg-white">{{ $errors->first('batch') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Update</button>
            </form>
        </div>
    </div>
@endsection
