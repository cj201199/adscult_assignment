@extends('layout')
@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <form id="registrationform">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" class="form-control" name="name" required
                                            autofocus>

                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email"
                                            required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="registrationformbutton"
                                        class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#registrationformbutton').on('click', function() {
                $('#registrationform').validate({
                    rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 6
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter your name"
                        },
                        email: {
                            required: "Please enter your email address",
                            email: "Please enter a valid email address"
                        },
                        password: {
                            required: "Please enter your password",
                            minlength: "Password must be at least 6 characters"
                        }
                    },
                    submitHandler: function(form) {
                        var formData = new FormData(form);
                        var $btn = $('#registrationformbutton');
                        $btn.prop('disabled', true).text('Processing...');

                        $.ajax({
                            url: "post-registration",
                            type: "POST",
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                            window.location.href = "login";
                                        },
                                        1000);
                                } else {
                                    toastr.error(response.message);
                                }
                                $btn.prop('disabled', false).text('Submit');
                            },
                            error: function(xhr) {
                                toastr.error(
                                    "Something went wrong. Please try again.");
                                $btn.prop('disabled', false).text('Submit');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
