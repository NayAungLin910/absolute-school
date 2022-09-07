@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/admin-mod-teacher/search-student') }}" class="btn btn-sm btn-primary mb-3"><i
                    class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white">Assign Batch for {{ $student->name }}</h4>
            <form action="{{ url('admin-mod/search-student/assign/batch/' . $student->id) }}" method="POST">
                @csrf
                <div class="form-group mt-3">
                    <select class="form-select" name="batch" aria-label="Default select example">
                        <option selected disabled hidden>Choose batch</option>
                        @foreach ($batches as $b)
                            <option value="{{ $b->id }}" @if (count($student->batch) > 0 && $b->id == $student->batch[0]->id) selected @endif>
                                {{ $b->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('batch'))
                        <span class="text-danger bg-white">{{ $errors->first('batch') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Assign</button>
            </form>
        </div>
    </div>
@endsection
