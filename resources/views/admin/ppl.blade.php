@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                <h6 class="text-white text-capitalize ps-3">{{$title}}</h6>
            </div>
            <a href="{{route('admin.ppl-tambah')}}" class="btn btn-primary float-right">+ Tambah PLP</a>
        </div>
        <div class="card-body pb-2 pt-0">
            @if(session()->has('status'))
            <div class="alert alert-{{session('label')}} alert-dismissible fade show" role="alert">
                <span class="alert-text text-white">{{session('pesan')}}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Tahun Akademik</th>
                        <th scope="col">Nama PLP</th>
                        <th scope="col">Pendaftaran</th>
                        <th scope="col">Status</th>
                        <th scope="col">Kelola</th>
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

                            <div class="dropdown">
                                <button class="btn btn-sm bg-gradient-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Kelola
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{route('admin.ppl.syarat.prodi',$data->id)}}">Syarat</a></li>
                                    <li><a class="dropdown-item" href="{{route('admin.ppl.lokasi',$data->id)}}">Lokasi</a></li>
                                    <li><a class="dropdown-item" href="{{route('admin.ppl.pembimbing-internal',$data->id)}}">Pembimbing</a></li>
                                    <li><a class="dropdown-item" href="{{route('admin.ppl.edit',$data->id)}}">Edit</a></li>
                                    <li><a class="dropdown-item" onclick="return confirm('menghapus data akan menghapus semua data terkait PPL ini. Yakin hapus?')" href="{{route('admin.ppl.delete',$data->id)}}">Hapus</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection