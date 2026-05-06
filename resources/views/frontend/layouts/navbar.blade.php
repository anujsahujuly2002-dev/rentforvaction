 <!-- Navigation Bar -->
    @stack('div_start')
    <div class="navigation">
        <div class="container">
            <div class="navigation-content">
                <div class="header_menu">
                    <!-- start Navbar (Header) -->
                    <nav class="navbar-default navbar-sticky-function navbar-arrow">
                        <div class="logo pull-left">
                            <a href="{{ route('frontend.index') }}"><img alt="Image" src="{{ asset('frontend-assets/images/rent-for-vacation-logo.png') }}"></a>
                        </div>
                        <div id="navbar" class="navbar-nav-wrapper">
                            <ul class="nav navbar-navs" id="responsive-menu">
                                <li><a href="{{ route('frontend.destination') }}">Destinations</a></li>
                                <li><a href="{{ route('frontend.recommended') }}">Recommended</a></li>
                                <li><a href="{{ route('frontend.contact-us') }}">Contact Us</a></li>
                                @if (!Auth::guest() &&Auth::user()->getRoleNames()[0]=='owner')
                                    <li class="beamember"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                                @else
                                    <li><a href="{{ route('frontend.log-in') }}">Owner Login</a></a></li>
                                @endif
                                <li class="vs-btn style8"><a href="{{ route('frontend.package') }}">Owner Join Here !!</a></li>
                            </ul>
                        </div><!--/.nav-collapse -->
                        <div id="slicknav-mobile"></div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Navigation Bar Ends -->
    @stack('div_end')
