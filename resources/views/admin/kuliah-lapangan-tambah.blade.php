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

            <form action="{{route('admin.ppl-store')}}" method="post" enctype="multipart/form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline mb-2">
                            <select class="form-control" name="tahun_akademik_id" required>
                                <option value="">Pilih Tahun Akademik</option>
                                @foreach($tahunAkademik as $ta)
                                <option value="{{$ta->id}}" {{old('tahun_akademik_id')?'selected' : ''}}>{{$ta->sebutan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline {{(old('kuliah_lapangan_nama'))?'is-filled':''}} my-3">
                            <label class="form-label" for="kuliah_lapangan_nama">Nama {{session('fakultasData')->sebutan}} ({{session('fakultasData')->singkatan}})</label>
                            <input type="text" class="form-control" name="kuliah_lapangan_nama" id="kuliah_lapangan_nama" value="{{old('kuliah_lapangan_nama')}}" required>
                            <small class="text-danger">{{$errors->first('kuliah_lapangan_nama')}}</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline {{(old('kuliah_lapangan_nama'))?'is-filled':''}} my-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control">{{old('keterangan')}}</textarea>
                        </div>
                    </div>
                </div>
                <h6 class="text-uppercase text-body text-xs font-weight-bolder my-2">Tanggal Pendaftaran</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Mulai</label>
                            <input type="date" name="waktu_daftar_mulai" class="form-control" value="{{old('waktu_daftar_mulai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_daftar_mulai')}}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Selesai</label>
                            <input type="date" name="waktu_daftar_selesai" class="form-control" value="{{old('waktu_daftar_selesai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_daftar_selesai')}}</small>

                        </div>
                    </div>
                </div>
                <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Tanggal Publikasi Kelompok</h6>

                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Tanggal Publikasi Kelompok</label>
                            <input type="date" name="waktu_publikasi_kelompok" class="form-control" value="{{old('waktu_publikasi_kelompok')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_publikasi_kelompok')}}</small>

                        </div>
                    </div>
                </div>

                <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Tanggal Pelaksanaan</h6>

                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Mulai</label>

                            <input type="date" name="waktu_pelaksanaan_mulai" class="form-control" value="{{old('waktu_pelaksanaan_mulai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_pelaksanaan_mulai')}}</small>

                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Selesai</label>
                            <input type="date" name="waktu_pelaksanaan_selesai" class="form-control" value="{{old('waktu_pelaksanaan_selesai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_pelaksanaan_selesai')}}</small>

                        </div>
                    </div>
                </div>
                <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Tanggal Pengumpulan Tugas</h6>

                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Mulai</label>
                            <input type="date" name="waktu_tugas_mulai" class="form-control" value="{{old('waktu_tugas_mulai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_tugas_mulai')}}</small>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Selesai</label>
                            <input type="date" name="waktu_tugas_selesai" class="form-control" value="{{old('waktu_tugas_selesai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_tugas_selesai')}}</small>

                        </div>
                    </div>
                </div>

                <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Tanggal Input Nilai</h6>

                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Mulai</label>
                            <input type="date" name="waktu_penilaian_mulai" class="form-control" value="{{old('waktu_penilaian_mulai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_penilaian_mulai')}}</small>

                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="input-group input-group-outline is-filled my-3">
                            <label class="form-label">Selesai</label>
                            <input type="date" name="waktu_penilaian_selesai" class="form-control" value="{{old('waktu_penilaian_selesai')}}" required>
                            <small class="text-danger">{{$errors->first('waktu_penilaian_selesai')}}</small>

                        </div>
                    </div>
                </div>
                <div class="input-group input-group-outline is-filled my-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


@endsection

@section('script')
<script>
    const textarea = document.querySelector('textarea');
    textarea.addEventListener('input', function(e) {
        // alert('gg')
        // console.log(e.target.parentElement);
        if (e.target.value == "")
            e.target.parentElement.classList.remove("is-filled");
        else
            e.target.parentElement.classList.add("is-filled");

    })
</script>
@endsection