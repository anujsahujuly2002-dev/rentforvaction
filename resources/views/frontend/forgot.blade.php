@extends('frontend.layouts.master')
@section('css1')
<style>
    .navigation {
        position: relative;
        z-index: 99;
        width: 100%;
        background: var(--theme-color);
        border-radius: 20px;
        border-top: 2px solid #fefefe;
    }
</style>
@endsection
@section('content')
<section class="area-searching destination-search main-contact-us">
    <div class="container">

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="inner__desti__titles">
                    <h1>Account Forgot</h1>
                </div>
                <div class="breadcrumb-menu">
                    <ul class="custom-ul">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="login-page section-space">
            <div class="container">
                <div class="row gutter-y-40 align-items-center">
                    <div class="col-lg-6">
                        <div class="login-page__thumb  ">
                            <img src="{{ asset('frontend-assets/images/about/2.jpg')}}" alt="gotur image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-page__content">
                            <div class="login-page__content__bg"></div>
                            <div class="login-page__main-tab-box tabs-box">
                               <div class="login-page__top__left">
                                        <p class="login-page__top__section-title">welcome</p>
                                        <p class="login-page__top__section-subtitle">forgot password</p>
                                    </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <form class="contact-form-validated form-one" action="">
                                            <div class="login-page__group">
                                                <div class="login-page__input-box">
                                                    <i class="bi bi-envelope-at-fill"></i>
                                                    <input type="email" name="email" class="form__controls" placeholder="your email">
                                                </div>
                                                <div class="login-page__input-box">
                                                    <i class="bi bi-lock-fill"></i>
                                                    <input type="password" placeholder="password" class="login-page__password form__controls">
                                                    <!-- <span class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></span> -->
                                                </div>
                                                 <div class="login-page__input-box">
                                                    <i class="bi bi-lock-fill"></i>
                                                    <input type="password" placeholder="confirm password" class="login-page__password form__controls">
                                                    <!-- <span class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></span> -->
                                                </div>
                                                <div class="login-page__input-box">
                                                    <div class="login-page__input-box__btn">
                                                        <button type="submit" class="log-btn">Change Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <p class="login-page__form__text">don’t have an account?<a href="{{ route('frontend.register')}}">register</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@push('js')

@endpush