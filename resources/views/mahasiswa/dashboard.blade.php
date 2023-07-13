@extends('template')

@section('content')
<div class="col-md-12 mb-5 mt-3">
    <h2>Selamat Datang, {{Auth::user()->userMahasiswa->mahasiswa->dataDiri->nama_lengkap}}</h2>
</div>

<div class="row">
    <div class="col-md-12 mt-2">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3"> {{session('fakultasData')->singkatan}} yang diikuti</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-0">
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0 ps-0 text-sm">Nama Kuliah : &nbsp; <strong class="text-dark">{{$data->kuliahLapangan->kuliah_lapangan_nama}} - {{$data->kuliahLapangan->tahunAkademik->sebutan}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Waktu Pelaksanaan : &nbsp; <strong class="text-dark">{{$data->kuliahLapangan->waktu_pelaksanaan_mulai}} - {{$data->kuliahLapangan->waktu_pelaksanaan_selesai}}</strong></li>
                    <h6 class="mt-2">Informasi Kelompok</h6>
                    @if(!empty($data->anggota))
                    <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">{{$data->anggota->kelompok->lokasi->lokasi}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">{{$data->anggota->kelompok->nama_kelompok}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">
                            @if($data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_depan!="-")
                            {{$data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_depan}}
                            @endif
                            {{$data->anggota->kelompok->pembimbing->pegawai->dataDiri->nama_lengkap}}
                            {{$data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_belakang}}
                        </strong></li>
                    @else
                    <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">Mohon menunggu...</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">Mohon menunggu...</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">Mohon menunggu...</strong></li>
                    @endif
                </ul>
                <div>
                    @if(!empty($data->anggota))
                    <a href="{{route('mahasiswa.lkh', $data->kuliahLapangan->id)}}" class="btn btn-primary" style="margin-right:10px"><i class="material-icons">post_add</i> Isi LKH</a>
                    <a href="{{route('mahasiswa.kelompok.detail',$data->anggota->kelompok->id)}}" class="btn btn-success"><i class="material-icons">info</i> Detail Kelompok</a>
                    @else
                    <a href="#" class="btn btn-primary"><i class="material-icons">post_add</i> Isi LKH</a>
                    <a href="#" class="btn btn-secondary"><i class="material-icons">info</i> Detail Kelompok</a>
                    @endif
                </div>
                @else
                <p>Anda tidak mengikuti {{session('fakultasData')->singkatan}} untuk saat ini</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection