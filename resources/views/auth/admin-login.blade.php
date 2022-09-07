@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="card-transparent text-white mt-5">
                <div class="card-header">
                    <h4>Login as an Admin</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/login/admin') }}" method="POST">
                        @csrf
                        @if ($errors->has('error'))
                            <span class="text-danger bg-white">{{ $errors->first('error') }}</span>
                        @endif
                        <div class="form-group">
                            <label for="inputEmail" class="form-label"><i class="fa-solid fa-envelope"
                                    style="margin-right: 5px"></i>Enter
                                email</label>
                            <input type="email" name="email" id="inputEmail" class="form-control" />
                            @if ($errors->has('email'))
                                <span class="text-danger bg-white">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="inputPassword" class="form-label"><i class="fa-solid fa-key"
                                    style="margin-right: 5px"></i>Enter
                                password</label>
                            <input type="password" name="password" id="inputPassword" class="form-control" />
                            @if ($errors->has('password'))
                                <span class="text-danger bg-white">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <button type="submit" class="btn text-white mt-3" style="background-color:#5C258D">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection
