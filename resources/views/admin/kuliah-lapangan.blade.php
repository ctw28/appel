@extends('template')

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card mt-4">

            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">{{session('fakultasData')->sebutan}} ({{session('fakultasData')->singkatan}})
                        <!-- Tahun : {{$data->tahun}} -->
                    </h6>
                    <!-- <h6 class="text-white text-capitalize ps-3">{{$title}} Tahun : {{$data->tahun}}</h6> -->
                </div>
            </div>
            <div class="card card-body">
                <!-- <h6 class=""></h6> -->
                <div>

                    <a href="{{route('admin.ppl-tambah')}}" class="btn btn-primary">+ Tambah PLP</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row">
        @foreach($data->kuliahLapangan as $index => $row)
        <div class="col-6 mb-3">
            <div class="card card-body">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">{{$row->kuliah_lapangan_nama}} ({{$data->sebutan}})</h6>
                            </div>
                            <!-- <div class="col-md-4 text-end">
                            <a href="javascript:;">
                                <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                            </a>
                        </div> -->
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-sm">
                            Catatan / Keterangan : {{($row->keterangan !='')? $row->keterangan: '-'}}
                        </p>
                        <ul class="list-group mb-3">
                            <li class="list-group-item border-0 ps-0 text-sm">Tanggal Pendaftaran &nbsp; <strong class="text-dark">{{ $row->waktu_daftar_mulai }} - {{ $row->waktu_daftar_selesai }}</strong></li>
                            <li class="list-group-item border-0 ps-0 text-sm">Tanggal Publikasi Kelompok &nbsp; <strong class="text-dark">{{ $row->waktu_publikasi_kelompok }}</strong></li>
                            <li class="list-group-item border-0 ps-0 text-sm">Tanggal Pelaksanaan &nbsp; <strong class="text-dark">{{ $row->waktu_pelaksanaan_mulai }} - {{ $row->waktu_pelaksanaan_selesai }}</strong></li>
                            <li class="list-group-item border-0 ps-0 text-sm">Tanggal Pengumpulan Tugas &nbsp; <strong class="text-dark">{{ $row->waktu_tugas_mulai }} - {{ $row->waktu_tugas_selesai }}</strong></li>
                            <li class="list-group-item border-0 ps-0 text-sm">Tanggal Penilaian &nbsp; <strong class="text-dark">{{ $row->waktu_penilaian_mulai }} - {{ $row->waktu_penilaian_selesai }}</strong></li>
                        </ul>
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0">Aktif</h6>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" data-id="{{ $row->id }}" type="checkbox" onchange="changeAktif(event)" {{ ($row->is_active==true) ? 'checked':''}}>
                            <!-- <label class="form-check-label" for="flexSwitchCheckDefault">Aktif / Tidak Aktif</label> -->
                        </div>
                        <br>
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0">Pengaturan</h6>
                        </div>
                        <a class="btn btn-dark btn-sm" href="{{route('admin.ppl.syarat.prodi',$row->id)}}">Syarat</a>
                        <a class="btn btn-dark btn-sm" href="{{route('admin.ppl.pembimbing-internal.add',$row->id)}}">Pembimbing</a>
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0">Pendaftar</h6>
                        </div>
                        <a class="btn btn-dark btn-sm" href="{{route('pendaftar',$row->id)}}">Lihat Pendaftar ({{$row->pendaftar_count}})</a>
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0">Lokasi, Kelompok dan Peserta</h6>
                        </div>
                        <a class="btn btn-dark btn-sm" href="{{route('admin.lokasi',$row->id)}}">Atur</a>
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-0">Kelola</h6>
                        </div>
                        <a class="btn btn-warning btn-sm" href="{{route('admin.ppl.edit',$row->id)}}">Edit</a>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('menghapus data akan menghapus semua data terkait PPL ini. Yakin hapus?')" href="{{route('admin.ppl.delete',$row->id)}}">Hapus</a>


                    </div>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</div>


@endsection

@section('script')
<script>
    async function changeAktif(e) {
        let kuliahLapanganId = e.target.dataset.id
        let url = "{{route('kuliah-lapangan.isaktif.update',':id')}}"
        url = url.replace(':id', kuliahLapanganId)
        let dataSend = new FormData()
        dataSend.append('is_aktif', e.target.checked)
        let send = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let response = await send.json()
        // console.log(response);
        if (response.status == false) {
            alert('ada kesalahan, coba lagi')
            if (e.target.checked == false)
                e.target.checked = false
            else
                e.target.checked = true
        } else {
            if (e.target.checked == true)
                alert('PPL/PLP telah aktif (mahasiswa / pembimbing dapat melaksanakan proses PLP / PPL)')
            else
                alert('PPL/PLP telah dinonaktfikan')
        }
    }
</script>
@endsection