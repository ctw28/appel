@extends('template')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-200 border-radius-xl" style="background-image: url('{{asset('/')}}/back-2.jpg');">
        <span class="mask bg-gradient-info opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="{{asset('/')}}assets/img/user_icon.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        @if(Auth::user()->userPegawai->pegawai->gelar)
                        @if(Auth::user()->userPegawai->pegawai->gelar->gelar_depan!="-")
                        {{Auth::user()->userPegawai->pegawai->gelar->gelar_depan}}
                        @endif
                        @endif
                        {{Auth::user()->userPegawai->pegawai->dataDiri->nama_lengkap}}
                        @if(Auth::user()->userPegawai->pegawai->gelar)
                        @if(Auth::user()->userPegawai->pegawai->gelar->gelar_belakang!="-")
                        {{Auth::user()->userPegawai->pegawai->gelar->gelar_belakang}}
                        @endif
                        @endif
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                        Pembimbing
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-md-8 me-auto my-auto text-left mt-4">
    <h5>Bimbingan Saat Ini</h5>
</div>

@foreach($data as $index => $item)
@foreach($item->kuliahLapangan->lokasi as $lokasi)
<div class="col-md-12 mb-lg-0 mb-4">
    <div class="card mt-3">
        <div class="card-header pb-0 p-4">
            <div class="row">
                <div class="col-6 d-flex align-items-center ">
                    <i class="material-icons opacity-10 text-dark me-2" style="font-size:30px">villa</i>
                    <h5 class="mb-0 me-2">

                        {{$lokasi->lokasi}}
                    </h5>
                    @if($lokasi->alamat!='-' AND $lokasi->alamat!='')
                    <span class="text-sm">
                        ({{$lokasi->alamat}})
                    </span>
                    @endif
                </div>

            </div>
        </div>
        <div class="card-body p-3">
            <div class="row">
                @foreach($lokasi->kelompok as $kelompok)

                <div class="col-md-4 mb-md-0 mb-4 ">
                    <div class="card card-body">


                        <div class="row gx-4">
                            <div class="col-auto">
                                <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg me-3">
                                    <i class="material-icons opacity-10">list_alt</i>
                                </div>
                            </div>
                            <div class="col-auto my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1">
                                        {{$kelompok->nama_kelompok}}

                                    </h5>
                                    <p class="mb-0 font-weight-normal text-md">
                                        {{$kelompok->anggota_count}} Peserta
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 mt-3 text-end">

                                <a href="{{route('pembimbing.detail.kelompok',$kelompok->id)}}" class="btn btn-dark btn-sm me-2">
                                    Detail
                                    <i class="material-icons opacity-10" style="font-size:14px">navigate_next</i>
                                </a>
                                <a href="{{route('pembimbing.nilai.input',$kelompok->id)}}" class="btn btn-warning btn-sm ">
                                    Penilaian
                                    <i class="material-icons opacity-10" style="font-size:14px">grade</i>
                                </a>
                            </div>
                        </div>



                        <!-- <i class="material-icons ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Card">edit</i> -->
                    </div>
                </div>
                @endforeach

                <!-- <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                        <img class="w-10 me-3 mb-0" src="../../../assets/img/logos/visa.png" alt="logo">
                        <h6 class="mb-0">****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;5248</h6>
                        <i class="material-icons ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Card">edit</i>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endforeach

@endforeach

@endsection