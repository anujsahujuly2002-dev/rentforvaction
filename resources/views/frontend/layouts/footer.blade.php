<!-- Footer -->
<footer>
    <div class="footer-upper">
        <div class="container">
            <div class="footer-links">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="footer-about footer-margin">
                            <h3>Rent For Vacations</h3>
                            <p>Discover vacation rentals with no service fees, no commissions, and no online booking required.</p>
                            {{-- <div class="footer-social-links">
                                <ul>
                                    <li class="social-icon"><a href="#"><i class="fa fa-facebook"aria-hidden="true"></i></a></li>
                                    <li class="social-icon"><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 justify-content-end d-flex">
                        <div class="footer-links-list footer-margin">
                            <h3>Quick Links</h3>
                            <ul>
                                {{-- <li><a href="#">Disclaimer<i class="fa fa-angle-right" aria-hidden="true"></i></a></li> --}}
                                <li><a href="{{ route('frontend.privacy-policy') }}">Privacy Policy<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                {{-- <li><a href="#">FAQ<i class="fa fa-angle-right" aria-hidden="true"></i></a></li> --}}
                                <li><a href="{{ route('frontend.terms-and-conditions') }}">Terms and Conditions<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="copyright-content">
                        <p>© Copyright 2018 - {{ date('Y') }} Rent For Vacations | All Rights Reserved.</p>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="payment-content">
                        <ul>
                            <li>We Accept</li>
                            <li>
                                <img src="{{ asset('frontend-assets/images/payment1.png') }}" alt="Image">
                            </li>
                            <li>
                                <img src="{{ asset('frontend-assets/images/payment2.png') }}" alt="Image">
                            </li>
                            <li>
                                <img src="{{ asset('frontend-assets/images/payment3.png') }}" alt="Image">
                            </li>
                            <li>
                                <img src="{{ asset('frontend-assets/images/payment4.png') }}" alt="Image">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Ends -->
