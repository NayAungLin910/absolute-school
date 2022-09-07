@extends('layout.dashboard')
@section('style')
    <style>
        /* @media (max-width: 767px) {
                            #res-div {
                                margin-left: 10px !important;
                                margin-right: 0px !important;
                                padding: 0 !important;
                            }
                        } */
    </style>
@endsection
@section('dash-content')
    <div class="row">
        <div class="col-sm-7 rounded card-color-purple text-white" style="margin-left: 6px; margin-right: 0px; padding: 0px;">
            <div class="table-responsive" style="max-width: 93vw">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                @if (Auth::check())
                                    <img src="{{ url('/storage/images/' . Auth::user()->image) }}" class="rounded-circle"
                                        alt="{{ Auth::user()->name }}" width="130">
                                @endif
                                @if (Auth::guard('teacher')->check())
                                    <img src="{{ url('/storage/images/' . Auth::guard('teacher')->user()->image) }}"
                                        class="rounded-circle" alt="{{ Auth::guard('teacher')->user()->name }}"
                                        width="130">
                                @endif
                            </td>
                            <td>
                                <div class="table-responsive" style="max-width: 93vw">
                                    <table class="table table-borderless text-white h5">
                                        <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td>
                                                    @if (Auth::check())
                                                        {{ Auth::user()->name }}
                                                    @endif
                                                    @if (Auth::guard('teacher')->check())
                                                        {{ Auth::guard('teacher')->user()->name }}
                                                    @endif
                                                    @if (Auth::guard('moderator')->check())
                                                        {{ Auth::guard('moderator')->user()->name }}
                                                    @endif
                                                    @if (Auth::guard('admin')->check())
                                                        {{ Auth::guard('admin')->user()->name }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Email
                                                </td>
                                                <td>
                                                    @if (Auth::check())
                                                        {{ Auth::user()->email }}
                                                    @endif
                                                    @if (Auth::guard('teacher')->check())
                                                        {{ Auth::guard('teacher')->user()->email }}
                                                    @endif
                                                    @if (Auth::guard('moderator')->check())
                                                        {{ Auth::guard('moderator')->user()->email }}
                                                    @endif
                                                    @if (Auth::guard('admin')->check())
                                                        {{ Auth::guard('admin')->user()->email }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Role</td>
                                                <td>
                                                    @if (Auth::check())
                                                        <span class="badge" style="background-color: rgb(82, 134, 245)">
                                                            Student
                                                        </span>
                                                    @endif
                                                    @if (Auth::guard('teacher')->check())
                                                        <span class="badge" style="background-color: rgb(107, 43, 192)">
                                                            Teacher
                                                        </span>
                                                    @endif
                                                    @if (Auth::guard('moderator')->check())
                                                        <span class="badge" style="background-color: rgb(67, 201, 118)">
                                                            Moderator
                                                        </span>
                                                    @endif
                                                    @if (Auth::guard('admin')->check())
                                                        <span class="badge" style="background-color: rgb(245, 82, 82)">
                                                            Admin
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if (Auth::guard('teacher')->check())
                                                <tr>
                                                    <td>Batch Count</td>
                                                    <td>{{ $batch_count }}</td>
                                                </tr>
                                            @endif
                                            @if (Auth::check() || Auth::guard('teacher')->check())
                                                <tr>
                                                    <td>Subject Count</td>
                                                    <td>{{ $subject_count }}</td>
                                                </tr>
                                            @endif
                                            @if (Auth::check())
                                                <tr>
                                                    <td>Batch</td>
                                                    <td>{{ $batch_name }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
