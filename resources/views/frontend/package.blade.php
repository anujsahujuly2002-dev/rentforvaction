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
                        <h1>Our Package</h1>
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
    <section class="pricing-section">
        <div class="container">
            <h2 class="section___title">Flexible Pricing for Everyone</h2>
            <p class="section____subtitle mb-3">Select a plan that fits your goals and grow with us.</p>
            <div class="row g-4 mt-4">
                <!-- Bronze -->
                <div class="col-lg-4">
                    <div class="price-card">
                        <h4 class="plan-title">Bronze</h4>
                        <div class="plan-price"><sup>$</sup>299.00</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle-fill"></i> Unlimited Photos</li>
                            <li><i class="bi bi-check-circle-fill"></i> Unlimited Description</li>
                            <li><i class="bi bi-check-circle-fill"></i> Owner Dashboard</li>
                            <li><i class="bi bi-check-circle-fill"></i> Calendar Sync</li>
                            <li><i class="bi bi-check-circle-fill"></i> Monthly Reporting</li>
                            <li class="inactive">Priority Support</li>
                            <li class="inactive">Social Promotion</li>
                        </ul>
                        <a href="{{ route('frontend.register') }}" class="btn-plan">Sign Up</a>
                    </div>
                </div>

                <!-- Silver -->
                <div class="col-lg-4">
                    <div class="price-card featured">
                        <h4 class="plan-title">Silver</h4>
                        <div class="plan-price"><sup>$</sup>399.00</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle-fill"></i> All Bronze Features</li>
                            <li><i class="bi bi-check-circle-fill"></i> External Website Link</li>
                            <li><i class="bi bi-check-circle-fill"></i> Rank Higher Than Bronze</li>
                            <li><i class="bi bi-check-circle-fill"></i> Add Last-Minute Deals</li>
                            <li><i class="bi bi-check-circle-fill"></i> Priority Support</li>
                            <li><i class="bi bi-check-circle-fill"></i>Link to the Personal Website</li>
                        </ul>
                        <a href="{{ route('frontend.register') }}" class="btn-plan">Sign Up</a>
                    </div>
                </div>

                <!-- Gold -->
                <div class="col-lg-4">
                    <div class="price-card">
                        <h4 class="plan-title">Gold</h4>
                        <div class="plan-price"><sup>$</sup>499.00</div>
                        <ul class="plan-features">
                            <li><i class="bi bi-check-circle-fill"></i> All Silver Features</li>
                            <li><i class="bi bi-check-circle-fill"></i> Newsletter Features</li>
                            <li><i class="bi bi-check-circle-fill"></i> Social Media Exposure</li>
                            <li><i class="bi bi-check-circle-fill"></i> Featured on Homepage</li>
                            <li><i class="bi bi-check-circle-fill"></i> Dedicated Manager</li>
                            <li><i class="bi bi-check-circle-fill"></i> Performance Analytics</li>
                            <li><i class="bi bi-check-circle-fill"></i>Link to the Personal Website</li>
                        </ul>
                        <a href="{{ route('frontend.register') }}" class="btn-plan">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="business-guarantee-section" style="background: var(--theme-color); padding: 0 0 80px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="guarantee-card text-center p-5" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 20px; backdrop-filter: blur(18px); border-left: 4px solid #00ffe1;">
                        <h2 style="color: #ffffff; font-weight: 700; margin-bottom: 20px;">
                            <i class="bi bi-shield-check" style="color: #00ffe1; margin-right: 10px;"></i>Business Guarantee
                        </h2>
                        <p style="font-size: 20px; font-weight: 600; color: #00ffe1; margin-bottom: 15px;">100% Satisfaction Guaranteed</p>
                        <p style="font-size: 16px; color: #c2cbea; line-height: 1.8; max-width: 800px; margin: 0 auto;">
                            If your listing does not generate at least <strong style="color: #ffffff;">10 inquiries</strong> and <strong style="color: #ffffff;">2 confirmed bookings</strong> within the first year, we will extend your listing at no additional cost. Our goal is simple: help you achieve <strong style="color: #ffffff;">positive cash flow</strong> and a <strong style="color: #ffffff;">strong return on your investment</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
