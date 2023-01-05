<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/')}}favicon.ico">
    <link rel="icon" type="image/png" href="{{asset('/')}}favicon.ico">
    <title>
        APPEL - {{$title}}
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{asset('/')}}assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{asset('/')}}assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('/')}}assets/css/material-dashboard.css?v=3.0.2" rel="stylesheet" />
    <style>
        .input-group.input-group-outline.is-focused .form-label,
        .input-group.input-group-outline.is-filled .form-label {
            color: inherit !important;
        }

        .input-group.input-group-outline.is-focused .form-label+.form-control,
        .input-group.input-group-outline.is-filled .form-label+.form-control {
            border-color: #ccc !important;
            border-top-color: transparent !important;
            box-shadow: inset 1px 0 #fff, inset -1px 0 #fff, inset 0 -1px #fff;
        }

        .input-group.input-group-outline.is-focused .form-label:before,
        .input-group.input-group-outline.is-focused .form-label:after,
        .input-group.input-group-outline.is-filled .form-label:before,
        .input-group.input-group-outline.is-filled .form-label:after {
            border-top-color: #ccc;
            box-shadow: inset 0 1px #fff;
        }

        .is-filled {
            border: 1px solid transparent;
            /* color: none !important; */
        }
    </style>
    @yield('css')

</head>