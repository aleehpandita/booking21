<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name', 'Feraltar'))</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="images/favicon.ico">
  <script>
    const BASE_URL = '{{URL::to('/')}}'
  </script>
  <!-- Bootstrap core CSS -->
  {{-- <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"> --}}

  <!--Material Icon -->
  {{-- <link rel="stylesheet" type="text/css" href="css/materialdesignicons.min.css" /> --}}

  <!-- Pe-icon-7 icon -->
  {{-- <link rel="stylesheet" type="text/css" href="css/pe-icon-7-stroke.css"> --}}

  <!-- Custom  Css -->
  {{-- <link rel="stylesheet" type="text/css" href="css/style.min.css" /> --}}
  @section('head')
  @show
  @vite(['resources/js/app.js'])
  <style>
    :root {
      --animate-duration: 1s;
      --animate-delay: 1s;
      --animate-repeat: 1;
    }
    .animate__animated {
      -webkit-animation-duration: 1s;
      animation-duration: 1s;
      -webkit-animation-duration: var(--animate-duration);
      animation-duration: var(--animate-duration);
      -webkit-animation-fill-mode: both;
      animation-fill-mode: both;
    }
    .animate__animated.animate__faster {
      -webkit-animation-duration: calc(1s / 2);
      animation-duration: calc(1s / 2);
      -webkit-animation-duration: calc(var(--animate-duration) / 2);
      animation-duration: calc(var(--animate-duration) / 2);
    }

    @media print, (prefers-reduced-motion: reduce) {
      .animate__animated {
        -webkit-animation-duration: 1ms !important;
        animation-duration: 1ms !important;
        -webkit-transition-duration: 1ms !important;
        transition-duration: 1ms !important;
        -webkit-animation-iteration-count: 1 !important;
        animation-iteration-count: 1 !important;
      }
      .animate__animated[class*='Out'] {
        opacity: 0;
      }
    }
      /* Zooming entrances */
    @-webkit-keyframes zoomIn {
      from {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
        transform: scale3d(0.3, 0.3, 0.3);
      }

      50% {
        opacity: 1;
      }
    }
    @keyframes zoomIn {
      from {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
        transform: scale3d(0.3, 0.3, 0.3);
      }

      50% {
        opacity: 1;
      }
    }
    .animate__zoomIn {
      -webkit-animation-name: zoomIn;
      animation-name: zoomIn;
    }
    /* Zooming exits */
    @-webkit-keyframes zoomOut {
      from {
        opacity: 1;
      }

      50% {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
        transform: scale3d(0.3, 0.3, 0.3);
      }

      to {
        opacity: 0;
      }
    }
    @keyframes zoomOut {
      from {
        opacity: 1;
      }

      50% {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
        transform: scale3d(0.3, 0.3, 0.3);
      }

      to {
        opacity: 0;
      }
    }
    .animate__zoomOut {
      -webkit-animation-name: zoomOut;
      animation-name: zoomOut;
    }
    #loader {
      position: fixed;
      top:0;
      left: 0;
      width: 100%;
      height: 100vh;
      background-color: rgba(0,0,0,0.3);
      z-index: 10000;
      visibility: hidden;
      display: none;
    }
    .loader {
      position: absolute;
      top:0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.3);
      z-index: 10000;
      visibility: hidden;
      display: none;
    }
    .visivility{
      visibility: visible !important;
      display: flex!important;
    }
  </style>
</head>

<body class="bg-light-subtle">
  <nav class="navbar bg-light shadow-sm sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Feraltar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="{{route('index')}}">Ingresar reserva</a>
            </li>
            {{-- <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li> --}}
          </ul>
          {{-- <form class="d-flex mt-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form> --}}
        </div>
      </div>
    </div>
  </nav>
  <div class="position-relative">
    @yield('content')
  </div>
  <div id="loader" class="animate__animated animate__faster">
    <div class="spinner-grow m-auto text-color1" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</body>

</html>