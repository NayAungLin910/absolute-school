@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-white">Batches</h3>
            <div class="row">
                <form class="d-inline" action="{{ route('batch.index') }}" method="GET">
                    @csrf
                    <div class="col-sm-12">
                        <div class="table-responsive" style="max-width: 93vw">
                            <table>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="" class="text-white">Start date: </label>
                                            <input value="{{ $startdate }}" type="date" name="startdate"
                                                class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="" class="text-white">End date: </label>
                                            <input value="{{ $enddate }}" type="date" name="enddate"
                                                class="form-control">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="input-group mb-3">
                            <input type="text" value="{{ $search }}" name="search" class="form-control"
                                placeholder="Search by name" aria-label="Search by name" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive" style="max-width: 93vw">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Student Count</th>
                            <th>Subject Count</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batches as $b)
                            <tr>
                                <td>{{ $b->name }}</td>
                                <td>{{ $b->created_at }}</td>
                                <td>{{ $b->student_count }}</td>
                                <td>{{ $b->subject_count }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ url('/admin-mod/batch/' . $b->id . '/edit') }}">
                                        <i class="fa-solid fa-pen-to-square"></i>Rename
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('batch.destroy', $b->id) }}"
                                        onSubmit="return confirm('Are yous sure about to delete the batch ' +  '{{ $b->name }}' + '?') "
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $b->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br />
            <br />
            {{ $batches->links() }}
        </div>
    </div>
@endsection
