@extends('layout.dashboard')

@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="text-white">Subjects</h3>
            <div class="row">
                <form class="d-inline" action="{{ url('/teacher-student/your-subjects') }}" method="POST">
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
                                placeholder="Search by name" aria-label="Search by name" aria-describedby="basic-addon2"
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
            <div class="row">
                @foreach ($subjects as $s)
                    <div class="col-sm-3">
                        <a href="{{ url('/teacher-student/your-subjects/view/' . $s->id) }}" style="text-decoration:none">
                            <div class="card card-color-purple mb-2 border-0">
                                <div class="card-body">
                                    <h4 class="text-white text-center">{{ $s->name }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <br />
            <br />
            @if (is_object($subjects))
                {{ $subjects->links() }}
            @endif
        </div>
    </div>
@endsection
