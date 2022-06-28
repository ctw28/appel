@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                <h6 class="text-white text-capitalize ps-3">{{$title}}</h6>
            </div>
        </div>
        <div class="card-body pb-2 pt-0">
            @if(count($data)>0)
            <ul class="list-group mb-2">
                <li class="list-group-item border-0 ps-0 text-sm">Nama PLP : &nbsp; <strong class="text-dark">{{$data[0]->ppl->ppl_nama}}</strong></li>
                @if(count($data[0]->pplKelompokAnggota) > 0)
                <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">{{$data[0]->pplKelompokAnggota[0]->pplKelompok->pplLokasi->lokasi}}</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">{{$data[0]->pplKelompokAnggota[0]->pplKelompok->nama_kelompok}}</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark"><span id="nama-pembimbing"></span></strong></li>
                @else
                <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">-</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">-</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">-</strong></li>
                @endif
            </ul>
            @else
            <p>Anda belum mengikuti PLP</p>
            @endif
            <a href="{{route('mahasiswa.lkh.add')}}" class="btn btn-primary float-right">+ Tambah LKH</a>
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-text text-white">{{session('success')}}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @endif
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Hari / Tanggal</th>
                        <th scope="col">Uraian Kegiatan</th>
                        <th scope="col">Dokumentasi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data[0]->pplKelompokAnggota[0]->pplLkh as $key => $item)
                    <tr>
                        <td class="text-center">{{$key+1}}</td>
                        <td>{{$item->tgl_lkh}}</td>
                        <td>{{$item->kegiatan}}</td>
                        <td>
                            @if($item->foto_path != null)
                            <a href="{{asset('storage/'.$item->foto_path)}}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <a href="{{route('mahasiswa.lkh.edit', $item->id)}}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{route('mahasiswa.lkh.delete', $item->id)}}" onclick="return confirm('Yakin Hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>

                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    setPembimbing()
    var namaPembimbing = document.querySelector('#nama-pembimbing')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setPembimbing() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/get_pegawai/{{$data[0]->pplKelompokAnggota[0]->pplKelompok->pplPembimbing->pplPembimbingInternal->idpeg}}");
        let responseMessage = await response.json()
        console.log(responseMessage);
        namaPembimbing.innerHTML = `${responseMessage[0].glrdepan} ${responseMessage[0].nama} ${responseMessage[0].glrbelakang} (NIP. ${responseMessage[0].nip})`
    }
</script>
@endsection