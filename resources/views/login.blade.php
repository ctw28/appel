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
                <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login Untuk Masuk</h4>
                </div>
              </div> -->
              <div class="card-body text-center">
                @if(session()->has('fail'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span class="alert-text">{{session('fail')}}</span>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>


                @endif
                <img src="{{asset('/')}}appel-logo.jpg" alt="logo" class="img-fluid" width="300px">
                <h4 class="font-weight-bolder text-center mt-2 mb-0 text-uppercase">Aplikasi Pendaftaran PLP/PPL <br> IAIN Kendari</h4>

                <form role="form" class="text-start" action="{{route('login')}}" method="post">
                  @csrf
                  <input type="hidden" name="is_first" class="form-control" value="0" required>

                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{old('username')}}" required>
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Login</button>
                  </div>
                </form>
                <div class="mt-5">

                  <button data-bs-toggle="modal" data-bs-target="#exampleModal" href="" class="btn btn-warning btn-sm">Reset Password</button>
                </div>
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
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold text-white" target="_blank">Tim Pengembang Sistem UPT TIPD IAIN KENDARI</a>
              </div>
            </div>

          </div>
        </div>
      </footer>
    </div>
  </main>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Form Reset Akun</h5>
        </div>
        <div class="modal-body">
          <p>Pastikan anda inputkan NIM dan Password SIA anda dengan benar. Jika benar, maka akun APPEL anda akan sama dengan akun SIA</p>
          <div class="input-group input-group-outline my-3">
            <label class="form-label">NIM / NIP</label>
            <input type="text" id="nim-check" class="form-control" required>
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Password SIA</label>
            <input type="password" id="password-check" class="form-control" required>
          </div>

          <div class="text-center">
            <button type="button" onclick="resetAkun()" class="btn bg-gradient-warning w-100 my-4 mb-2">Reset Password Ke password SIA</button>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
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
    async function resetAkun() {
      let url = "https://sia.iainkendari.ac.id/konseling_api/check_password";
      let dataSend = new FormData()
      let nim = document.querySelector('#nim-check').value
      let password = document.querySelector('#password-check').value
      if (nim == "")
        return alert('bidang NIM / NIP tidak boleh kosong')
      if (password == "")
        return alert('bidang PASSWORD tidak boleh kosong')
      dataSend.append('nim', nim)
      dataSend.append('password', password)
      let sendData = await fetch(url, {
        method: "POST",
        body: dataSend,
        // mode: 'no-cors'
      })
      let response = await sendData.json()
      console.log(response);
      // return
      if (response.status) {
        let url = "{{route('reset.password')}}";
        let dataSend = new FormData()
        dataSend.append('username', nim)
        dataSend.append('password', password)
        let sendData = await fetch(url, {
          method: "POST",
          body: dataSend
        })
        let response = await sendData.json()
        console.log(response);
        // return
        if (response.status)
          return alert('Akun anda berhasil direset. Silahkan login kembali menggunakan akun SIA')
        return alert('Tidak dapat reset akun. karena anda belum pernah login di aplikasi APPEL ini, silahkan login dulu.')

      }
      alert('NIM dan Password SIA tidak sesuai')
    }
  </script>
</body>

</html>