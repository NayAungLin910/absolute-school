@extends('layout.dashboard')
@section('style')
    <style>
        @media (max-width: 767px) {
            #res-table {
                max-width: 93vw !important;
            }
        }
    </style>
@endsection
@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-white">Subjects</h3>
            <div class="row">
                <form class="d-inline" action="{{ url('/admin-mod/subject') }}" method="GET">
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
                            <input value="{{ $search }}" type="text" name="search" class="form-control"
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
            <div class="table-responsive" style="max-width: 66vw" id="res-table">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <td></td>
                            <th>Teahcer</th>
                            <th>Batch</th>
                            <th>Admin</th>
                            <th>Moderator</th>
                            <th>Meeting ID</th>
                            <th>Meeting Password</th>
                            <th>Meeting Link</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $s)
                            <tr>
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->created_at }}</td>
                                <td>
                                    <img src="{{ url('/storage/images/' . $s->teacher->image) }}" class="rounded-circle"
                                        alt="{{ $s->teacher->name }}" width="40">
                                </td>
                                <td>{{ $s->teacher->name }}</td>
                                <td>{{ $s->batch->name }}</td>
                                <td>
                                    @if ($s->admin)
                                        {{ $s->admin->name }}
                                    @else
                                        null
                                    @endif
                                </td>
                                <td>
                                    @if ($s->moderator)
                                        {{ $s->moderator->name }}
                                    @else
                                        null
                                    @endif
                                </td>
                                <td>{{ $s->meeting_id }}</td>
                                <td>{{ $s->meeting_password }}</td>
                                <td>{{ $s->meeting_link }}</td>
                                <td>
                                    <a href="{{ url('/admin-mod/subject/edit/' . $s->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>Edit
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ url('/admin-mod/subject/delete') }}"
                                        onSubmit="return confirm('Are yous sure about deleting the subject ' +  '{{ $s->name }}' + '?') "
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $s->id }}">
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
            {{ $subjects->links() }}
        </div>
    </div>
@endsection
