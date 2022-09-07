@extends('layout.master')
@section('content')
    <div class="wrapper">
        <!-- sidebar nav -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fa-solid fa-list" style="margin-right: 5px"></i> Features</h3>
            </div>
            <ul class="list-unstyled components">
                @if (Auth::guard('admin')->check() || Auth::guard('moderator')->check())
                    <li class="{{ request()->is('admin-mod/statistics') ? 'active' : '' }}">
                        <a href="{{ url('/admin-mod/statistics') }}"><i class="fa-solid fa-chart-line"></i>Statistics</a>
                    </li>
                    <li class="nav-item dropdown {{ request()->is('admin-mod/approve*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-square-check" style="margin-right: 5px"></i>Approve
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/admin-mod/approve-student') }}">Student</a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin-mod/approve-teacher') }}">Teacher</a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin-mod/approve-moderator') }}">Moderator</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown {{ request()->is('admin-mod/batch*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Batch
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('batch.create') }}">Create Batch</a></li>
                            <li><a class="dropdown-item" href="{{ route('batch.index') }}">Batches</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown {{ request()->is('admin-mod/subject*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Subject
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/admin-mod/subject/create') }}">Create Subject</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/admin-mod/subject') }}">Subjects</a></li>
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('admin')->check() || Auth::guard('moderator')->check() || Auth::guard('teacher')->check())
                    <li
                        class="nav-item dropdown {{ request()->is('admin-mod-teacher/search*') ? 'active' : '' }} {{ request()->is('admin-mod/search*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-magnifying-glass" style="margin-right:5px"></i>Search Accounts
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::guard('admin')->check() || Auth::guard('moderator')->check())
                                <li><a class="dropdown-item" href="{{ url('/admin-mod/search-moderator') }}">Moderator</a>
                                </li>
                            @endif
                            @if (Auth::guard('admin')->check() || Auth::guard('moderator')->check() || Auth::guard('teacher')->check())
                                <li><a class="dropdown-item"
                                        href="{{ url('/admin-mod-teacher/search-teacher') }}">Teacher</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ url('/admin-mod-teacher/search-student') }}">Student</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('teacher')->check() || Auth::check())
                    <li
                        class="
                            {{ request()->is('teacher-student/your-subjects*') ? 'active' : '' }} 
                            {{ request()->is('teacher/edit-zoom-info*') ? 'active' : '' }} 
                            {{ request()->is('teacher/create-section*') ? 'active' : '' }}
                            {{ request()->is('teacher/edit-section*') ? 'active' : '' }}
                            {{ request()->is('teacher/add-file*') ? 'active' : '' }}
                            {{ request()->is('teacher/create-form*') ? 'active' : '' }}
                            {{ request()->is('student/create-upload*') ? 'active' : '' }}
                        ">
                        <a href="{{ url('/teacher-student/your-subjects') }}">
                            <i class="fa-solid fa-book" style="margin-right:5px"></i>Your subjects
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- sidebar content -->
        <div id="content">
            <div class="row">
                <div class="col-sm-12">
                    <button type="button" id="sidebarCollapse" class="btn" style="background-color: #6D7FCC">
                        <i class="fas fa-list text-white"></i>
                    </button>
                </div>
            </div>
            <div class="mt-4">
                <div class="row">
                    <div class="row">
                        <div class="col-sm-12" style="margin-left: 10px">
                            <!-- content for child blade files -->
                            @yield('dash-content')
                            <!-- invisible text to widen the wrapper -->
                            <p style="opacity: 0.0;">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt tempora voluptas tempora
                                voluptas
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt tempora voluptas tempora
                                voluptas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
