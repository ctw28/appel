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

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/')}}favicon.ico">
    <link rel="icon" type="image/png" href="{{asset('/')}}favicon.ico">
    <title>
        APPEL - APLIKASI PENDAFTARAN PLP IAIN KENDARI
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
</head>

<body class="bg-gray-200">

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100" style="background-image: url('{{asset('/')}}background-iain-kendari.jpeg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <!-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login Untuk Masuk</h4>
                                </div>
                            </div> -->
                            <div class="card-body">
                                @if(session()->has('fail'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <span class="alert-text">{{session('fail')}}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                @endif
                                <img src="{{asset('/')}}appel-logo.jpg" alt="logo" class="img-fluid" width="300px">
                                <h4 class="font-weight-bolder text-center mt-2 mb-0 text-uppercase">Aplikasi Pendaftaran PLP <br> IAIN Kendari</h4>
                                <h6 class="text-center">Gunakan Akun SIA untuk masuk</h6>
                                <form role="form" class="text-start">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" id="username" class="form-control" required>
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" id="password" class="form-control" required>
                                    </div>
                                    <div class="input-group input-group-static mb-4">
                                        <label for="exampleFormControlSelect1" class="ms-0">Login Sebagai</label>
                                        <select class="form-control" name="login-tipe" id="login-tipe">
                                            <option value="mahasiswa">Mahasiswa</option>
                                            <option value="pembimbing">Pembimbing</option>
                                        </select>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" onclick="login()" class="btn bg-gradient-primary w-100 my-4 mb-2">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                © <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold text-white" target="_blank">Creative Tim</a>
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
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('/')}}assets/js/material-dashboard.min.js?v=3.0.2"></script>

    <script>
        var role = document.querySelector('#login-tipe');


        async function login() {
            let roleValue = role.options[role.selectedIndex].value
            let dataSend = new FormData()
            let username = document.querySelector('#username').value
            let password = document.querySelector('#password').value

            if (roleValue == "mahasiswa") {
                dataSend.append('nim', username)
                dataSend.append('password', password)

                let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/login_mhs", {
                    method: "POST",
                    body: dataSend
                });
                let responseMessage = await response.json()
                console.log(responseMessage);
                if (responseMessage.status === true) {
                    alert("Login Berhasil")
                    let url = "{{route('session.direct',[':role',':iddata'])}}"
                    url = url.replace(':role', roleValue)
                    url = url.replace(':iddata', responseMessage.data[0].iddata)
                    window.location.href = url
                } else {
                    alert("username dan password tidak sesuai")
                }

            } else {
                dataSend.append('nip', username)
                dataSend.append('password', password)

                let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/login_konselor", {
                    method: "POST",
                    body: dataSend
                });
                let responseMessage = await response.json()
                console.log(responseMessage);
                if (responseMessage.status === true) {
                    alert("Login Berhasil")
                    let url = "{{route('session.direct',[':role',':idpeg'])}}"
                    url = url.replace(':role', roleValue)
                    url = url.replace(':idpeg', responseMessage.data[0].idpegawai)
                    window.location.href = url
                } else {
                    alert("username dan password tidak sesuai")
                }
            }
        }
    </script>
</body>

</html>