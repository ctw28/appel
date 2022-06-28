@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                <h6 class="text-white text-capitalize ps-3">{{$title}}</h6>
            </div>
        </div>
        <div class="card-body px-0 pb-2">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Tahun Ajar</th>
                        <th scope="col">Nama PLP</th>
                        <th scope="col">Pendaftaran</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pplData as $index => $data)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{$data->tahunAjar->sebutan}}</td>
                        <td>{{$data->ppl_nama}}</td>
                        <td>{{$data->ppl_waktu_daftar}}</td>
                        <td><span class="badge bg-gradient-{{$data->label}}">{{$data->is_finished}}</span></td>
                        <td>
                            <a href="{{route('mahasiswa.ppl.daftar',$data->id)}}" class="btn btn-sm btn-primary">LKH</a>
                            <a href="{{route('mahasiswa.ppl.daftar',$data->id)}}" class="btn btn-sm btn-primary">Laporan</a>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection