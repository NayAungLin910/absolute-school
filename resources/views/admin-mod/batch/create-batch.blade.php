@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ url('/admin-mod/batch') }}" class="btn btn-sm btn-primary mb-3"><i class="fa-solid fa-angle-left"
                    style="margin-right: 5px"></i> Back</a>
            <h4 class="text-white">Create Batch</h4>
            <form action="{{ route('batch.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="" class="text-white">Enter batch name</label>
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
