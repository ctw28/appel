<!DOCTYPE html>
<html lang="en">

@include("parts/head")


<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-apple"></i> <span>APPEL</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            @if(Auth::user()->roleDefault()->role->nama_role=="administrator" || Auth::user()->roleDefault()->role->nama_role =="admin_fakultas")
                            <h2>{{Auth::user()->name}}</h2>
                            @elseif(Auth::user()->roleDefault()->role->nama_role=="mahasiswa")
                            <h2>{{Auth::user()->userMahasiswa->mahasiswa->dataDiri->nama_lengkap}}</h2>
                            @elseif(Auth::user()->roleDefault()->role->nama_role=="pembimbing")
                            <h2>{{Auth::user()->userPegawai->pegawai->dataDiri->nama_lengkap}}</h2>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        @if(Auth::user()->roleDefault()->role->nama_role=="administrator" || Auth::user()->roleDefault()->role->nama_role =="admin_fakultas")
                        @include('parts/menu-admin')
                        @elseif(Auth::user()->roleDefault()->role->nama_role=="mahasiswa")
                        @include('parts/menu-mahasiswa')
                        @elseif(Auth::user()->roleDefault()->role->nama_role=="pembimbing")
                        @include('parts/menu-pembimbing')
                        @endif


                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mx-3">
                            @csrf
                            <button type="submit" class="btn btn-secondary align-items-center w-100">Logout</button>
                        </form>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="images/img.jpg" alt="">
                                    @if(Auth::user()->roleDefault()->role->nama_role=="administrator" || Auth::user()->roleDefault()->role->nama_role =="admin_fakultas")
                                    {{Auth::user()->name}}
                                    @elseif(Auth::user()->roleDefault()->role->nama_role=="mahasiswa")
                                    {{Auth::user()->userMahasiswa->mahasiswa->dataDiri->nama_lengkap}}
                                    @elseif(Auth::user()->roleDefault()->role->nama_role=="pembimbing")
                                    {{Auth::user()->userPegawai->pegawai->dataDiri->nama_lengkap}}
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:;"> Profile</a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">Help</a>
                                    <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </div>
                            </li>

                            <!-- <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item">
                                            <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <div class="text-center">
                                            <a class="dropdown-item">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li> -->
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">

                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12  ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>{{$title}}</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    @yield('content')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('/')}}assets/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{asset('/')}}assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="{{asset('/')}}assets/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="{{asset('/')}}assets/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('/')}}assets/build/js/custom.min.js"></script>
</body>

</html>