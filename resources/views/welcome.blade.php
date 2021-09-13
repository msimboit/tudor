<!DOCTYPE html>
<html lang="zxx">


<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/fonts/flaticon/font/flaticon.css')}}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('/logo/favicon.ico')}}" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="{{ asset('assets/css/skins/default.css')}}">

</head>
<body id="top">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="page_loader"></div>

<!-- Login 14 start -->
<div class="login-14">
    <div class="container-fluid">
        <div class="row">
            <div class="bg-img">
                <div class="info">
                    <h2>Welcome <span>to Tudor</span></h2>
                    <p class="">Tudor Corporate Security Services offers top security and personnel for all our clientele.</p>
                
                    <div class="login-inner-form">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group form-box">
                                <input type="email" name="email" class="input-text" placeholder="Email Address">
                                <i class="flaticon-mail-2"></i>
                            </div>
                            <div class="form-group form-box">
                                <input type="password" name="password" class="input-text" placeholder="Password">
                                <i class="flaticon-password"></i>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-md btn-theme btn-block">Login</button>
                            </div>
                        </form>
                    </div> 
                
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login 14 end -->

<!-- External JS libraries -->
<script src="{{ asset('assets/js/jquery-2.2.0.min.js')}}"></script>
<script src="{{ asset('assets/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Custom JS Script -->
</body>


</html>