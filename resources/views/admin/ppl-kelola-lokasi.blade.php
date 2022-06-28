@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                <h6 class="text-white text-capitalize ps-3">{{$title}}</h6>
            </div>
        </div>
        <div class="card-body pb-2">
            <div class="col-12 col-xl-4">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">Info PLP</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group mb-2">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Tahun Ajar:</strong> &nbsp; {{$pplData->tahunAjar->sebutan}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Nama PLP:</strong> &nbsp; {{$pplData->ppl_nama}}</li>
                        </ul>
                        <a href="{{route('admin.ppl.lokasi.add',$pplData->id)}}" class="btn btn-primary text-right">+ Tambah Lokasi</a>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pplData->pplLokasi as $index => $lokasi)
                    <tr>
                        <td class="text-center">{{$index+1}}</td>
                        <td>{{$lokasi->lokasi}}</td>
                        <td>{{$lokasi->alamat}}</td>
                        <td>{{$lokasi->keterangan}}</td>
                        <td>
                            <a href="{{route('admin.ppl.lokasi.delete',$lokasi->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kelompok ini?')"><i class="material-icons opacity-10" style="font-size:16px">delete</i></a>

                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection