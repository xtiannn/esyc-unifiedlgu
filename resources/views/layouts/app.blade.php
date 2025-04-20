<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('assets/images/unified-lgu-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>
        @section('title') Default Title @show
    </title>

    <!-- Simple bar CSS (for scvrollbar)-->
    <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('css/feather.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-css.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        .avatar-initials {
            width: 165px;
            height: 165px;
            border-radius: 50%;
            display: flex;
            margin-left: 8px;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            font-weight: bold;
            color: #fff;

        }

        .avatar-initials-min {
            width: 40px;
            height: 40px;
            background: #75e6da;
            border-radius: 50%;
            display: flex;
            margin-left: 8px;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            color: #fff;

        }

        .upload-icon {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
            font-size: 24px;
            color: #fff;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            background-color: #333;
            padding: 10px;
            border-radius: 50%;
            z-index: 1;
        }

        .avatar-img:hover .upload-icon {
            opacity: 1;
        }

        .avatar-img {
            position: relative;
            transition: background-color 0.3s ease-in-out;
        }

        .avatar-img:hover {
            background-color: #a0f0e6;
        }
    </style>
</head>

<div class="loader-mask">
    <div class="loader">
        <div></div>
        <div></div>
    </div>
</div>

<body class="vertical light">
    <div class="wrapper">

        @php
            use App\Models\Announcement;
            $announcement = Announcement::latest('created_at')->first();
        @endphp

        {{-- @include('partials.navBar', ['announcement' => $announcement]) --}}


        <!-- Navigation Bar -->
        @include('partials.navbar')
        <!-- End Navigation Bar -->

        <!-- Sidebar  -->
        @include('partials.sidebar')
        <!-- End Sidebar  -->

        <main role="main" class="main-content">
            <!--Notification Modal  -->
            @include('partials.notification-modal')
            <!--End Notification Modal  -->

            <div class="container-fluid">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.stickOnScroll.js') }}"></script>
    <script src="{{ asset('js/tinycolor-min.js') }}"></script>
    <script src="{{ asset('js/d3.min.js') }}"></script>
    <script src="{{ asset('js/topojson.min.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/gauge.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts.custom.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/uppy.min.js') }}"></script>
    <script src="{{ asset('js/quill.min.js') }}"></script>
    <script src="{{ asset('js/apps.js') }}"></script>
    <script src="{{ asset('js/preloader.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Bootstrap JS (Required for Modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let formId = this.getAttribute("data-form-id");
                    let itemName = this.getAttribute("data-item-name"); // Get item name dynamically
                    confirmDelete(formId, itemName);
                });
            });
        });

        function confirmDelete(formId, itemName) {
            Swal.fire({
                title: "⚠️ Confirmation Required!",
                text: ` You are about to delete "${itemName}". This action cannot be undone!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "DELETE",
                cancelButtonText: "Cancel",
                reverseButtons: true,
                background: "#1e1e2f",
                color: "#fff",
                customClass: {
                    popup: "rounded-3 shadow-lg",
                    title: "fw-bold",
                    confirmButton: "px-4 py-2",
                    cancelButton: "px-4 py-2"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
</body>

</html>
