@extends('template')

@section('content')
<div class="col-md-12 mb-5 mt-3">
    <h2>Selamat Datang,
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
    </h2>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Bimbingan Saat Ini</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                <div style="overflow-x:auto;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <!-- <th>Waktu</th> -->
                                <th>Lokasi</th>
                                <th>Kelompok</th>
                                <th class="text-center">Anggota</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $item)
                            <tr>
                                <td colspan="6" class="text-center" style="background: #f2f2f2">
                                    <b>{{$item->kuliahLapangan->kuliah_lapangan_nama}}
                                        ({{$item->kuliahLapangan->tahunAkademik->sebutan}})</b>
                                </td>
                            </tr>
                            <!-- <tr>
                            <td rowspan="{{$item->rowspan}}">
                                <b>Pelaksanaan<br>
                                {{$item->kuliahLapangan->waktu_pelaksanaan_mulai}} - {{$item->kuliahLapangan->waktu_pelaksanaan_selesai}}</b>
                            </td>
                        </tr> -->
                            @php $noUrut = 1 @endphp
                            @foreach($item->kuliahLapangan->lokasi as $lokasi)
                            @foreach($lokasi->kelompok as $kelompok)
                            <tr>
                                <td class="text-center">{{$noUrut}}</td>
                                <td>
                                    {{$lokasi->lokasi}}
                                    @if($lokasi->alamat!='-' AND $lokasi->alamat!='')
                                    ({{$lokasi->alamat}})
                                    @endif
                                </td>
                                <td>{{$kelompok->nama_kelompok}}</td>
                                <td class="text-center">{{$kelompok->anggota_count}}</td>
                                <td><a href="{{route('pembimbing.detail.kelompok',$kelompok->id)}}" class="btn btn-primary btn-sm mb-0">Detail</a></td>
                            </tr>
                            @php $noUrut++ @endphp
                            @endforeach
                            @endforeach

                            @endforeach


                        </tbody>
                    </table>
                    <!-- @if(count($data)>0)
                @foreach($data as $item)
                <h5>Nama PLP : &nbsp; <strong class="text-dark">{{$item->kuliahLapangan->kuliah_lapangan_nama}}</strong></h5>
                @foreach($item->kuliahLapangan->lokasi as $lokasi)
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0 ps-0 text-sm"><i class="material-icons opacity-10">pin_drop</i> <strong class="text-dark">{{$lokasi->lokasi}} ({{$lokasi->alamat}})</strong></li>
                </ul>
                <div class="text-end">
                    <a href="{{route('pembimbing.detail.kelompok',$item->id)}}" class="btn btn-primary">Detail <i class="material-icons">double_arrow</i></a>
                </div>
                @endforeach
                <hr>
                @endforeach
                @else
                <p>Anda tidak memiliki bimbingan PLP</p>
                @endif -->


                </div>
            </div>
        </div>
    </div>
</div>
@endsection