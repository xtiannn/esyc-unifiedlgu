<x-app-layout>
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
        @if ($hasApplied)
            <div class="d-flex flex-column justify-content-center align-items-center animated fadeIn">
                <div class="rounded-circle bg-success bg-opacity-10 d-flex justify-content-center align-items-center shadow position-relative overflow-hidden"
                    style="width: 200px; height: 200px;">
                    <!-- Background circle animation -->
                    <div class="position-absolute rounded-circle bg-success bg-opacity-25 animated pulse infinite"
                        style="width: 100%; height: 100%;">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                            <path
                                d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 fs-5 fw-bold text-primary animated fadeInUp delay-1s">
                    Application Received!
                </p>
                <p class="text-muted fs-5 animated fadeInUp delay-1s">
                    Your application is being reviewed by our team.
                </p>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mt-3 animated fadeInUp delay-1s">
                    Back to Dashboard
                </a>
            </div>
        @else
            <div class="animated fadeIn">
                <p class="fs-3 fw-bold text-dark">Ready to Apply?</p>
                <p class="text-muted fs-5 mb-4">Take the first step towards your scholarship today!</p>
                {{-- <a href="{{ route('scholarship.apply') }}" --}}
                <a href="#" class="btn btn-primary btn-lg px-5 py-3 shadow-sm hover-lift">
                    Apply Now
                </a>
            </div>
        @endif
    </div>

    <!-- Add custom animations and styles -->
    <style>
        /* Basic animation keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .fadeIn {
            animation-name: fadeIn;
        }

        .fadeInUp {
            animation-name: fadeInUp;
        }

        .pulse {
            animation-name: pulse;
        }

        .infinite {
            animation-iteration-count: infinite;
        }

        .delay-1s {
            animation-delay: 0.5s;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .rounded-circle {
                width: 150px !important;
                height: 150px !important;
            }

            svg {
                width: 75px !important;
                height: 75px !important;
            }

            .fs-3 {
                font-size: 1.5rem !important;
            }

            .btn-lg {
                padding: 0.75rem 2rem !important;
            }
        }

        /* Ensure Bootstrap opacity classes work */
        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }

        .bg-opacity-25 {
            --bs-bg-opacity: 0.25;
        }
    </style>
</x-app-layout>
