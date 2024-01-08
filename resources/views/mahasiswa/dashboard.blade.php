@extends('template')

@section('content')
<!-- 
<div class="row">
    <div class="col-md-12 mt-2">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3"> {{session('fakultasData')->singkatan}} yang diikuti</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-0">

            </div>
        </div>
    </div>
</div> -->

<div class="container-fluid ">
    <!-- <div class="page-header min-height-100 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-gradient-primary  opacity-6"></span>
    </div> -->
    <div class="card card-body">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="../assets/img/user_icon.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        {{Auth::user()->userMahasiswa->mahasiswa->dataDiri->nama_lengkap}}
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                        @if(!empty($data))

                        Peserta {{session('fakultasData')->singkatan}}
                        @else
                        Mahasiswa
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0 text-end">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="card card-plain h-100">
                        <!-- <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Informasi {{session('fakultasData')->singkatan}}</h6>
                                </div>
                            </div>
                        </div> -->
                        @if(!empty($data))
                        <div class="card-body p-3">
                            <ul class="list-group mb-4">
                                <li class="list-group-item border-0 ps-0 text-sm">Nama {{session('fakultasData')->singkatan}} : &nbsp; <strong class="text-dark">{{$data->kuliahLapangan->kuliah_lapangan_nama}}</strong></li>
                                <li class="list-group-item border-0 ps-0 text-sm">Tahun Akademik : &nbsp; <strong class="text-dark">{{$data->kuliahLapangan->tahunAkademik->sebutan}}</strong></li>
                                <li class="list-group-item border-0 ps-0 text-sm">Waktu Pelaksanaan : &nbsp; <strong class="text-dark">{{$data->kuliahLapangan->waktu_pelaksanaan_mulai}} - {{$data->kuliahLapangan->waktu_pelaksanaan_selesai}} <span class="badge bg-gradient-warning" style="font-size: 0.8rem;">({{$data->kuliahLapangan->sisa_hari}} Hari Lagi)</strong></span></li>
                            </ul>



                            <hr>
                            <div class="col-3 mt-4">
                                @if(!empty($data->anggota))

                                <a href="{{route('mahasiswa.lkh', $data->kuliahLapangan->id)}}" class="btn btn-info"><i class="material-icons">post_add</i> Kelola LKH</a>
                                @endif
                            </div>
                            <div class="col-12 mt-2">
                                <div class="row">


                                    @if(!empty($data->anggota))
                                    <h6 class="mb-5">Aktivitas (LKH)</h6>

                                    @foreach($data->anggota->lkh as $lkh)

                                    <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                        <div class="card card-blog card-plain">
                                            <div class="card-header p-0 mt-n4 mx-3">
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    @if(env('APP_ENV')=="local")

                                                    <img src="{{asset('/')}}/{{$lkh->dokumentasi[0]->foto_path}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                    @else
                                                    <img src="{{asset('/')}}/{{$lkh->dokumentasi[0]->foto_path}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-body p-3">
                                                <!-- <p class="mb-0 text-sm">Project #2</p> -->
                                                <a href="javascript:;">
                                                    <h5>
                                                        {{$lkh->tgl_lkh}}
                                                    </h5>
                                                </a>
                                                <p class="mb-4 text-sm">
                                                    {{$lkh->kegiatan}}
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <h6>Aktivitas (LKH)</h6>
                                    <p>Belum ada LKH</p>
                                    @endif

                                </div>
                                <!-- <a href="#" class="btn btn-success btn-sm">Lihat semua LKH</a> -->
                            </div>

                        </div>
                        @else
                        <p>Anda tidak mengikuti {{session('fakultasData')->singkatan}} untuk saat ini</p>
                        @endif
                    </div>

                </div>
                @if(!empty($data))

                <div class="col-12 col-xl-4">
                    <div class="card card-plain h-100">
                        <!-- <div class="card-header pb-0 p-3">
                        </div> -->
                        <div class="card-body p-3">
                            <div class="row gx-4 mb-2">
                                <!-- <h6 class="mb-2">Lokasi dan Kelompok</h6> -->
                                <span class="badge bg-gradient-secondary" style="font-size: 1.2rem;">
                                    @if(!empty($data))

                                    @if(!empty($data->anggota))

                                    <h6 class="mb-0" style="color:whitesmoke">{{$data->anggota->kelompok->nama_kelompok}}</h6>
                                    <h5 class="mb-0" style="color:yellow">Lokasi : {{$data->anggota->kelompok->lokasi->lokasi}}</h5>
                                    <p class="mb-0 text-sm" style="text-transform:none;">Alamat : {{$data->anggota->kelompok->lokasi->alamat}}</p>

                                    <!-- <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; </li> -->
                                    @else
                                    <h6 class="mb-0" style="color:whitesmoke">Nama kelompok : Mohon Menunggu... </h6>
                                    <h5 class="mb-0" style="color:yellow">Lokasi : Mohon Menunggu...</h5>
                                    <p class="mb-0 text-sm" style="text-transform:none;">Alamat : Mohon Menunggu...</p> <!-- <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">Mohon menunggu...</strong></li> -->
                                    @endif
                                    @endif
                                </span>
                                <h6 class="my-2">Pembimbing</h6>

                                <div class="col-auto">
                                    <div class="avatar avatar-xl position-relative">
                                        <img src="../assets/img/user_icon.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                    </div>
                                </div>
                                <div class="col-auto my-auto">
                                    <div class="h-100">
                                        <h6 class="mb-1">

                                            @if(!empty($data->anggota))
                                            <strong class="text-dark">

                                                @if($data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_depan!="-")
                                                {{$data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_depan}}
                                                @endif
                                                {{$data->anggota->kelompok->pembimbing->pegawai->dataDiri->nama_lengkap}}
                                                {{$data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_belakang}}

                                            </strong>
                                            <p class="mb-0 text-sm">NIP. {{$data->anggota->kelompok->pembimbing->pegawai->pegawai_nomor_induk}}</p>
                                            <p class="mb-0 text-sm"><a href=""><i class="fa fa-whatsapp" aria-hidden="true" style="color:green"></i> {{$data->anggota->kelompok->pembimbing->pegawai->dataDiri->no_hp}}</a></p>
                                            @else
                                            Belum ada pembimbing
                                            @endif

                                        </h6>
                                        <p class="mb-0 font-weight-normal text-sm">
                                            <!-- Peserta {{session('fakultasData')->singkatan}} -->
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if(!empty($data->anggota))
                            <h6 class="my-3">Anggota Kelompok ({{count($data->anggota->kelompok->anggota)}} Peserta)</h6>

                            <ul class="list-group">
                                @foreach($data->anggota->kelompok->anggota as $anggota)
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                    <div class="avatar me-3">
                                        <img src="../assets/img/user_icon.png" alt="kal" class="border-radius-lg shadow">
                                    </div>
                                    <div class="d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{$anggota->pendaftar->mahasiswa->dataDiri->nama_lengkap}} ({{$anggota->pendaftar->mahasiswa->nim}})</h6>
                                        <p class="mb-0 text-xs">Prodi {{$anggota->pendaftar->mahasiswa->prodi->prodi_kode}}</p>
                                    </div>
                                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto" href="javascript:;">
                                        <!-- +6285231800852 -->
                                        <a id="kirimwa_{{$anggota->id}}" href="https://web.whatsapp.com/send?phone={{$anggota->pendaftar->mahasiswa->dataDiri->no_hp}}" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true" style="color:green"></i></a>
                                        <!-- <i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 18px;color:green"></i> -->

                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    <hr class="vertical dark">
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection