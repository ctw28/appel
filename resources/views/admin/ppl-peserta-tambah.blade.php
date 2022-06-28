@extends('template')
@section('css')
<style>
    .insert {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
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
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Pembimbing :</strong> &nbsp; {{$data->pplPembimbing->pplPembimbingInternal->idpeg}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Pendaftar</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Prodi</th>
                            <th>+</th>
                        </tr>
                    </thead>
                    <tbody id="list-pendaftar">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Masuk Kelompok</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">-</th>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Prodi</th>
                        </tr>
                    </thead>
                    <tbody id="list-anggota-kelompok">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    // let listAnggota = getListAnggota()
    // setDataAnggota()
    // getListAnggota()
    async function getListAnggota(status) {
        let url = "{{route('get.pendaftar',[$data->pplLokasi->ppl->id,$data->id,':status'])}}";
        url = url.replace(':status', status)
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage.data);
        return responseMessage.data
    }
    setPendaftar()
    const listPendaftarContainer = document.querySelector('#list-pendaftar');
    async function setPendaftar() {
        let urlListPesertaBukanAnggota = 'https://sia.iainkendari.ac.id/konseling_api/data_mahasiswa'
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let iddata = []
        let list = await getListAnggota('belum');
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
            console.log(data);
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.id = data.iddata
            let tdNim = document.createElement('td');
            tdNim.innerText = data.nim
            let tdNama = document.createElement('td');
            tdNama.innerText = data.nama
            let tdProdi = document.createElement('td');
            tdProdi.innerText = data.idprodi
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.className = "fa fa-arrow-right text-success"
            tdAct.appendChild(icon)
            tr.appendChild(tdNim)
            tr.appendChild(tdNama)
            tr.appendChild(tdProdi)
            tr.appendChild(tdAct)
            fragment.appendChild(tr);
        });
        listPendaftarContainer.innerHTML = ""
        listPendaftarContainer.appendChild(fragment);
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
            tdProdi.innerText = data.idprodi
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.className = "fa fa-arrow-left text-danger"
            tdAct.appendChild(icon)
            tr.appendChild(tdAct)
            tr.appendChild(tdNo)
            tr.appendChild(tdNim)
            tr.appendChild(tdNama)
            tr.appendChild(tdProdi)
            fragment.appendChild(tr);
        });
        listAnggotaContainer.innerHTML = ""
        listAnggotaContainer.appendChild(fragment);
    }


    listPendaftarContainer.addEventListener('click', async function(e) {
        // alert(e.target.closest('tr').dataset.id)
        // return listPendaftarContainer.removeChild(e.target.closest('tr'));

        const url = "{{route('peserta.store')}}";
        let dataSend = new FormData()
        dataSend.append('ppl_kelompok_id', "{{$data->id}}")
        dataSend.append('ppl_id', "{{$data->pplLokasi->ppl->id}}")
        dataSend.append('iddata', e.target.closest('tr').dataset.id)
        dataSend.append('kelompok_jabatan_id', 1)
        response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        responseMessage = await response.json()
        console.log(responseMessage);
        if (responseMessage.status) {
            listPendaftarContainer.removeChild(e.target.closest('tr'));
            setAnggotaKelompok();
        } else {
            console.log(responseMessage.pesan);
            alert('ada kesalahan, coba lagi');
        }
    });
    listAnggotaContainer.addEventListener('click', async function(e) {
        const url = "{{route('peserta.destroy')}}";
        let dataSend = new FormData()
        dataSend.append('ppl_kelompok_id', "{{$data->id}}")
        dataSend.append('ppl_id', "{{$data->pplLokasi->ppl->id}}")
        dataSend.append('iddata', e.target.closest('tr').dataset.id)
        response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        responseMessage = await response.json()
        console.log(responseMessage);
        if (responseMessage.status) {
            listAnggotaContainer.removeChild(e.target.closest('tr'));
            setPendaftar();
        } else {
            console.log(responseMessage.pesan);
            alert('ada kesalahan, coba lagi');
        }
    });
</script>
@endsection