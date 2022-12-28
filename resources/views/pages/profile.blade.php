@extends('layouts/pages_layout')

@section('content')

    <div class="col-md-10 col-lg-8 col-xl-6 mx-auto p-3">
        <div class="p-2">
            <div>
                @if( auth()->user()->profile )
                    <img class="rounded-circle profile" height="150" width="150" src="{{ asset('uploads/profiles/'.auth()->user()->profile) }}" alt="">
                @else
                    <img class="profile" height="150" width="150" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG91Ivd0CD1UA-3GKi8OPGqO9BZvrfsclJFujvxLWQU6z0UR5xNec89_mVGFysedGeUo0&usqp=CAU" alt="">
                @endif
            </div>
            <div class="mt-3">
                <p><span class="me-3 body-fs">Name</span> <span class="title-fs2 name"> {{auth()->user()->name}} </span></p>
                <p><span class="me-3 body-fs">Email</span> <span class="title-fs2 email"> {{auth()->user()->email}} </span></p>
{{--                <p><span class="me-3 body-fs">Password</span> <span class="title-fs2"> {{ auth()->user()->password, false }} </span></p>--}}

                <a class="mt-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#profile-edit">Edit</a>
            </div>

            {{-- modal box start  --}}
            <div class="modal fade" id="profile-edit" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-5 body-fs">
                            <div>
                                <form id="profile_edit_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                    <label for="thumbnail" class="form-label">Profile picture</label>
                                    <div class="input-group">
                                        <input type="file" name="thumbnail" id="name" class="form-control file-input" placeholder="Enter your new image">
                                        <button class="btn btn-primary profile_edit_btn">Update</button>
                                    </div>
                                </form>
                            </div>
                            <div class="my-3">
                                <form id="name_edit_form" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                    <label for="name" class="form-label">Name</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control name-input" placeholder="Enter your new name">
                                        <button class="btn btn-primary name_edit_btn">Update</button>
                                    </div>
                                </form>
                            </div>
                            <div>
                                <form id="email_edit_form" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="email" name="email" id="email" class="form-control email-input" placeholder="Enter your new email">
                                        <button class="btn btn-primary email_edit_btn">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal box end  --}}

        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function () {

            $('#profile_edit_form').on('submit', function(e){
                e.preventDefault();
                $('button').attr('disabled', '');
                let formData = new FormData($('#profile_edit_form')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('updateProfile') }}",
                    statusCode: {
                        404: function() {
                            alert('404')
                        },
                        403: function() {
                            alert('403')
                        },
                        422: function() {
                            alert('422')
                        },
                        500: function() {
                            alert('500')
                        }
                    } ,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        if (response.status == true){
                            alert(response.message);
                            $('.profile').attr('src', 'uploads/profiles/' + response.data);
                            $('.file-input').val('');
                            $('button').removeAttr('disabled');
                        } else {
                            alert(response.message);
                            $('button').removeAttr('disabled');
                        }

                    },
                });
            })

            $('#name_edit_form').on('submit', function(e){
                e.preventDefault();
                $('button').attr('disabled', '');
                let formData = new FormData($('#name_edit_form')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('updateName') }}",
                    statusCode: {
                        404: function() {
                            alert('404')
                        },
                        403: function() {
                            alert('403')
                        },
                        422: function() {
                            alert('422')
                        },
                        500: function() {
                            alert('500')
                        }
                    } ,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        if (response.status == true){
                            alert(response.message);
                            $('.name').html(response.data);
                            $('.name-input').val('');
                            $('button').removeAttr('disabled');
                        } else {
                            alert(response.message);
                            $('button').removeAttr('disabled');
                        }

                    },
                });
            })

            $('#email_edit_form').on('submit', function(e){
                e.preventDefault();
                $('button').attr('disabled', '');
                let formData = new FormData($('#email_edit_form')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('updateEmail') }}",
                    statusCode: {
                        404: function() {
                            alert('404')
                        },
                        403: function() {
                            alert('403')
                        },
                        422: function() {
                            alert('422')
                        },
                        500: function() {
                            alert('500')
                        }
                    } ,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        if (response.status == true){
                            alert(response.message);
                            $('.email').html(response.data);
                            $('.email-input').val('');
                            $('button').removeAttr('disabled');
                        } else {
                            alert(response.message);
                            $('button').removeAttr('disabled');
                        }

                    },
                });
            })

        })
    </script>


@endsection
