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

            <form action="{{route('admin.ppl.update',$data->id)}}" method="post" enctype="multipart/form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Tahun Akademik</label>
                            <select class="form-control" name="tahun_ajar_id" id="exampleFormControlSelect1" required>
                                <option value="">Pilih Tahun Akademik</option>
                                @foreach($tahunAjar as $ta)
                                <option value="{{$ta->id}}" @if($ta->id == $data->tahunAjar->id)
                                    selected
                                    @endif
                                    >{{$ta->sebutan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static my-3">
                            <label for="ppl_nama">Nama PLP</label>
                            <input type="text" class="form-control" name="ppl_nama" id="ppl_nama" value="{{$data->ppl_nama}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Pendaftaran (mulai)</label>
                            <input type="date" name="ppl_waktu_daftar_mulai" class="form-control" value="{{$data->ppl_waktu_daftar_mulai}}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Pendaftaran (selesai)</label>
                            <input type="date" name="ppl_waktu_daftar_selesai" class="form-control" value="{{$data->ppl_waktu_daftar_selesai}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Publikasi Kelompok</label>
                            <input type="date" name="ppl_waktu_publikasi" class="form-control" value="{{$data->ppl_waktu_publikasi}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Pelaksanaan PLP (mulai)</label>
                            <input type="date" name="ppl_waktu_pelaksanaan_mulai" class="form-control" value="{{$data->ppl_waktu_pelaksanaan_mulai}}" required>
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Pelaksanaan PLP (selesai)</label>
                            <input type="date" name="ppl_waktu_pelaksanaan_selesai" class="form-control" value="{{$data->ppl_waktu_pelaksanaan_selesai}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Kumpul Tugas (mulai)</label>
                            <input type="date" name="ppl_waktu_tugas_mulai" class="form-control" value="{{$data->ppl_waktu_tugas_mulai}}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Kumpul Tugas (selesai)</label>
                            <input type="date" name="ppl_waktu_tugas_selesai" class="form-control" value="{{$data->ppl_waktu_tugas_selesai}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Penilaian (mulai)</label>
                            <input type="date" name="ppl_waktu_penilaian_mulai" class="form-control" value="{{$data->ppl_waktu_penilaian_mulai}}" required>
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="input-group input-group-static my-3">
                            <label>Tanggal Penilaian (selesai)</label>
                            <input type="date" name="ppl_waktu_penilaian_selesai" class="form-control" value="{{$data->ppl_waktu_penilaian_selesai}}" required>
                        </div>
                    </div>
                </div>
                <div class="input-group input-group-static my-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{$data->keterangan}}</textarea>
                </div>
                <div class="input-group input-group-outline my-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


@endsection