@extends('frontend.layouts.master')

@section('content')
    <!-- 404 Section -->
    <section class="section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="error-page-content">
                        <h1 class="display-1 fw-bold text-danger mb-4">404</h1>
                        <h2 class="mb-3">Property Not Found</h2>
                        <p class="lead mb-4">
                            Sorry, the property you're looking for doesn't exist or has been removed.
                        </p>
                        <div class="error-actions">
                            <a href="{{ route('frontend.index') }}" class="hrbo-btn hrbo-btn--primary me-3">
                                <i class="bi bi-house-door"></i> Go to Home
                            </a>
                            <a href="{{ route('property.listing') }}" class="hrbo-btn hrbo-btn--primary">
                                <i class="bi bi-search"></i> Browse Properties
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .error-page-content {
            padding: 80px 20px;
        }

        .error-page-content h1 {
            font-size: 150px;
            line-height: 1;
        }

        .error-page-content h2 {
            font-size: 32px;
            color: #333;
        }

        .error-page-content .lead {
            font-size: 18px;
            color: #666;
        }

        .error-actions {
            margin-top: 30px;
        }

        .error-actions .hrbo-btn {
            display: inline-block;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .error-page-content h1 {
                font-size: 100px;
            }

            .error-page-content h2 {
                font-size: 24px;
            }

            .error-actions .hrbo-btn {
                display: block;
                margin-bottom: 15px;
                margin-right: 0 !important;
            }
        }
    </style>
@endsection
