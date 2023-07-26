<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Reset Password | Admin </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-body">

                    <div class="text-center mt-4">
                        <div class="mb-3">
                            <a href="index.html" class="auth-logo">
                                <img src="{{ asset('backend/assets/images/logo-dark.png') }}" height="30"
                                    class="logo-dark mx-auto" alt="">
                                <img src="{{ asset('backend/assets/images/logo-light.png') }}" height="30"
                                    class="logo-light mx-auto" alt="">
                            </a>
                        </div>
                    </div>

                    <h4 class="text-muted text-center font-size-18"><b>Reset Password</b></h4>

                    <div class="p-3">

                        @if ($errors->any())
                            <div class="validation-errors mb-4">
                                @foreach ($errors->all() as $error)
                                    {{-- <p>{{ $error }}</p> --}}
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <p>{{ $error }}</p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endforeach
                            </div>
                        @endif


                        <form class="form-horizontal mt-3" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <div class="col-xs-12">
                                    <input class="form-control" id="email" type="email" name="email"
                                        required="" placeholder="Email" value="{{ old('email', $request->email) }}">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <div class="col-xs-12">
                                    <input class="form-control" id="password" type="password" name="password"
                                        required="" placeholder="Password">
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-3">
                                <div class="col-xs-12">
                                    <input class="form-control" id="password_confirmation" type="password"
                                        name="password_confirmation" required="" placeholder="Confirm Password">
                                </div>
                            </div>

                            <div class="form-group pb-2 text-center row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-info w-100 waves-effect waves-light"
                                        onclick="validatePassword()" type="submit">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end cardbody -->
            </div>
            <!-- end card -->
        </div>
        <!-- end container -->
    </div>
    <!-- end -->


    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        function validatePassword() {
            const password = document.getElementById("password").value;
            const password_confirmation = document.getElementById("password_confirmation").value;

            if (password !== password_confirmation) {
                alert("Passwords do not match");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>
