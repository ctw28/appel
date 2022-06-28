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
            @endif
            <form action="{{route('mahasiswa.lkh.update',$lkhData->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-static my-3">
                    <label>Tanggal LKH</label>
                    <input type="hidden" name="ppl_kelompok_anggota_id" value="{{$data[0]->pplKelompokAnggota[0]->id}}" required>
                    <input type="date" name="tgl_lkh" class="form-control" value="{{$lkhData->tgl_lkh}}" required>
                </div>
                <div class="input-group input-group-static my-3">
                    <label>Uraian Kegiatan (Maksimal 500 karakter)</label>
                    <textarea name="kegiatan" class="form-control" required>{{$lkhData->kegiatan}}</textarea>
                </div>

                <div class="input-group input-group-static my-3">
                    <label>Foto / Dokumentasi</label>
                    <input type="file" name="foto_path" class="form-control">
                </div>
                <div class="input-group input-group-static my-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
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