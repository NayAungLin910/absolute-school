@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/teacher-student/your-subjects/view/' . $form->subject_id) }}"
                class="btn btn-sm btn-primary mb-3"><i class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white text-center">{{ $form->subject->name }}</h4>
            <h5 class="text-white text-center">Rename Form</h5>
            <form action="{{ url('/teacher/edit-form') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $form->id }}" name="form_id">
                <div class="form-group">
                    <label for="" class="text-white">Rename form</label>
                    <input type="text" value="{{ $form->name }}" name="name" class="form-control" />
                    @if ($errors->has('name'))
                        <span class="text-danger bg-white">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Save</button>
            </form>
        </div>
    </div>
@endsection
