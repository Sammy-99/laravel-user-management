<?php
// echo "<pre>";
//     print_r($userData->toArray());
//     die(" nn ");

    $updateroute = ($userData->role == 1) ? 'update-teacher' : 'update-student' ;

?>


@extends('layout.main')

@section('content')
    <div class="container-fluid">
        <div class="row pt-1 pb-1" style="background: #a28089">
            <div class="col-8 col-md-8 mt-2 fw-bold">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <h2 class="fw-bold"> Welcome </h2>
                </nav>
            </div>

            <div class="col-4 col-md-4 ">
                <nav class="navbar navbar-expand-sm">
                    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbar-list-4">
                        {{-- <div class="user-name text-light"> </div> &nbsp; --}}

                    </div>
                    <div class="collapse navbar-collapse d-flex justify-content-end mt-2" id="navbar-list-4">
                        <button type="button" class="btn btn-primary">
                            <a href="{{ route('logout') }}" class="text-light"> Logout</a>
                        </button>
                    </div>
                </nav>


            </div>
        </div>
        <br>

        <div class="row my-4">
            <div class="col-md-2 col-lg-2"></div>
            <div class="col-md-8 col-lg-8">
                <div class="row ">
                    <form action="{{ route($updateroute, ['id' => $userData->id]) }}" id="edit-user-details-form"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 col-lg-12 profile_input">
                            <div class="row ms-2">
                                <div class="col-lg-8 my-4 order-2 order-lg-1">

                                    <div>
                                        <label for=""> Name : </label>
                                        {{-- <span id="FirstName" class=" mb-3" value="{{ $userData->name }}"> {{ $userData->name }}
                                    </span> --}}
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-lg w-75 mb-3" value="{{ $userData->name }}" />
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    <div>
                                        <label for=""> Email : </label>
                                        {{-- <span id="email" class=" mb-3" value="{{ $userData->email }}">
                                        {{ $userData->email }} </span> --}}
                                        <input type="text" id="email" name="email"
                                            class="form-control form-control-lg w-75 mb-3" value="{{ $userData->email }}" />
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <label for=""> Address : </label>
                                        {{-- <span id="email" class=" mb-3" value="{{ $userData->address }}">
                                        {{ $userData->address }} </span> --}}
                                        <input type="text" id="address" name="address"
                                            class="form-control form-control-lg w-75 mb-3"
                                            value="{{ $userData->address }}" />
                                            @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <label for=""> Current School : </label>
                                        {{-- <span id="email" class=" mb-3" value="{{ $userData->current_school }}">
                                        {{ $userData->current_school }} </span> --}}
                                        <input type="text" id="c_school" name="c_school"
                                            class="form-control form-control-lg w-75 mb-3"
                                            value="{{ $userData->current_school }}" />
                                            @if ($errors->has('c_school'))
                                            <span class="text-danger">{{ $errors->first('c_school') }}</span>
                                        @endif
                                    </div>

                                    <div>
                                        <label for=""> Previous School : </label>
                                        {{-- <span id="email" class=" mb-3" value="{{ $userData->previous_school }}">
                                        {{ $userData->previous_school }} </span> --}}
                                        <input type="text" id="p_school" name="p_school"
                                            class="form-control form-control-lg w-75 mb-3"
                                            value="{{ $userData->previous_school }}" />
                                            @if ($errors->has('p_school'))
                                            <span class="text-danger">{{ $errors->first('p_school') }}</span>
                                        @endif
                                    </div>

                                    @if ($userRole == 2)
                                        <div>
                                            <label for=""> Parents Details : </label>
                                            {{-- <span id="email" class=" mb-3" value="{{ $parents['father'] }}">
                                            {{ $parents['father'] }} </span> --}}
                                            <input type="text" id="parents_details" name="parents_details"
                                                class="form-control form-control-lg w-75 mb-3"
                                                value="{{ $userData->parents_details }}" />
                                                @if ($errors->has('parents_details'))
                                                <span class="text-danger">{{ $errors->first('parents_details') }}</span>
                                            @endif
                                        </div>

                                        <div>
                                            <label for=""> Assigned Teacher : </label>
                                            {{-- <span id="email" class=" mb-3" value="{{ $userData->assigned_teacher }}">
                                            {{ $userData->assigned_teacher }} </span> --}}
                                            <input type="text" id="assign_teacher" name="assign_teacher"
                                                class="form-control form-control-lg w-75 mb-3"
                                                value="{{ $userData->teacher }}"  disabled/>
                                                @if ($errors->has('assign_teacher'))
                                                <span class="text-danger">{{ $errors->first('assign_teacher') }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <div>
                                            <label for=""> Experience : </label>
                                            {{-- <span id="experience" class=" mb-3" value="{{ $userData->experience }}">
                                            {{ $userData->experience }} year</span> --}}
                                            <input type="text" id="experience" name="experience"
                                                class="form-control form-control-lg w-75 mb-3"
                                                value="{{ $userData->experience }}" />
                                                @if ($errors->has('experience'))
                                                <span class="text-danger">{{ $errors->first('experience') }}</span>
                                            @endif
                                        </div>

                                        <div>
                                            <label for=""> Expertise Subject : </label>
                                            {{-- <span id="email" class=" mb-3" value="{{ $userData->expert_in_subj }}">
                                            {{ $userData->expert_in_subj }} </span> --}}
                                            <input type="text" id="subjects" name="subjects"
                                                class="form-control form-control-lg w-75 mb-3"
                                                value="{{ $userData->subject_name }}" />
                                                @if ($errors->has('subjects'))
                                                <span class="text-danger">{{ $errors->first('subjects') }}</span>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                                <div class="col-lg-4 mb-5 order-1 order-lg-2">
                                    <img src="./uploads/{{ $userData->user_img }}" alt="userimage" width="200px"
                                        class="" id="userImgPreview">
                                    <div>
                                        <input type="file" name="updated_user_mage" id="updated_user_mage" hidden>
                                        {{-- <input type="hidden" name="current_user_img" value="{{ $userData->user_img }}"> --}}
                                        <label class="font-weight-bolder text-primary ml-5" for="updated_user_mage"
                                            style="cursor: pointer;"> Upload Image </label>
                                        <br>
                                        @if ($errors->has('updated_user_mage'))
                                                <span class="text-danger">{{ $errors->first('updated_user_mage') }}</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ms-4 mb-4">
                                <div>
                                    @if(session()->has('success'))
                                        <span class="text-success fw-bold"> {{ session('success') }} </span><br><br>
                                    @endif
                                    @if(session()->has('error'))
                                        <span class="text-danger fw-bold"> {{ session('error') }} </span><br><br>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-outline-success py-1  w-25">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row ml-3 mt-5 mb-5">
                </div>
            </div>
            <div class="col-md-2 col-lg-2"></div>
        </div>
    </div>
@endsection


@section('script')
    <script>

        $(document).ready(function() {
            $("#updated_user_mage").on("change", function() {
                const [file] = (this).files;
                var url = '{{ url('/') }}' + '/images/p.png';
                console.log(url);
                if (file) {
                    userImgPreview.src = URL.createObjectURL(file)
                } else {
                    console.log('sdkl')
                    $('#userImgPreview').prop("src", url);
                }
            });
        });
    </script>
@endsection
