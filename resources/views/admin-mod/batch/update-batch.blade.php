@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/admin-mod/batch') }}" class="btn btn-sm btn-primary mb-3"><i
                    class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white">Rename Batch</h4>
            <form action="{{ route('batch.update', $batch->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="" class="text-white">Edit batch name</label>
                    <input value="{{ $batch->name }}" type="text" name="name" class="form-control" />
                    @if ($errors->has('name'))
                        <span class="text-danger bg-white">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Save</button>
            </form>
        </div>
    </div>
@endsection
