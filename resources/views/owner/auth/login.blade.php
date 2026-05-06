@extends('frontend.layouts.master')
@push('div_start')
<div class="innerheader">
@endpush
@push('div_end')
</div>
@endpush
@section('content')
    <section class="breadcrumb-outer text-center">
        <!-- store tab -->
        <div id="store-tabs" class="store-tabs loginRegister">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                        <form id="ownerLogin">
                            <div class="maincontainerLR">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="login-form">
                                            <h2>Holiday Rental by Owners</h2>
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <div class="input-with-icon">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <span class="email text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-with-icon">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter correct Password">
                                                    <i class="fa fa-lock"></i>
                                                </div>
                                                <span class="password text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="remember_me"> Remember Me?
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="pop-login">Login</button>
                                            </div>                                                    
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <img src="{{ asset('frontend-assets/images/loginBG.jpg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End store tab -->
    </section>
@endsection

@push('js')
    <script src="{{ asset('frontend-assets/js/ownerJs/login.js') }}"></script>
@endpush