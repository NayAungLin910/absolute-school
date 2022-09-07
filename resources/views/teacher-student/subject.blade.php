@extends('layout.dashboard')
@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ url('/teacher-student/your-subjects') }}" class="btn btn-sm btn-primary mb-3"><i
                    class="fa-solid fa-angle-left" style="margin-right: 5px"></i> Back</a>
            <h3 class="text-white text-center">{{ $subject->name }}</h3>
            <h4 class="text-white text-center">Batch {{ $subject->batch->name }}</h4>
            <div class="table-responsive mt-3" style="max-width: 93vw">
                <h4 class="text-white">Teacher</h4>
                <table class="table table-borderless text-white">
                    <tr>
                        <td>
                            <img src="{{ url('/storage/images/' . $subject->teacher->image) }}" class="rounded-circle"
                                alt="{{ $subject->teacher->name }}" width="40">
                        </td>
                        <td>
                            {{ $subject->teacher->name }}
                        </td>
                        <td>
                            {{ $subject->teacher->email }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive mt-3" style="max-width: 93vw">
                <h4 class="text-white text-center mt-6 mb-4">Zoom</h4>
                <table class="table table-borderless text-white">
                    <thead>
                        <tr>
                            <td>Meeting ID</td>
                            <td>Meeting Password</td>
                            <td>Meeting Link</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $subject->meeting_id }}
                            </td>
                            <td>
                                {{ $subject->meeting_password }}
                            </td>
                            <td>
                                <a href="{{ $subject->meeting_link }}" target="_blank"
                                    class="text-white">{{ $subject->meeting_link }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if (Auth::guard('teacher')->check())
                <a href="{{ url('/teacher/edit-zoom-info/' . $subject->id) }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-pen-to-square" style="margin-right: 3px"></i>Edit Zoom Info
                </a>
                <div class="row">
                    <div class="col-sm-4 mt-2">
                        <a href="{{ url('/teacher/create-section/' . $subject->id) }}" class="btn btn-sm btn-primary"><i
                                class="fa-solid fa-plus" style="margin-right: 3px"></i>Add Section</a>
                    </div>
                    <div class="col-sm-4 mt-2">
                        <a href="{{ url('/teacher/create-form/' . $subject->id) }}" class="btn btn-sm btn-primary"><i
                                class="fa-solid fa-plus" style="margin-right: 3px"></i>Add Form</a>
                    </div>
                </div>
            @endif
            <div class="row">
                <h4 class="text-white mt-5 text-center mb-4">Sections</h4>
                @foreach ($subject->section as $sec)
                    <div class="col-sm-12">
                        <h5 class="text-white">{{ $loop->index + 1 }}. {{ $sec->name }}</h5>
                        @if (Auth::guard('teacher')->check())
                            <a href="{{ url('/teacher/edit-section/' . $sec->id) }}"
                                class="btn btn-sm btn-primary">Rename</a>
                        @endif
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive" style="max-width: 93vw">
                            <table class="table table-borderless text-white">
                                <thead>
                                    <tr>
                                        <th>Files</th>
                                        @if (Auth::guard('teacher')->check())
                                            <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sec->file as $f)
                                        <tr>
                                            <td>
                                                <a href="{{ url('/storage/files/' . $f->file_path) }}" target="_blank"
                                                    class="text-white">{{ $f->name }}</a>
                                            </td>
                                            @if (Auth::guard('teacher')->check())
                                                <td>
                                                    <form action="{{ url('/teacher/delete-file') }}" method="POST"
                                                        onSubmit="return confirm('Are yous sure about deleting the file ' +  '{{ $f->name }}' + '?') "
                                                        class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="file_id" value="{{ $f->id }}">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (Auth::guard('teacher')->check())
                        <div class="table-responsive" style="max-width: 93vw">
                            <table class="table table-borderless text-white">
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="{{ url('/teacher/add-file/' . $sec->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-plus" style="margin-right: 3px"></i>Add File
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ url('/teacher/delete-section') }}"
                                                onSubmit="return confirm('Are yous sure about deleting the section ' +  '{{ $sec->name }}' + '?') "
                                                method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" value="{{ $sec->id }}" name="section_id">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa-solid fa-trash" style="margin-right: 3px"></i>
                                                    Delete Section
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="row">
                <h4 class="text-white mt-6 mb-4 text-center">Forms</h4>
                @foreach ($forms as $f)
                    <h5 class="text-white mt-4">{{ $loop->index + 1 }}. {{ $f->name }}</h5>
                    @if (Auth::guard('teacher')->check())
                        <div>
                            <a href="{{ url('/teacher/edit-form/' . $f->id) }}" class="btn btn-sm btn-primary">Rename</a>
                        </div>
                    @endif
                    @if (Auth::check())
                        <div class="col-sm-12">
                            <div class="table-responsive" style="max-width: 93vw">
                                <table class="table table-borderless text-white">
                                    <tbody>
                                        @foreach ($f->upload as $u)
                                            @if ($u->user_id == Auth::user()->id)
                                                <tr>
                                                    <td>
                                                        <a href="{{ url('/storage/uploads/' . $u->file_path) }}"
                                                            target="_blank" class="text-white">{{ $u->name }}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    @if (Auth::guard('teacher')->check())
                        @php
                            $form_id = $f->id;
                            $uploaded_stus_count = App\Models\User::whereHas('upload', function ($query) use ($form_id) {
                                $query->where('form_id', $form_id);
                            })->count();
                        @endphp
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="table-responsive" style="max-width: 93vw">
                                    <table class="table table-borderless text-white">
                                        <tbody>
                                            <tr>
                                                <td><span class="h5">{{ $uploaded_stus_count }}</span> students
                                                    submitted</td>
                                                <td>
                                                    <a href="{{ url('/teacher/view-form/' . $f->id) }}"
                                                        class="btn btn-sm btn-primary">View More</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div>
                        @if (Auth::check())
                            @if (count($f->upload) > 0)
                                <a href="{{ url('/student/create-upload/' . $f->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa-solid fa-folder-arrow-up" style="margin-right: :5px"></i>Resubmit</a>
                            @else
                                <a href="{{ url('/student/create-upload/' . $f->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa-solid fa-folder-arrow-up" style="margin-right: :5px"></i>Submit</a>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
