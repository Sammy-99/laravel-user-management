@extends('layout.main')

@section('content')
    <div class="container">
        <!-- custom alert start -->
        <div class="col-lg-4 col-md-4 col-sm-5 ml-auto d-none rightSideAlert">
            <div class="alert alert-success fade show add-alert-prop" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="True">&times;</span>
                </button>
                <h4 class="alert-heading"></h4>
                <p class="alert-message"></p>
            </div>
        </div>
        <!-- custom alert end -->
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8 mt-4 border reg-form">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-left reg-label font-weight-bold">Login with your account</h3>
                    </div>
                </div>
                <hr>

                <form action="{{ asset('login') }}" id="registration-form" method="post">
                    @csrf
                    <div class="row mb-4">
                        <div class="">

                            <div class="form-outline">
                                {{-- <label class="form-label font-weight-bold" for="useremail">Email</label> --}}
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Your Email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <br>

                            <div class="form-outline">
                                {{-- <label class="form-label font-weight-bold" for="firstname">Firstname</label> --}}
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter Password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <br>

                        </div>

                        {{-- <div class="col-sm-5 text-center order-1 order-md-2 mt-4"></div> --}}

                    </div>

                    <div class="row">
                        <div>
                            @if(session()->has('error'))
                                <span class="text-danger fw-bold"> {{ session('error') }} </span><br><br>
                            @endif
                        </div>
                        
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary btn-block px-4 mb-4 signup-btn">Sign In</button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary btn-block px-4 mb-4 signup-btn">
                                <a class="text-decoration-none text-white" href="{{ asset('signup') }}"> Sign Up </a>
                            </button>
                        </div>
                        <div class="col-sm-6 font-weight-bold mt-2">
                            {{-- <span> Signup as a teacher ?  <a href="{{ asset('signup') }}"> click here </a></span> --}}
                        </div>
                    </div>
                    <br>

                </form>
            </div>
            <div class="col-md-2">
            </div>

        </div>
    </div>
@endsection

