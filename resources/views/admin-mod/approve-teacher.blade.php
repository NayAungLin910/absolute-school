@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-white">Approve Teacher</h3>
            <div class="row">
                <form class="d-inline" action="{{ url('/admin-mod/approve-teacher') }}" method="GET">
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
                                placeholder="Search by email" aria-label="Search by email" aria-describedby="basic-addon2">
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
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $t)
                            <tr>
                                <td>
                                    <img src="{{ url('/storage/images/' . $t->image) }}" class="rounded-circle"
                                        alt="{{ $t->name }}" width="40">
                                </td>
                                <td>{{ $t->name }}</td>
                                <td>{{ $t->email }}</td>
                                <td>{{ $t->created_at }}</td>
                                <td>
                                    <form action="{{ url('/admin-mod/approve-teacher/approve') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $t->id }}">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-square-check"></i>Approve
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ url('/admin-mod/approve-teacher/decline') }}"
                                        onSubmit="return confirm('Are yous sure about declining the account ' +  '{{ $t->email }}' + '?') "
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $t->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>Decline
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
            {{ $teachers->links() }}
        </div>
    </div>
@endsection
