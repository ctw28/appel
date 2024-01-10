@extends('template')

@section('content')
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">History Bimbingan</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">No</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Nama PPL/PLP</th>
                            <th scope="col">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $history)
                        <tr>
                            <td class="text-center">{{$index+1}}</td>
                            <td class="text-center">{{$history->kuliahLapangan->tahunAkademik->tahun}}</td>
                            <td class="text-center">{{$history->kuliahLapangan->kuliah_lapangan_nama}}</td>
                            <td>

                                @foreach($history->kuliahLapangan->lokasi as $lokasi)
                                {{$lokasi->lokasi}}
                                <ul>
                                    @foreach($lokasi->kelompok as $kelompok)
                                    <li>
                                        <span class="badge badge-primary"><a href="{{route('pembimbing.history.detail',$kelompok->id)}}">{{$kelompok->nama_kelompok}} ({{$kelompok->anggota_count}} Anggota)</a></span>
                                    </li>
                                    @endforeach
                                </ul>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection