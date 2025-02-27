
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
        <link href="{{ asset('public/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
        
        <!-- Template Main CSS File -->
        <link href="{{ asset('public/assets/css/style.css')}}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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