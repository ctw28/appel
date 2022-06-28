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
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Nama PLP :</strong> &nbsp; {{$data->pplLokasi->ppl->ppl_nama}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Lokasi :</strong> &nbsp; {{$data->pplLokasi->lokasi}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Kelompok :</strong> &nbsp; {{$data->nama_kelompok}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Pembimbing :</strong> &nbsp; <span id="nama-pembimbing"></span></li>
                        </ul>
                        <a href="{{route('admin.ppl.peserta.add',[$data->pplLokasi->ppl->id, $data->pplLokasi->id, $data->id])}}" class="btn btn-primary text-right">+ Atur Peserta</a>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama Peserta</th>
                        <th scope="col">Prodi</th>
                    </tr>
                </thead>
                <tbody id="list-anggota-kelompok">

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
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/get_pegawai/{{$data->pplPembimbing->pplPembimbingInternal->idpeg}}");
        let responseMessage = await response.json()
        console.log(responseMessage);
        namaPembimbing.innerHTML = `${responseMessage[0].glrdepan} ${responseMessage[0].nama} ${responseMessage[0].glrbelakang} (NIP. ${responseMessage[0].nip})`
    }

    async function getListAnggota(status) {
        let url = "{{route('get.pendaftar',[$data->pplLokasi->ppl->id,$data->id,'sudah'])}}";
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage.data);
        return responseMessage.data
    }
    setAnggotaKelompok()
    const listAnggotaContainer = document.querySelector('#list-anggota-kelompok');
    async function setAnggotaKelompok() {
        let urlListPesertaBukanAnggota = 'https://sia.iainkendari.ac.id/konseling_api/data_mahasiswa'
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let iddata = []
        let list = await getListAnggota('anggota');
        list.forEach(function(data) {
            iddata.push(data.iddata);
        });
        if (iddata.length != 0)
            dataSend.append('iddata', JSON.stringify(iddata))

        let response = await fetch(urlListPesertaBukanAnggota, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()
        console.log(responseMessage.length);
        responseMessage.forEach(function(data, i) {
            // console.log(data);
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.id = data.iddata
            let tdNo = document.createElement('td');
            tdNo.innerText = i + 1
            let tdNim = document.createElement('td');
            tdNim.innerText = data.nim
            let tdNama = document.createElement('td');
            tdNama.innerText = data.nama
            let tdProdi = document.createElement('td');
            tdProdi.innerText = `${data.prodi} (${data.idprodi})`
            tr.appendChild(tdNo)
            tr.appendChild(tdNim)
            tr.appendChild(tdNama)
            tr.appendChild(tdProdi)
            fragment.appendChild(tr);
        });
        listAnggotaContainer.innerHTML = ""
        listAnggotaContainer.appendChild(fragment);
    }
</script>
@endsection