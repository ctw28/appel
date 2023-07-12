@extends('template')

@section('content')
<div class="row">
    <div class="col-md-12 mt-5">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">
                        {{$data[0]->lokasi->kuliahLapangan->kuliah_lapangan_nama}}
                        ({{$data[0]->lokasi->kuliahLapangan->tahunAkademik->sebutan}})
                    </h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                @if(count($data)>0)
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">{{$data[0]->lokasi->lokasi}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Alamat : &nbsp; <strong class="text-dark">{{$data[0]->lokasi->alamat}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">{{$data[0]->nama_kelompok}}</strong></li>


                </ul>
                @else
                <p>Anda belum mengikuti PLP</p>
                @endif

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-2">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Anggota Kelompok</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                <div style="overflow-x:auto;">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" class="text-center">No</th>
                                <th scope="col">NIM</th>
                                <th scope="col">NAMA</th>
                                <th scope="col">PRODI</th>
                                <th scope="col">NO HP</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($data[0]->anggota)==0)
                            <tr>
                                <td class="text-center" colspan="6">Tidak ada anggota kelompok</td>
                            </tr>
                            @else
                            @foreach($data[0]->anggota as $index => $item)
                            <tr class="text-center">
                                <td class="text-center">{{$index + 1}}</td>
                                <td>{{$item->pendaftar->mahasiswa->nim}}</td>
                                <td class="text-center">{{$item->pendaftar->mahasiswa->dataDiri->nama_lengkap}}</td>
                                <td>{{$item->pendaftar->mahasiswa->prodi->prodi_nama}} ({{$item->pendaftar->mahasiswa->prodi->prodi_kode}})</td>
                                <td>{{$item->pendaftar->mahasiswa->dataDiri->no_hp}}</td>
                                <td><a href="{{route('pembimbing.detail.lkh',[$data[0]->id,$item->id])}}" class="btn btn-primary btn-sm mb-0">Lihat LKH</a></td>
                            </tr>
                            @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection