<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Chrome, Firefox OS and Opera mobile address bar theming -->
    <meta name="theme-color" content="#000000">
    <!-- Windows Phone mobile address bar theming -->
    <meta name="msapplication-navbutton-color" content="#000000">
    <!-- iOS Safari mobile address bar theming -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000000">

    <!-- SEO -->
    <meta name="description" content="Halfmoon is a responsive front-end framework that is great for building dashboards and tools. Built-in dark mode, full customizability using CSS variables (around 1,500 variables), optional JavaScript library (no jQuery), Bootstrap like classes, and cross-browser compatibility (including IE11).">
    <meta name="author" content="Halfmoon">
    <meta name="keywords" content="Halfmoon, HTML, CSS, JavaScript, CSS Framework, dark mode, dark-mode, darkmode, dark theme, dark-theme, darktheme, Bootstrap, Foundation, Bulma, dashboard, UI, UI framework, user interface, design, design system">

    <!-- Open graph -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://www.gethalfmoon.com/page-sections-demo/">
    <meta property="og:title" content="Front-end framework with a built-in dark mode and full customizability using CSS variables; great for building dashboards and tools">
    <meta property="og:description" content="Halfmoon is a responsive front-end framework that is great for building dashboards and tools. Built-in dark mode, full customizability using CSS variables (around 1,500 variables), optional JavaScript library (no jQuery), Bootstrap like classes, and cross-browser compatibility (including IE11).">
    <meta property="og:image" content="https://res.cloudinary.com/halfmoon-ui/image/upload/v1599770364/halfmoon-og-image-1.1.0_uofgby.png">
    <meta name="twitter:card" content="summary_large_image">

    <meta property="fb:app_id" content="2560228000973437">
    <meta name="twitter:site" content="@halfmoonui">

    <!-- Fav and Title -->
    <link rel="icon" href="{{ asset('/logo/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Halfmoon -->
    <link href="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/css/halfmoon.min.css" rel="stylesheet" />
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <!-- Roboto font (Used when Apple system fonts are not available) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Documentation styles -->
    <link href="/static/site/css/documentation-styles-4.css" rel="stylesheet">
    <!-- Axios Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<body class="dark-mode with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true">

    <!-- Page wrapper start -->
    <div id="page-wrapper" class="page-wrapper with-navbar with-sidebar with-navbar-fixed-bottom" data-sidebar-type="default">

        <!-- Sticky alerts -->
        <div class="sticky-alerts"></div>

        <!-- Navbar start -->
        <nav class="navbar">
            @if(Auth::check())
            <div class="navbar-content">
                <button id="toggle-sidebar-btn" class="btn btn-action" type="button" onclick="halfmoon.toggleSidebar()">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>
            @else
            <div class="navbar-content">
                <button class="btn btn-action" type="button">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>
            @endif
            <a href="#" class="navbar-brand ml-10 ml-sm-20">
                <!-- <img src="{{ asset('/logo/favicon.ico')}}" alt="fake-logo"> -->
                <span class="d-none d-sm-flex">Tudor</span>
            </a>
            <div class="navbar-content ml-auto">
                <button class="btn btn-action mr-5" type="button" onclick="halfmoon.toggleDarkMode()">
                    <i class="fa fa-moon-o" aria-hidden="true"></i>
                    <span class="sr-only">Toggle dark mode</span>
                </button>
                @if(Auth::check())
                <a class="dropdown-item" class="btn btn-alert" role="button" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @endif
            </div>
        </nav>
        <!-- Navbar end -->
        @if(Auth::check())
        <!-- Sidebar overlay -->
        <div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>

        <!-- Sidebar start -->
        <div class="sidebar">
            
            <div class="sidebar-menu">
                <div class="sidebar-content">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="mt-10 font-size-12">
                        Press <kbd>/</kbd> to focus
                    </div>
                </div>
                <h5 class="sidebar-title">Admin Panel</h5>
                <div class="sidebar-divider"></div>
                <a href="{{ route('daily') }}" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-table" aria-hidden="true"></i>
                    </span>
                   Daily Guard Reports
                </a>
                <a href="{{ route('shifts') }}" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-table" aria-hidden="true"></i>
                    </span>
                    Guard Shift Reports
                </a>
                <a href="{{ route('guards') }}" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </span>
                    Guards List
                </a>
                <a href="{{ route('employees') }}" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </span>
                    Employee List
                </a>
                <a href="{{ route('shifts') }}" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-table" aria-hidden="true"></i>
                    </span>
                    Employee Shift Reports
                </a>
                <a href="{{ route('registerUser') }}" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </span>
                    Register A User
                </a>
                <a href="{{ route('all_issues') }}" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-flag" aria-hidden="true"></i>
                    </span>
                    Reported Issues
                </a>
                <a href="#" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-map-o" aria-hidden="true"></i>
                    </span>
                    Map
                </a>
                <a href="#" class="sidebar-link sidebar-link-with-icon">
                    <span class="sidebar-icon">
                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                    </span>
                    Messenger
                </a>
            </div>
           
        </div>
        <!-- Sidebar end --> @endif

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row row-eq-spacing-lg">
                    <div class="col-lg-9">
                        <div class="content">
                            @if(Auth::check())
                            <h1 class="content-title">
                                <a class="btn btn-link" href="{{ route('employees') }} " style="text-decoration:none; color:teal;">Dashboard</a>
                            </h1>
                            <div class="fake-content"></div>
                            <div class="fake-content"></div>
                            @else
                            <div class="d-flex justify-content-center">
                                <h1 class="content-title">
                                    <a class="btn btn-link" href="{{ route('login') }} " style="text-decoration:none; color:teal"><span class="d-none d-sm-flex">Login</span></a>
                                </h1>
                                <div class="fake-content"></div>
                                <div class="fake-content"></div>
                            </div>
                            
                            @endif
                        </div>
                        <div class="card">
                            <h2 class="card-title">
                                @if(Auth::check())
                                Hello, {{ Auth::user()->firstname }}
                                @endif
                            </h2>
                            
                            <!-- <div class="fake-content">wdvf</div>
                            <div class="fake-content">cdsc </div>
                            <div class="fake-content">cdsc z </div>
                            
                                <div class="fake-content w-100">dyfhgjh</div> -->
                                <main>
                                    @yield('content')
                                </main>
                                <audio id="alarm" src="{{ asset('audio/alarm/alarm.wav')}}" preload="auto"></audio>
                        </div>
                        <div class="content">
                            <div class="fake-content"></div>
                            <div class="fake-content w-150"></div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 d-none d-lg-block">
                        <div class="content">
                            <h2 class="content-title font-size-20">
                                On this page
                            </h2>
                            <div class="fake-content">fgjhk</div>
                            <div class="fake-content">gjhkjlkg</div>
                            <div class="fake-content">jhmn</div>
                            <div class="fake-content">khbjm</div>
                            <div class="fake-content">hkbjln</div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Content wrapper end -->

        <!-- Navbar fixed bottom start -->
        <nav class="navbar navbar-fixed-bottom">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-question-circle-o mr-5" aria-hidden="true"></i>
                        Help
                    </a>
                </li>
            </ul>
            <span class="navbar-text">
                &copy; Copyright 2021, Tudor Corporate Security
            </span>
        </nav>
        <!-- Navbar fixed bottom end -->

    </div>
    <!-- Page wrapper end -->

    <!-- Halfmoon JS -->
    <script src="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/js/halfmoon.min.js"></script>
    <script type="text/javascript">
        // Toasts a default alert
        function toastAlert() {
            var alertContent = "This is a default alert with <a href='#' class='alert-link'>a link</a> being toasted.";
            // Built-in function
            halfmoon.initStickyAlert({
                content: alertContent,
                title: "Toast!"
            })
        }

        // Toggles the parent's dark mode (if this page is loaded in an iFrame) 
        function parentToggleDarkmode() {
            window.parent.toggleDarkModeFromChild();
        }

        // Override the dark mode toggle function to call the parent's one
        // Again, this is for the case where the page is loaded in an iFrame
        if (window !== window.parent) {
            halfmoon.toggleDarkMode = parentToggleDarkmode;
        }
    </script>

    <script>
        async function getUser() {
            try {
                const response = await axios.get('/api/v1/panic');
                // console.log(response.data[0]['attributes']);
                var name = response.data[0]['attributes']['first_name'];
                var phone = response.data[0]['attributes']['phone_number'];
                var title = response.data[0]['attributes']['title'];

                var mp3_url = '../audio/alarm/alarm.wav';
                (new Audio(mp3_url)).play();

                alert(`${name} has pressed the Panic Button. Help required!!`);

                (new Audio(mp3_url)).play();

                // setInterval(function(){ 
                //     document.getElementById('alarm').play();
                //     alert(`${name} has pressed the Panic Button. Help required!!`); 
                    
                // }, 30000);
                
            } catch (error) {
                //Do nothing
            }
        }

        setInterval(() => {
            getUser();
        }, 10000);
    </script>
</body>

</html>