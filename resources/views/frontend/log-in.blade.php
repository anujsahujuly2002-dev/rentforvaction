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

        /* Error Message Styling */
        .error-message {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
            padding: 8px 12px;
            background-color: #fff5f5;
            border-left: 3px solid #dc3545;
            border-radius: 4px;
            font-weight: 500;
            animation: slideDown 0.3s ease-in-out;
        }

        .error-message:before {
            content: "⚠ ";
            margin-right: 4px;
            font-size: 14px;
        }

        .login-page__input-box.has-error input {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }

        .login-page__input-box.has-error input:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Alternative inline error style */
        .text-danger {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
        }
    </style>
@endsection
@section('content')
    <section class="area-searching destination-search main-contact-us">
        <div class="container">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="inner__desti__titles">
                        <h1>Account log In</h1>
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
                        <img src="{{ asset('frontend-assets/images/about/2.jpg') }}" alt="gotur image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-page__content">
                        <div class="login-page__content__bg"></div>
                        <div class="login-page__main-tab-box tabs-box">
                            <div class="login-page__top__left">
                                <p class="login-page__top__section-title">welcome</p>
                                <p class="login-page__top__section-subtitle">sign in your account</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <form class="contact-form-validated form-one" id="ownerLogin">
                                        <div class="login-page__group">
                                            <div class="login-page__input-box">
                                                <i class="bi bi-envelope-at-fill"></i>
                                                <input type="text" name="email" class="form__controls"
                                                    placeholder="your email">
                                                <span class="text-danger email"></span>
                                            </div>
                                            <div class="login-page__input-box">
                                                <i class="bi bi-lock-fill"></i>
                                                <input type="password" name="password" placeholder="password"
                                                    class="login-page__password form__controls">
                                                <span class="text-danger password"></span>
                                            </div>
                                            <div class="login-page__input-box login-page__input-box--bottom">
                                                <div class="login-page__input-box__inner">
                                                    <input id="remember-policy2" type="checkbox">
                                                    <label class="remember-policy" for="remember-policy2">remember
                                                        me</label>
                                                </div>
                                                <a href="{{ route('frontend.forgot') }}"
                                                    class="login-page__form__forgot">forgot password?</a>
                                            </div>
                                            <div class="login-page__input-box">
                                                <div class="login-page__input-box__btn">
                                                    <button type="submit" class="log-btn">log in</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <p class="login-page__form__text">don’t have an account?<a
                                            href="{{ route('frontend.register') }}">register</a></p>
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
    <script src="{{ asset('frontend-assets/js/ownerJs/login.js') }}"></script>
@endpush
