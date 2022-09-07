@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/admin-mod/subject') }}" class="btn btn-sm btn-primary mb-3"><i class="fa-solid fa-angle-left"
                    style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white">Create Subject</h4>
            <form action="{{ url('/admin-mod/subject/create') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="" class="text-white">Enter subject name</label>
                    <input type="text" name="name" class="form-control" />
                    @if ($errors->has('name'))
                        <span class="text-danger bg-white">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="text-white">Enter meeting id</label>
                    <input type="text" name="meeting_id" class="form-control" />
                    @if ($errors->has('meeting_id'))
                        <span class="text-danger bg-white">{{ $errors->first('meeting_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="text-white">Enter meeting password</label>
                    <input type="text" name="meeting_password" class="form-control" />
                    @if ($errors->has('meeting_password'))
                        <span class="text-danger bg-white">{{ $errors->first('meeting_password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="" class="text-white">Enter meeting link</label>
                    <input type="text" name="meeting_link" class="form-control" />
                    @if ($errors->has('meeting_link'))
                        <span class="text-danger bg-white">{{ $errors->first('meeting_link') }}</span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <select class="form-select" name="teacher" aria-label="Default select example">
                        <option selected disabled hidden>Choose teacher</option>
                        @foreach ($teachers as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
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
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('batch'))
                        <span class="text-danger bg-white">{{ $errors->first('batch') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Create</button>
            </form>
        </div>
    </div>
@endsection
