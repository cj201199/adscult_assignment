<!DOCTYPE html>

<html>

<head>

    <title>AdsCult</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"></script>




    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);



        body {

            margin: 0;

            font-size: .9rem;

            font-weight: 400;

            line-height: 1.6;

            color: #212529;

            text-align: left;

            background-color: #f5f8fa;

        }

        .navbar-laravel {

            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);

        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {

            font-family: Raleway, sans-serif;

        }

        .my-form {

            padding-top: 1.5rem;

            padding-bottom: 1.5rem;

        }

        .my-form .row {

            margin-left: 0;

            margin-right: 0;

        }

        .login-form {

            padding-top: 1.5rem;

            padding-bottom: 1.5rem;

        }

        .login-form .row {

            margin-left: 0;

            margin-right: 0;

        }

        .error {
            color: red;
        }
    </style>

</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">

        <div class="container">

            <a class="navbar-brand" href="{{ route('dashboard') }}">Laravel</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>



            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto">

                    @guest

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('login') }}">Login</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('register') }}">Register</a>

                        </li>
                    @else
                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>

                        </li>

                    @endguest

                </ul>



            </div>

        </div>

    </nav>



    @yield('content')

    @yield('script')



</body>

</html>
