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
                    <div class="card-body p-3 pt-1">
                        <ul class="list-group mb-2">
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Nama PLP :</strong> &nbsp; {{$lokasiData->ppl->ppl_nama}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Lokasi :</strong> &nbsp; {{$lokasiData->lokasi}}</li>
                        </ul>
                        <a href="{{route('admin.ppl.kelompok.add',[$lokasiData->ppl->id, $lokasiData->id])}}" class="btn btn-primary text-right">+ Tambah Kelompok</a>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Nama Kelompok</th>
                        <th scope="col">Pembimbing</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lokasiData->pplKelompok as $index => $item)
                    <tr>
                        <td class="text-center">{{$index+1}}</td>
                        <td>{{$item->nama_kelompok}}</td>
                        <td> <span id="pembimbing-{{$item->pplPembimbing->pplPembimbingInternal->idpeg}}"></span></td>
                        <td>{{$item->keterangan}}</td>
                        <td>
                            <a href="{{route('admin.ppl.kelompok.delete',$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kelompok ini?')"><i class="material-icons opacity-10" style="font-size:16px">delete</i></a>

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
    let listAnggota = getListPembimbing()
    // setDataAnggota()
    // getListPembimbing()
    async function getListPembimbing(status) {
        let url = "{{route('get.kelompok',$lokasiData->id)}}";
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage);
        return responseMessage
    }
    setPembimbing()
    const listPembimbingContainer = document.querySelector('#list-pembimbing');
    async function setPembimbing() {
        let url = 'https://sia.iainkendari.ac.id/konseling_api/data_konselor'
        let dataSend = new FormData()
        let idpeg = []
        let list = await getListPembimbing('anggota');
        list.forEach(function(data) {
            idpeg.push(data.ppl_pembimbing.ppl_pembimbing_internal.idpeg);
        });
        // return console.log(idpeg);
        if (idpeg.length != 0)
            dataSend.append('konselor_pegawai_id', JSON.stringify(idpeg))

        let response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()
        // console.log(responseMessage.length);
        responseMessage.forEach(function(data, i) {
            // console.log(data);
            let id = `pembimbing-${data.idpegawai}`
            let pegawaiText = document.querySelector(`#pembimbing-${data.idpegawai}`);
            console.log(pegawaiText);
            pegawaiText.innerText = data.nama;
        });
        listPembimbingContainer.innerHTML = ""
        listPembimbingContainer.appendChild(fragment);
    }
</script>
@endsection