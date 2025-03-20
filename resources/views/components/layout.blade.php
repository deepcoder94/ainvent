
<html>
    <head>
        <title>{{ $title ?? 'AInvent' }}</title>
        <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
    </head>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
        <title>AInvent</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
    
        <!-- Favicons -->
        <link href="{{ asset('public/assets/img/favicon.png')}}" rel="icon">
        <link href="{{ asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
    
        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
        <!-- Vendor CSS Files -->
        <link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

<!-- SweetAlert2 CSS -->
<link href="{{ asset('public/assets/css/sweetalert2.min.css') }}" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="{{ asset('public/assets/js/sweetalert2.min.js') }}"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        
        <!-- Template Main CSS File -->
        <link href="{{ asset('public/assets/css/style.css')}}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            .tablecontainer {
                width: 100%;
                overflow-x: auto;
            }        
        </style>
    
    </head>
    
    <body>
        <x-header :currentPage="$currentPage" />
        <x-sidebar :currentPage="$currentPage" />
        <main id="main" class="main">
            {{ $slot }}
        </main>


        <x-footer />
    </body>
</html>