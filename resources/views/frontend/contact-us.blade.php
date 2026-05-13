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
        /* Captcha block */
        .captcha-label { display:block; font-weight:600; font-size:13px; color:#374151; margin-bottom:6px; letter-spacing:0.2px; }
        .captcha-box { display:flex; align-items:stretch; gap:10px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:10px; box-shadow:0 1px 2px rgba(0,0,0,0.04); flex-wrap:wrap; }
        .captcha-image-wrap { flex:0 0 auto; background:#fff; border-radius:8px; overflow:hidden; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; padding:4px 10px; min-height:52px; }
        .captcha-image-wrap img#captcha-image { display:block; height:44px; max-width:100%; cursor:pointer; }
        .captcha-refresh { flex:0 0 auto; width:42px; height:42px; align-self:center; border:0; border-radius:50%; background:#2563eb; color:#fff; font-size:15px; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 2px 6px rgba(37,99,235,0.3); transition:transform 0.4s ease, background 0.15s ease; }
        .captcha-refresh:hover { background:#1d4ed8; transform:rotate(180deg); }
        .captcha-input { flex:1; min-width:0; border:1px solid #e5e7eb; border-radius:8px; background:#fff; padding:10px 14px; font-size:14px; font-weight:500; letter-spacing:1px; color:#111827; transition:border-color 0.15s ease, box-shadow 0.15s ease; }
        .captcha-input:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.12); }
        .captcha-input::placeholder { font-weight:400; letter-spacing:0.3px; color:#9ca3af; }
    </style>
@endsection
@section('content')
    <section class="area-searching destination-search main-contact-us">
        <div class="container">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="inner__desti__titles">
                        <h1>Contact us</h1>
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

    <section class="contact-page mt-2 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 wow fadeInLeft animated" data-wow-duration="1500ms" data-wow-delay="300ms"
                    style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInLeft;">
                    <div class="row gutter-y-30">
                        <div class="col-lg-12 col-md-12 mt-2">
                            <div class="contact-top__item active">
                                <div class="contact-top__item__icon">
                                    <i class="bi bi-envelope-at-fill"></i>
                                </div>
                                <h4 class="contact-top__item__title"><a href="mailto:support@rentforvacations.com">support@rentforvacations.com</a></h4>
                                <p class="contact-top__item__text">Email us anytime for anykind help.</p>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 mt-2">
                            <div class="contact-top__item">
                                <div class="contact-top__item__icon">
                                    <i class="bi bi-telephone-forward"></i>
                                </div>
                                <h4 class="contact-top__item__title">Contact:<a href="tel:+1-352-632-1626">+1-352-632-1626</a></h4>
                                <p class="contact-top__item__text">Call us any kind suppor,we will wait for it.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-page__contact">
                        <h2 class="contact-page__title">Connect With Our Team</h2>
                        {{-- <p class="contact-page__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est sunt
                            voluptates enim doloribus, mollitia perferendis?</p> --}}
                        <form id="contactForm" class="comments-form__form contact-form-validated form-one" novalidate="novalidate">
                            @csrf
                            <div class="form-one__group row">
                                <div class="col-sm-12 col-md-12 form-one__control">
                                    <label for="name">Your Name*</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Your Name">
                                    <small class="text-danger error-name"></small>
                                </div>
                                <div class="col-sm-12 col-md-12 form-one__control">
                                    <label for="phone">Contact No*</label>
                                    <input type="tel" name="phone" id="phone" class="form-control"
                                        placeholder="00000000000">
                                    <small class="text-danger error-phone"></small>
                                </div>
                                <div class="col-sm-12 col-md-12 form-one__control">
                                    <label for="email">Your Email*</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Your Email">
                                    <small class="text-danger error-email"></small>
                                </div>
                                <div class="col-sm-12 col-md-12 form-one__control form-one__control--full">
                                    <label for="message">Message*</label>
                                    <textarea name="message" id="message" class="form-control" placeholder="Write Message . . "></textarea>
                                    <small class="text-danger error-message"></small>
                                </div>
                                <div class="col-sm-12 col-md-12 form-one__control form-one__control--full">
                                    <label class="captcha-label">Verify you're human</label>
                                    <div class="captcha-box">
                                        <div class="captcha-image-wrap">
                                            <img id="captcha-image" src="{{ captcha_src('flat') }}" alt="captcha" title="Click to refresh">
                                        </div>
                                        <button type="button" id="refreshCaptcha" class="captcha-refresh" title="Refresh captcha">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <input type="text" name="captcha" class="captcha-input" placeholder="Type the code above" required autocomplete="off">
                                    </div>
                                    <small class="text-danger error-captcha"></small>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <button type="submit" class="hrbo-btn hrbo-btn--base">Send Message <i class="bi bi-arrow-right-circle"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(function () {
            function refreshCaptcha() {
                $('#captcha-image').attr('src', '{{ captcha_src("flat") }}' + '?' + Date.now());
            }
            $('#refreshCaptcha, #captcha-image').on('click', refreshCaptcha);

            function clearErrors() {
                $('#contactForm .text-danger').text('');
            }

            $('#contactForm').on('submit', async function (e) {
                e.preventDefault();
                clearErrors();
                if (typeof showloader === 'function') showloader();
                try {
                    const res = await fetch('{{ route("frontend.contact-us.submit") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new FormData(this),
                    });
                    const data = await res.json();
                    if (typeof hideLoader === 'function') hideLoader();

                    if (res.status === 422) {
                        for (const field in data.errors) {
                            $('.error-' + field).text(data.errors[field][0]);
                        }
                        refreshCaptcha();
                        $('input[name="captcha"]').val('');
                        return;
                    }
                    if (data.status === 200) {
                        if (typeof toastr !== 'undefined') toastr.success(data.msg);
                        else alert(data.msg);
                        document.getElementById('contactForm').reset();
                        refreshCaptcha();
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(data.msg || 'Something went wrong.');
                        else alert(data.msg || 'Something went wrong.');
                        refreshCaptcha();
                    }
                } catch (err) {
                    if (typeof hideLoader === 'function') hideLoader();
                    if (typeof toastr !== 'undefined') toastr.error('Network error. Please try again.');
                    else alert('Network error. Please try again.');
                    refreshCaptcha();
                }
            });
        });
    </script>
@endpush
