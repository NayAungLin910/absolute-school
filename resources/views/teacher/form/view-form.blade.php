@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary mb-3"><i class="fa-solid fa-angle-left"
                    style="margin-right: 5px"></i> Back</a>
            <h3 class="text-white text-center">{{ $form->name }}</h3>
            <p class="text-white text-center"><span class="h5">{{ count($students) }}</span> students submitted</p>
            <br />
            @foreach ($students as $s)
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive" style="max-width: 93vw">
                            <table class="table table-borderless text-white">
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{ url('/storage/images/' . $s->image) }}" class="rounded-circle"
                                                alt="{{ $s->name }}" width="40">
                                        </td>
                                        <td>
                                            {{ $s->name }}
                                        </td>
                                        <td>
                                            {{ $s->email }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" style="max-width: 93vw">
                            <table class="table table-borderless text-white">
                                <tbody>
                                    @foreach ($s->upload as $u)
                                        @if ($u->form_id == $form->id)
                                            <tr>
                                                <td>
                                                    <a href="{{ url('/storage/uploads/' . $u->file_path) }}" target="_blank"
                                                        class="text-white">{{ $u->name }}</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
            <div>
                <form class="d-inline" action="{{ url('/teacher/delete-form') }}"
                    onSubmit="return confirm('Are yous sure about deleting the form ' +  '{{ $form->name }}' + '?') "
                    method="POST">
                    @csrf
                    <input type="hidden" name="form_id" value="{{ $form->id }}">
                    <button type="submit" class="btn btn-sm btn-danger">Delete Form</button>
                </form>
            </div>
        </div>
    </div>
@endsection
