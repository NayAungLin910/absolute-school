<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absolute High School</title>
    <link rel="icon" href="{{ url('/icons/absolute-highschool-logo-dark-transparent.png') }}">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=Montserrat:wght@300;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- appvarun totastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">

    <!-- css content for child blade fields -->
    @yield('style')
</head>

<body>
    <!-- top nav bar -->
    <nav class="navbar navbar-expand-lg" id="nav-transparent">
        <div class="p-2">
            <img src="{{ url('/icons/absolute-highschool-logo-dark-transparent.png') }}" alt="" width="100">
        </div>
        <div class="container-fluid">
            <h5>
                <h5>
                    <a class="navbar-brand text-white" href="#"></a>
                </h5>
            </h5>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="">
                    <i class="fa-solid fa-bars text-white"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav text-center">
                    <!-- if logged in -->
                    @if (Auth::check() ||
                        Auth::guard('admin')->check() ||
                        Auth::guard('moderator')->check() ||
                        Auth::guard('teacher')->check())
                        <li class="nav-item">
                            <h5>
                                <a class="nav-link text-white" href="{{ url('/profile') }}">
                                    <i class="fa-solid fa-address-card"></i>
                                    Profile
                                </a>
                            </h5>
                        </li>
                    @endif
                    <!-- if not logged in -->
                    @if (!Auth::check() &&
                        !Auth::guard('admin')->check() &&
                        !Auth::guard('moderator')->check() &&
                        !Auth::guard('teacher')->check())
                        <h5>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-key" style="margin-right: 5px"></i>Login
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ url('/login/student') }}">Student</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/login/teacher') }}">Teacher</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/login/moderator') }}">Moderator</a></li>
                                </ul>
                            </li>
                        </h5>
                        <h5>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-file-pen" style="margin-right: 5px"></i>Register
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ url('/register/student') }}">Student</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('/register/teacher') }}">Teacher</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('/register/moderator') }}">Moderator</a>
                                    </li>
                                </ul>
                            </li>
                        </h5>
                        <!-- if not logged in -->
                    @else
                        <li class="nav-item">
                            <h5>
                                <a class="nav-link active text-white" aria-current="page" href="{{ url('/logout') }}">
                                    <i class="fa-solid fa-door-open" style="margin-right: 5px"></i>Logout</a>
                            </h5>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- inner content for child blade files -->
                @yield('content')
            </div>
        </div>
    </div>
    </div>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- appvaran Toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- custom jss-->
    <script>
        // global logined user data
        @if (Auth::guard('admin')->check())
            window.auth = @json(Auth::guard('admin')->user());
        @endif
        window.auth = @json(auth()->user());

        // sidebar toggle
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

        });
    </script>

    <!-- Session flashing -->
    @if (session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                // className: ['bg-danger'],
                style: {
                    background: "linear-gradient(to right, #F58C7E, #F02C11)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('info'))
        <script>
            Toastify({
                text: "{{ session('info') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #76CA86, #35CD52)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif

    <!-- custom script for child blade files -->
    @yield('script')
</body>

</html>
