<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Register | Admin </title>
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

                    <h4 class="text-muted text-center font-size-18"><b>Register</b></h4>

                    <div class="p-3">

                        @if ($errors->any())
                            <div class="validation-errors mb-4">
                                @foreach ($errors->all() as $error)
                                    {{-- <p>{{ $error }}</p> --}}
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <form class="form-horizontal mt-3" method="POST" id="myForm" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="name" type="text" name="name"
                                        required="" placeholder="Name">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="username" type="text" name="username"
                                        required="" placeholder="Username">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="email" type="email" name="email"
                                        required="" placeholder="Email">
                                        <p id="email-error" class="text-sm text-danger" style="display: none; font-size:small;">Please enter valid email</p>

                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="company_name" type="text" name="company_name"
                                         placeholder="Company name">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="company_email" type="email" name="company_email"
                                         placeholder="Company Email">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="company_address" type="text" name="company_address"
                                         placeholder="Company Address">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="company_phone" type="text" name="company_phone"
                                         placeholder="Company Phone">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="password" type="password" name="password"
                                         placeholder="Password">

                                         <p id="password-error" class="text-sm text-danger" style="display: none; font-size:small;">Password must be at least 8 characters long</p>

                                </div>

                            </div>


                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" id="password_confirmation" type="password"
                                        name="password_confirmation" required="" placeholder="Password Confirmation">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center row mt-3 pt-1">
                                <div class="col-12">
                                    <button class="btn btn-info w-100 waves-effect waves-light" onsubmit="validateForm()"
                                        type="submit">Register
                                    </button>
                                </div>
                            </div>

                            <div class="form-group mt-2 mb-0 row">
                                <div class="col-12 mt-3 text-center">
                                    <a href="{{ route('login') }}" class="text-muted">Already have account?</a>
                                </div>
                            </div>
                        </form>
                        <!-- end form -->
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
        document.addEventListener('DOMContentLoaded', function() {
            // Retrieve the password field element
            var passwordField = document.getElementById('password');
            var errorPasswordElement = document.getElementById('password-error');

            // Retrieve the email field element
            var emailField = document.getElementById('email');
            var errorEmailElement = document.getElementById('email-error');

            // Add an input event listener to the password field
            passwordField.addEventListener('input', function() {
                // Retrieve the password field value
                var password = passwordField.value;

                // Check if the password meets the minimum length requirement
                if (password.length < 8) {
                    // Show the error message for password
                    errorPasswordElement.style.display = 'block';
                    // Add an error class to the password field
                    passwordField.classList.add('is-invalid');
                } else {
                    // Hide the error message for password
                    errorPasswordElement.style.display = 'none';
                    // Remove the error class from the password field
                    passwordField.classList.remove('is-invalid');
                }
            });

            // Add an input event listener to the email field
            emailField.addEventListener('input', function() {
                // Retrieve the email field value
                var email = emailField.value;

                // Check if the email is valid
                if (!validateEmail(email)) {
                    // Show the error message for email
                    errorEmailElement.style.display = 'block';
                    // Add an error class to the email field
                    emailField.classList.add('is-invalid');
                } else {
                    // Hide the error message for email
                    errorEmailElement.style.display = 'none';
                    // Remove the error class from the email field
                    emailField.classList.remove('is-invalid');
                }
            });
        });

        function validateForm() {
            // Retrieve the password field value
            var password = document.getElementById('password').value;
            // Retrieve the email field value
            var email = document.getElementById('email').value;

            // Check if the password meets the minimum length requirement
            if (password.length < 8) {
                alert('Password must have a minimum length of 8 characters');
                return false; // Prevent form submission
            }

            // Check if the email is valid
            if (!validateEmail(email)) {
                alert('Please enter a valid email address');
                return false; // Prevent form submission
            }

            // If all validations pass, the form will be submitted
            return true;
        }

        // Function to validate email format
        function validateEmail(email) {
            // Regular expression to match email format
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>







</body>

</html>
