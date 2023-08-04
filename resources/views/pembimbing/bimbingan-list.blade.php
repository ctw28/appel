@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                <h6 class="text-white text-capitalize ps-3">{{$title}}</h6>
            </div>
        </div>
        <div class="card-body pb-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Tahun Ajar</th>
                        <th scope="col">Nama PLP</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Kelompok</th>
                        <th scope="col">Jumlah Peserta</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $index = 0
                    @endphp
                    @foreach($data as $item)
                    @foreach($item->pembimbing as $row)

                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{$item->ppl->tahunAjar->sebutan}}</td>
                        <td>{{$item->ppl->ppl_nama}}</td>
                        <td>{{$row->pplKelompok->pplLokasi->lokasi}}</td>
                        <td>{{$row->pplKelompok->nama_kelompok}}</td>
                        <td>{{$row->pplKelompok->ppl_kelompok_anggota_count}}</td>
                        <td>
                            <a href="{{route('pembimbing.nilai.input',$row->pplKelompok->id)}}" class="btn btn-sm btn-primary"> <i class="material-icons">dialpad</i> Penilaian</a>
                        </td>
                    </tr>
                    @php $index++ @endphp
                    @endforeach
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection