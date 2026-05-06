<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Rent for Vacations Reset Password</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend-assets/images/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin-auth-assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('admin-auth-assets/vendor/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{ asset('admin-auth-assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin-auth-assets/js/config.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  </head>

  <body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                         <div class="app-brand justify-content-center ">
                            <a href="{{ route('frontend.index') }}" class="app-brand-link gap-2">
                                <span class=" style="width: 100%;>
                                    <img src="{{  asset('frontend-assets/images/rent-for-vacation-logo.png') }}" alt="" srcset="" class="mx-auto d-block " style="height:100px">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Rent for Vacation! 👋</h4>
                        <div class="error"></div>
                        <form id="resetPasswordForm" class="mb-3">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                           <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">New Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                                </div>
                                <div class="password"></div>
                            </div>
                           <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Confirm Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="confirm_password"></div>
                            </div>
                            <button class="buttonload submit w-100 btn d-none disabled">
                                <i class="fa fa-refresh fa-spin"></i>Please wait...
                            </button>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100 login" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('admin-auth-assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('admin-auth-assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('admin-auth-assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('admin-auth-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('admin-auth-assets/vendor/js/menu.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"> </script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <!-- Main JS -->
    <script src="{{ asset('admin-auth-assets/js/main.js')}}"></script>
    <!-- Page JS -->
    <script>
        resetPasswordForm.onsubmit = async (e)=>{
            e.preventDefault();
            $('.buttonload').removeClass('d-none');
            $(".login").addClass('d-none');
            try {
                const response = await fetch("{{ route('admin.password.reset') }}",{
                method:"POST",
                header:{
                    "Content-Type": "application/json",
                },
                body:new FormData(resetPasswordForm)
            });
            const results = await response.json();
            $(".error").html('');
            if(response.status==500){
                toastr.error(response.statusText);
                $('.buttonload').addClass('d-none');
                $(".login").removeClass('d-none');
            }
            if(results.status==422){
                $('.buttonload').addClass('d-none');
                $(".login").removeClass('d-none');
                for(let index in results.errors){
                    console.log(results.errors[index])
                    $("."+index).text(results.errors[index]).addClass('text-danger');
                }
            }
            if(results.status==500){
                $('.buttonload').addClass('d-none');
                $(".login").removeClass('d-none');
                let error = `<div class="alert alert-danger alert-dismissible" role="alert">${results.errors.email} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>`;
                $(".error").append(error);
            }
            if(results.status==200){
                $('.buttonload').addClass('d-none');
                $(".login").removeClass('d-none');
                let success = `<div class="alert alert-success alert-dismissible" role="alert">${results.msg}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                $(".error").append(success);
                resetPasswordForm.reset();
                window.setTimeout(() => {
                    location.href="{{ route('admin.login') }}"
                }, 2000);

            }

            } catch (error) {
                toastr.error(error.message);
                $('.buttonload').addClass('d-none');
                $(".login").removeClass('d-none');
            }

        }
    </script>
  </body>
</html>
