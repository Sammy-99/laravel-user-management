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
                        <h3 class="text-left reg-label font-weight-bold">Create Your Account</h3>
                    </div>
                </div>
                <hr>

                <form action="{{ asset('tchr-signup') }}" id="registration-form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-sm-7 order-2 order-md-1">

                            <div class="form-outline">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter Your Name" value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                            <br>

                            <div class="form-outline">
                                <input type="text" class="form-control" id="useremail" name="useremail"
                                    placeholder="Enter Your Email" value="{{ old('useremail') }}">
                                @if ($errors->has('useremail'))
                                    <span class="text-danger">{{ $errors->first('useremail') }}</span>
                                @endif
                            </div>
                            <br>

                            <div class="form-outline">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter Password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <br>

                            <div class="form-outline">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Enter Confirm Password"
                                    value="{{ old('password_confirmation') }}">
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-5 text-center order-1 order-md-2 mt-4">
                            <div class="form-outline">
                                <div>
                                    <img src="{{ asset('images/p.png') }}" id="previews" class="mt-4" width="100px"
                                        alt="">
                                </div>
                                <br>
                                <input type="file" hidden id="user-image" class="form-control" name="user-image" />
                                <label class="form-label btn-link cursor-pointer font-weight-bold" for="user-image"
                                    style="cursor: pointer;">Upload Image</label>
                                <br>
                                @if ($errors->has('user-image'))
                                    <span class="text-danger">{{ $errors->first('user-image') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" class="form-control" id="user-address" name="user-address"
                            placeholder="Enter Your Address" value="{{ old('user-address') }}">
                        @if ($errors->has('user-address'))
                            <span class="text-danger">{{ $errors->first('user-address') }}</span>
                        @endif
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" class="form-control" id="current-school" name="current-school"
                            placeholder="Current School Name" value="{{ old('current-school') }}">
                        @if ($errors->has('current-school'))
                            <span class="text-danger">{{ $errors->first('current-school') }}</span>
                        @endif
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" class="form-control" id="previous-school" name="previous-school"
                            placeholder="Previous School Name" value="{{ old('previous-school') }}">
                        @if ($errors->has('previous-school'))
                            <span class="text-danger">{{ $errors->first('previous-school') }}</span>
                        @endif
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" class="form-control" id="experience" name="experience"
                            placeholder="Experience in years" value="{{ old('experience') }}">
                        @if ($errors->has('experience'))
                            <span class="text-danger">{{ $errors->first('experience') }}</span>
                        @endif
                    </div>

                    <div class="form-outline mb-4 subjects">
                        <select class="form-select" aria-label="Default select example" id="expertise" name="expertise">
                            <option selected disabled>Select subject</option>
                            {{-- <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option> --}}
                        </select>
                        @if ($errors->has('expertise'))
                            <span class="text-danger">{{ $errors->first('expertise') }}</span>
                        @endif
                    </div>

                    <div class="row">
                        <div>
                            @if (session()->has('success'))
                                <span class="text-success fw-bold"> {{ session('success') }} </span><br><br>
                            @endif
                            @if (session()->has('error'))
                                <span class="text-danger fw-bold"> {{ session('error') }} </span><br><br>
                            @endif
                        </div>

                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary btn-block px-4 mb-4 signup-btn">Sign Up</button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary btn-block px-4 mb-4 signup-btn">
                                <a class="text-white text-decoration-none" href="{{ asset('signin') }}"> Sign In </a>
                            </button>
                        </div>
                        <div class="col-sm-6 font-weight-bold mt-2">
                            <span> Signup as a student ? <a href="{{ asset('/') }}"> click here </a></span>

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



@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#user-image").on("change", function() {
                const [file] = (this).files;
                var url = '{{ url('/') }}' + '/images/p.png';
                console.log(url);
                if (file) {
                    previews.src = URL.createObjectURL(file)
                } else {
                    console.log('sdkl')
                    $('#previews').prop("src", url);
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "{{ asset('/get-subject') }}",
                success: function(data) {
                    console.log(data);
                    if(data.status == true){
                        $(".subjects select").append(data.subjects);
                    }
                }
            });
        });
    </script>
@endsection
