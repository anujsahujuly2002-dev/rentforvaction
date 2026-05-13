@extends('frontend.layouts.master')
@section('content')
    <!-- HERO -->
    <section class="rent-hero-section">
        <div class="container">
            <h1>Terms & Conditions</h1>
            <p class="mt-3">Please read these terms carefully before registering.</p>
        </div>
    </section>
    <!-- CONTENT -->
    <section class="py-5">
        <div class="container">
            <div class="rent-legal-card">
                <h5 class="rent-section-title">
                    <i class="bi bi-person-check"></i> Membership Registration
                </h5>
                <p>
                    Rent for Vacations enables you to register an account to become a member.
                    When choosing to become a member, you must provide certain required information.
                    Failure to provide required details will prevent account registration.
                </p>
                <div class="rent-highlight-box">
                    <strong>Required Information Includes:</strong>
                    <ul class="rent-custom-list mt-3">
                        <li>Full Name</li>
                        <li>Email Address</li>
                        <li>Telephone Number</li>
                        <li>Postal Address</li>
                        <li>Password & Password Validation</li>
                    </ul>
                </div>
                <h5 class="rent-section-title">
                    <i class="bi bi-database"></i> Purpose of Information Collection
                </h5>
                <p>The information collected during registration is used for the following purposes:</p>
                <ul class="rent-custom-list">
                    <li>Personal identification</li>
                    <li>Facilitating enquiries to property owners and travel services</li>
                    <li>Customer service communication</li>
                    <li>Website content customization based on user preferences</li>
                    <li>Research and product/service improvements</li>
                </ul>
                <h5 class="rent-section-title mt-4">
                    <i class="bi bi-envelope-open"></i> Email Communication
                </h5>
                <p>
                    Your email address is used to confirm account registration and each enquiry submitted online.
                    To measure the effectiveness of our communications, we may use technologies that confirm when
                    an email has been opened.
                </p>
                <h5 class="rent-section-title mt-4">
                    <i class="bi bi-megaphone"></i> Promotional Updates
                </h5>
                <p>
                    As a registered member, you may occasionally receive updates about special offers,
                    promotions, and service announcements.
                </p>
            </div>
        </div>
    </section>
@endsection
