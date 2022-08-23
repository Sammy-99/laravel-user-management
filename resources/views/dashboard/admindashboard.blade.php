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

    <div class="row vh-100">
        <div class="col-md-2 border">

              <div class="list-group mt-4">
                <input type="hidden" id="currentTab" value="student">
                <a href="#" class="list-group-item list-group-item-action text-white bg-primary sidebar" id="student" value="student">Students List</a>
                <a href="#" class="list-group-item list-group-item-action sidebar" id="teacher" value="teacher">Teacher List</a>
                <a href="#" class="list-group-item list-group-item-action sidebar" id="pending-req" value="pending-req">Pending Request
                    <span class="p-1 rounded-circle text-white " id="count">                                           
                    </span>
                </a>
              </div>
              
        </div>
        

        <div class="col-md-10 border">
            <div class=" m-4" id="data-table">

            </div>
        </div>

    </div>

    <!-- modal html code start -->


<div class="modal fade bd-example-modal-lg" id="compose-email-modal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">User Data</h5>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> -->
            </button>
        </div>
        <div class="modal-body">
            <form id="user-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="hidden" id="current-student" value="">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <img alt="User Image" id="user-img" style="width: 200px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 ">
                            <label for="user-name" class="col-form-label"> Name </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class="" name="user-name" id="user-name"></span>
                            {{-- <input type="text" class=" " name="user-name" id="user-name"> --}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3 ">
                            <label for="user-email" class="col-form-label"> Email </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="user-email" id="user-email"></span>
                            {{-- <input type="text" class=" " name="user-email" id="user-email"> --}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3 ">
                            <label for="user-address" class="col-form-label"> Address </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="user-address" id="user-address"></span>
                            {{-- <input type="text" class=" " name="user-address" id="user-address"> --}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3 ">
                            <label for="c-school" class="col-form-label">Current School </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="c-school" id="c-school"></span>
                            {{-- <input type="text" class=" " name="c-school" id="c-school"> --}}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3 ">
                            <label for="p-school" class="col-form-label">Previous School </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="p-school" id="p-school"></span>
                            {{-- <input type="text" class=" " name="p-school" id="p-school"> --}}
                        </div>
                    </div>

                    <div class="row mt-3 parents">
                        <div class="col-md-3 ">
                            <label for="parents" class="col-form-label">Parent's Details </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="parents" id="parents"></span>
                            {{-- <input type="text" class=" " name="parents" id="parents"> --}}
                        </div>
                    </div>

                    <div class="row mt-3 assign-teacher">
                        <div class="col-md-3 ">
                            <label for="assign-teacher" class="col-form-label"> Assigned Teacher </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="assign-teacher" id="assign-teacher"></span>
                            {{-- <input type="text" class=" " name="parents" id="parents"> --}}
                        </div>
                    </div>

                    <div class="row mt-3 assign-teacher-dropdown">
                        <div class="col-md-3 ">
                            <label for="assign-teacher-dropdown" class="col-form-label"> Assign Teacher </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <select class="form-select w-50" aria-label="Default select example" id="assign-teacher-dropdown" name="assign-teacher-dropdown">
                                {{-- <option selected >Select Teacher</option> --}}
                                {{-- <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option> --}}
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3 experience">
                        <div class="col-md-3 ">
                            <label for="experience" class="col-form-label"> Experience </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="experience" id="experience"></span> year
                            {{-- <input type="text" class=" " name="experience" id="experience"> --}}
                        </div>
                    </div>

                    <div class="row mt-3 expert-in">
                        <div class="col-md-3">
                            <label for="experience" class="col-form-label"> Expert In </label>
                        </div>
                        <div class="col-md-9 mt-2">
                            : <span class=" " name="expert-in" id="expert-in"> </span>
                            {{-- <input type="text" class=" " name="experience" id="experience"> --}}
                        </div>
                    </div>
                </div>
                <hr>

                    <div class="row">
                        <div class="col-md-7 ">
                        </div>

                        <div class="col-md-5">
                            <button type="button" class="btn btn-outline-success" id="assign-btn">Assign Teacher</button>
                            <button type="button" class="btn btn-outline-danger close mr-3" data-bs-dismiss="modal"
                                value="3">Close</button>

                        </div>
                    </div>
            </form>
        </div>
        <!-- <div class="modal-footer">
            
        </div> -->
    </div>
</div>
</div>

<!-- modal html code end -->


</div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {

            getDashboardData();
            gerPendingRequest();

            $(".sidebar").click(function(){
                $(".sidebar").removeClass("bg-primary");
                $(".sidebar").removeClass("text-white");
                
                $(this).addClass("bg-primary");
                $(this).addClass("text-white");
            });

            // function activeSidebar(){
                
            // }

            $("#student").click(function(){
                $("#currentTab").val('student');
                getDashboardData();
            });

            $("#teacher").click(function(){
                $("#currentTab").val('teacher');
                getDashboardData();
            });

            $("#pending-req").click(function(){
                $("#currentTab").val('pending-req');
                getDashboardData();
            });

            /**
             * Assign teacher to the student.
            */
            $("#assign-btn").click(function(){

                var teacher = $("#assign-teacher-dropdown").val();
                var current_stu = $("#current-student").val();

                if(teacher != '' || teacher != null){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ asset('assign-teacher') }}",
                        type: "post",
                        data: {current_stu, teacher},
                        success: function (response) { 
                            var res = JSON.parse(response);
                            console.log(response);
                            alert(res.message);
                            $("#compose-email-modal").modal("hide");
                        }
                    })
                }
                console.log(teacher);
            })

            /**
             * View Users data.
            */
            $(document).on("click", "#datatable tr", function(){

                var user_id = $(this).find('input:hidden').val();
                getUserData(user_id);
                $("#compose-email-modal").modal("show");

            });

            function getUserData(user_id){

                $.ajax({
                    url: "{{ asset('get-single-user-data') }}",
                    type: "GET",
                    data: {user_id},
                    success: function(response){
                        var res = JSON.parse(response);
                        console.log(res);
                        if(res.status == true){
                            var img = "./uploads/" + res.data.user_img + "";
                            $("#user-name").text(res.data.name);
                            $("#user-email").text(res.data.email);
                            $("#user-address").text(res.data.address);
                            $("#c-school").text(res.data.current_school);
                            $("#p-school").text(res.data.previous_school);
                            $("#user-img").attr("src", img);

                            if(res.data.role == 1){
                                $(".parents, .assign-teacher, .assign-teacher-dropdown").hide();
                                $(".experience, .expert-in").show();
                                // $(".expert-in").show();
                                $("#experience").text(res.data.experience);
                                $("#expert-in").text(res.data.subject_name);
                            }else{
                                $("#current-student").val('');
                                $("#current-student").val(res.data.id);

                                $(".experience, .expert-in").hide();
                                $(".parents, .assign-teacher, .assign-teacher-dropdown").show();

                                $("#assign-teacher").text(res.data.teacher);
                                $("#parents").text(res.data.parents_details);
                                $("#assign-teacher-dropdown").html('');      
                                $("#assign-teacher-dropdown").append(res.teachers);                           
                            }

                        }
                    }
                });
            }
            
            /**
             * show dashboard data when admin login.
            */
            function getDashboardData(){

                var current_tab = $("#currentTab").val();

                $.ajax({
                    url: "{{ asset('get-dashboard-data') }}",
                    type: "GET",
                    data: {current_tab},
                    success: function(response){
                        var res = JSON.parse(response);
                        console.log(res);
                        if(res.status == true){
                            $("#data-table").html('');
                            $("#data-table").append(res.data);
                        }

                        if(res.status == false){
                            $("#data-table").html('');
                            $("#data-table").html(res.message);
                        }
                    }
                });
            }

            /**
             * return the pending request count.
            */
            function gerPendingRequest(){
                $.ajax({
                    url: "{{ asset('pending-request') }}",
                    type: "get",
                    success: function(response){
                        var res = JSON.parse(response);
                        console.log(res);
                        if(res.data != null){
                            $("#count").text(res.data);
                            $("#count").addClass("bg-danger");
                        }else{
                            $("#count").text('');
                            $("#count").removeClass("bg-danger");
                        }
                    }
                })
            }

            /**
             * This function responsible for actions (delete/approve request) on users profile.
            */
            $(document).on("click", ".action-btn", function(event){
                event.stopPropagation();

                var id = $(this).attr("id"); 
                var user_id = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ asset('request-action') }}",
                    type: "post",
                    data: {id, user_id},
                    success: function(response){
                        var res = JSON.parse(response);
                        console.log(res);
                        
                        if(res.type == "request_approved"){
                            alert("Request Approved");
                        }
                        else if (res.type == "request_deleted"){
                            alert("Deleted Successfully");
                        }
                        else if (res.status == false){
                            alert("Something went wrong");
                        }

                        getDashboardData();
                        gerPendingRequest();
                    }
                })
            });

        });
    </script>
@endsection