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
                                <h4 class="contact-top__item__title"><a href="mailto:rick@rentforvacations.com">rick@rentforvacations.com</a></h4>
                                <p class="contact-top__item__text">Email us anytime for anykind help.</p>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 mt-2">
                            <div class="contact-top__item">
                                <div class="contact-top__item__icon">
                                    <i class="bi bi-telephone-forward"></i>
                                </div>
                                <h4 class="contact-top__item__title">Contact:<a href="tel:+1-631-966-6063">+1-631-966-6063</a></h4>
                                <p class="contact-top__item__text">Call us any kind suppor,we will wait for it.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-page__contact">
                        <h2 class="contact-page__title">Ready to Get Started?</h2>
                        {{-- <p class="contact-page__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est sunt
                            voluptates enim doloribus, mollitia perferendis?</p> --}}
                        <form class="comments-form__form contact-form-validated form-one" novalidate="novalidate">
                            <div class="form-one__group row">
                                <div class="col-sm-12 col-md-12 form-one__control">
                                    <label for="name">Your Name*</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Your Name">
                                </div>
                                <div class="col-sm-12 col-md-12 form-one__control">
                                    <label for="name">Contact No*</label>
                                    <input type="tel" name="name" id="name" class="form-control"
                                        placeholder="00000000000">
                                </div>
                                <div class="col-sm-12 col-md-12 form-one__control">
                                    <label for="email">Your Email*</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Your Email">
                                </div>
                                <div class="col-sm-12 col-md-12 form-one__control form-one__control--full">
                                    <label for="message">Message*</label>
                                    <textarea name="message" id="message" class="form-control" placeholder="Write Message . . "></textarea>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <button type="submit" class="hrbo-btn hrbo-btn--base">Send Message <i
                                            class="bi bi-arrow-right-circle"></i></button>
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
@endpush
