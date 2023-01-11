<!--
=========================================================
* Material Dashboard 2 - v3.0.2
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

@include("parts/head")

<body class="g-sidenav-show  bg-gray-200">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="{{asset('/')}}logo-iain-kendari.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">APPEL IAIN KENDARI</span>
            </a>
        </div>

        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            @if(Auth::user()->roleDefault()->role->nama_role=="administrator" || Auth::user()->roleDefault()->role->nama_role =="admin_fakultas")
            @include('parts/menu-admin')
            @elseif(Auth::user()->roleDefault()->role->nama_role=="mahasiswa")
            @include('parts/menu-mahasiswa')
            @elseif(Auth::user()->roleDefault()->role->nama_role=="pembimbing")
            @include('parts/menu-pembimbing')
            @endif
        </div>
        <!-- <div class=" "> -->
        <!-- <div class="mx-3"> -->
        <div class="sidenav-footer position-absolute w-100 bottom-0 ">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mx-3">
                @csrf
                <button type="submit" class="btn btn-primary align-items-center w-100">Logout</button>
            </form>
        </div>

        <!-- <a class="btn bg-gradient-primary mt-4 w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Logout</a> -->
        <!-- </div> -->
        <!-- </div> -->
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{$title}}</li>
                    </ol>
                    <!-- <h6 class="font-weight-bolder mb-0">{{$title}}</h6> -->
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end" id="navbar">
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center mx-3">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline">
                                    @if(Auth::user()->roleDefault()->role->nama_role=="administrator" || Auth::user()->roleDefault()->role->nama_role =="admin_fakultas")
                                    {{Auth::user()->name}}
                                    @elseif(Auth::user()->roleDefault()->role->nama_role=="mahasiswa")
                                    {{Auth::user()->userMahasiswa->mahasiswa->dataDiri->nama_lengkap}}
                                    @elseif(Auth::user()->roleDefault()->role->nama_role=="pembimbing")
                                    @if(Auth::user()->userPegawai->pegawai->gelar->gelar_depan!="-")
                                    {{Auth::user()->userPegawai->pegawai->gelar->gelar_depan}}
                                    @endif
                                    {{Auth::user()->userPegawai->pegawai->dataDiri->nama_lengkap}}
                                    {{Auth::user()->userPegawai->pegawai->gelar->gelar_belakang}} @endif
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                </div>
                <ul class="navbar-nav  justify-content-end">
                    

                </ul>
            </div> -->
        </nav>
        <!-- End Navbar -->




        <div class="container-fluid py-2">

            <div class="row">
                <!-- <div class="col-md-12"> -->
                @yield('content')

                <!-- </div> -->
            </div>
            <footer class="footer py-4  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                © <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                                for a better web.
                            </div>
                        </div>

                    </div>
                </div>
            </footer>
        </div>
    </main>

    <!--   Core JS Files   -->
    <script src="{{asset('/')}}assets/js/core/popper.min.js"></script>
    <script src="{{asset('/')}}assets/js/core/bootstrap.min.js"></script>
    <script src="{{asset('/')}}assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{asset('/')}}assets/js/plugins/smooth-scrollbar.min.js"></script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('/')}}assets/js/material-dashboard.min.js?v=3.0.2"></script>
    @yield('script')
</body>

</html>