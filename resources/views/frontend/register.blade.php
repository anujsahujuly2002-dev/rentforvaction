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
    .captcha-label { display:block; font-weight:600; font-size:13px; color:#374151; margin-bottom:6px; letter-spacing:0.2px; }
    .captcha-box { display:flex; align-items:stretch; gap:10px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:10px; box-shadow:0 1px 2px rgba(0,0,0,0.04); flex-wrap:wrap; }
    .captcha-image-wrap { flex:0 0 auto; background:#fff; border-radius:8px; overflow:hidden; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; padding:4px 10px; min-height:52px; }
    .captcha-image-wrap img#captcha-image { display:block; height:44px; max-width:100%; cursor:pointer; }
    .captcha-refresh { flex:0 0 auto; width:42px; height:42px; align-self:center; border:0; border-radius:50%; background:#2563eb; color:#fff; font-size:15px; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 2px 6px rgba(37,99,235,0.3); transition:transform 0.4s ease, background 0.15s ease; }
    .captcha-refresh:hover { background:#1d4ed8; transform:rotate(180deg); }
    .captcha-input { flex:1; min-width:0; border:1px solid #e5e7eb; border-radius:8px; background:#fff; padding:10px 14px; font-size:14px; font-weight:500; letter-spacing:1px; color:#111827; transition:border-color 0.15s ease, box-shadow 0.15s ease; }
    .captcha-input:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.12); }
    .captcha-input::placeholder { font-weight:400; letter-spacing:0.3px; color:#9ca3af; }
    .captcha-refresh i { position:static; transform:none; left:auto; top:auto; color:inherit; font-size:15px; }
</style>
@endsection
@section('content')
<section class="area-searching destination-search main-contact-us">
    <div class="container">

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="inner__desti__titles">
                    <h1>Account Register</h1>
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
                            <p class="login-page__top__section-subtitle">Register in your account</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <form class="contact-form-validated form-one" id="ownerRegistration">
                                    <div class="login-page__group">
                                        <div class="login-page__input-box">
                                            <i class="bi bi-people-fill"></i>
                                            <input type="text" name="name" class="form__controls" placeholder="your name">
                                            <span class="text-danger name"></span>
                                        </div>
                                        <div class="login-page__input-box">
                                            <i class="bi bi-envelope-at-fill"></i>
                                            <input type="text" name="email" class="form__controls" placeholder="your email">
                                            <span class="text-danger email"></span>
                                        </div>
                                        <div class="login-page__input-box">
                                            <i class="bi bi-telephone-fill"></i>
                                            <input type="tel" name="mob" placeholder="your mobile num...." class="form__controls">
                                             <span class="text-danger mob"></span>
                                        </div>
                                        <div class="login-page__input-box">
                                            <i class="bi bi-lock-fill"></i>
                                            <input type="password" placeholder="password" class="login-page__password form__controls" name="password">
                                            <span class="text-danger password"></span>
                                            <!-- <span class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></span> -->
                                        </div>
                                        <div class="login-page__input-box">
                                            <i class="bi bi-lock-fill"></i>
                                            <input type="password" placeholder="confirm password" class="login-page__password form__controls" name="confirm_password">
                                            <span class="text-danger confirm_password"></span>
                                            <!-- <span class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></span> -->
                                        </div>
                                        <div class="login-page__input-box login-page__input-box--bottom">
                                            <div class="login-page__input-box__inner">
                                                <input id="remember-policy2" type="checkbox">
                                                <label class="remember-policy" for="remember-policy2">I agree to the <a href="{{ route('frontend.terms-and-conditions') }}">terms and conditions</a></label>
                                            </div>
                                            <!-- <a href="#" class="login-page__form__forgot">forgot password?</a>dd -->
                                        </div>
                                        <div class="login-page__input-box">
                                            <label class="captcha-label">Verify you're human</label>
                                            <div class="captcha-box">
                                                <div class="captcha-image-wrap">
                                                    <img id="captcha-image" src="{{ captcha_src('flat') }}" alt="captcha" title="Click to refresh">
                                                </div>
                                                <button type="button" id="refreshCaptcha" class="captcha-refresh" title="Refresh captcha">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                                <input type="text" name="captcha" class="captcha-input" placeholder="Type the code above" autocomplete="off">
                                            </div>
                                            <span class="text-danger captcha"></span>
                                        </div>
                                        <div class="login-page__input-box">
                                            <div class="login-page__input-box__btn">
                                                <button type="submit" class="log-btn">Sign Up</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <p class="login-page__form__text">do you have already register?<a href="{{ route('frontend.log-in')}}">Log In</a></p>
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
    <script src="{{ asset('frontend-assets/js/ownerJs/register.js') }}"></script>
    <script>
        $(function () {
            function refreshCaptcha() {
                $('#captcha-image').attr('src', site_url + '/captcha/flat?' + Date.now());
            }
            $('#refreshCaptcha, #captcha-image').on('click', refreshCaptcha);
        });
    </script>
@endpush
