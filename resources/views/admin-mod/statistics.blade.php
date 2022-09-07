@extends('layout.dashboard')
@section('style')
    <style>
        .bg-color-gradient-blue {
            background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-color-gradient-purple {
            background-image: linear-gradient(to right, #b8cbb8 0%, #b8cbb8 0%, #b465da 0%, #cf6cc9 33%, #ee609c 66%, #ee609c 100%);
        }

        .bg-color-gradient-green {
            background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);
        }

        .bg-color-gradient-orange {
            background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
        }
    </style>
@endsection
@section('dash-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3">
                    <div class="rounded bg-color-gradient-blue text-center text-white container p-3 mt-3">
                        <h2>Admins</h2>
                        <span class="h3">{{ $admin_count }}</span> users
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="rounded bg-color-gradient-purple text-center text-white container mt-3 pt-3 pl-3 pr-3 pb-4">
                        <h3>Moderators</h3>
                        <span class="h3">{{ $moderator_count }}</span> users
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="rounded bg-color-gradient-green text-center text-white container p-3 mt-3">
                        <h2>Teachers</h2>
                        <span class="h3">{{ $teacher_count }}</span> users
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="rounded bg-color-gradient-orange text-center text-white container p-3 mt-3">
                        <h2>Students</h2>
                        <span class="h3">{{ $student_count }}</span> users
                    </div>
                </div>
            </div>
        </div>
        <!-- react component of statistics -->
        <div id="root"></div>
        <script src="{{ mix('js/liveStatistics.js') }}"></script>
    </div>
@endsection
