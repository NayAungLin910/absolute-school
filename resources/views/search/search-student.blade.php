@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-white">Students</h3>
            <div class="row">
                <form class="d-inline" action="{{ url('/admin-mod-teacher/search-student') }}" method="POST">
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
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group mt-3">
                                <select class="form-select" name="batch" aria-label="Default select example">
                                    <option selected disabled hidden>Search with batch</option>
                                    @foreach ($batches as $b)
                                        <option value="{{ $b->id }}"
                                            @if ($b->id == $chose_batch_id) selected @endif>
                                            {{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" name="unassigned" type="checkbox" value="unassigned"
                                        id="flexCheckDefault" @if ($unassigned == true) checked @endif>
                                    <label class="form-check-label text-white" for="flexCheckDefault">
                                        Unassigned
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="input-group mb-3">
                            <input value="{{ $search }}" type="text" name="search" class="form-control"
                                placeholder="Search by email" aria-label="Search by email" aria-describedby="basic-addon2"
                                required>
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
                            <th>Batch</th>
                            @if (Auth::guard('admin')->check() || Auth::guard('moderator')->check())
                                <th></th>
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $s)
                            <tr>
                                <td>
                                    <img src="{{ url('/storage/images/' . $s->image) }}" class="rounded-circle"
                                        alt="{{ $s->name }}" width="40">
                                </td>
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->email }}</td>
                                <td>{{ $s->created_at }}</td>
                                <td>
                                    @if (count($s->batch) > 0)
                                        {{ $s->batch[0]->name }}
                                    @else
                                        unassigned
                                    @endif
                                </td>
                                @if (Auth::guard('admin')->check() || Auth::guard('moderator')->check())
                                    <td>
                                        <a href="{{ url('/admin-mod/search-student/assign/batch/' . $s->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-pen-to-square" style="margin-right:3px"></i>Edit Batch
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ url('/admin-mod/search-student/delete') }}"
                                            onSubmit="return confirm('Are yous sure about deleting the account ' +  '{{ $s->email }}' + '?') "
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $s->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br />
            <br />
            {{ $students->links() }}
        </div>
    </div>
@endsection
