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
    <div class="col-lg-6 col-md-6">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Pegawai</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="input-group input-group-outline my-3">

                    <input style="height: 41px;" type="text" class="form-control" id="cari-pegawai" name="q" placeholder="ketikkan Nama / NIP untuk pencarian">
                    <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Nama</th>
                            <th>+</th>
                        </tr>
                    </thead>
                    <tbody id="list-pegawai">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Pembimbing Internal</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">-</th>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                        </tr>
                    </thead>
                    <tbody id="list-pembimbing">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<template id="cari-data-peserta">
    <tr>
        <td colspan="3" align="center">
            <i class="fa fa-circle-o-notch fa-spin"></i> Mohon menunggu, sedang mencari data
        </td>
    </tr>
</template>

@endsection

@section('script')
<script>
    let listAnggota = getListPembimbing()
    // setDataAnggota()
    // getListPembimbing()
    async function getListPembimbing(status) {
        let url = "{{route('ppl.pembimbing',$pplData->id)}}";
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage.data);
        return responseMessage.data
    }
    setPegawai()
    const listPegawaiContainer = document.querySelector('#list-pegawai');
    async function setPegawai() {
        let url = 'https://sia.iainkendari.ac.id/konseling_api/pegawai_not_in'
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let idpeg = []
        let list = await getListPembimbing('belum');
        list.forEach(function(data) {
            idpeg.push(data.idpeg);
        });
        // console.log(idpeg);
        if (idpeg.length != 0)
            dataSend.append('idpegawai', JSON.stringify(idpeg))

        let response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()
        // console.log(responseMessage);
        responseMessage.forEach(function(data, i) {
            // console.log(data);
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.id = data.idpegawai
            let tdNama = document.createElement('td');
            tdNama.innerText = `${data.nama} - ${data.nip}`
            let tdProdi = document.createElement('td');
            tdProdi.innerText = data.idprodi
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.className = "fa fa-arrow-right text-success"
            tdAct.appendChild(icon)
            tr.appendChild(tdNama)
            tr.appendChild(tdAct)
            fragment.appendChild(tr);
        });
        listPegawaiContainer.innerHTML = ""
        listPegawaiContainer.appendChild(fragment);
    }
    setPembimbing()
    const listPembimbingContainer = document.querySelector('#list-pembimbing');
    async function setPembimbing() {
        let url = 'https://sia.iainkendari.ac.id/konseling_api/data_konselor'
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let idpeg = []
        let list = await getListPembimbing('anggota');
        list.forEach(function(data) {
            idpeg.push(data.idpeg);
        });
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
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.id = data.idpegawai
            let tdNo = document.createElement('td');
            tdNo.innerText = i + 1
            let tdNama = document.createElement('td');
            tdNama.innerText = `${data.nama} - ${data.nip}`
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.className = "fa fa-arrow-left text-danger"
            tdAct.appendChild(icon)
            tr.appendChild(tdAct)
            tr.appendChild(tdNo)
            tr.appendChild(tdNama)
            fragment.appendChild(tr);
        });
        listPembimbingContainer.innerHTML = ""
        listPembimbingContainer.appendChild(fragment);
    }

    listPegawaiContainer.addEventListener('click', async function(e) {
        // alert(e.target.closest('tr').dataset.id)
        // return listPegawaiContainer.removeChild(e.target.closest('tr'));

        const url = "{{route('pembimbing-internal.store', $pplData->id)}}";
        let dataSend = new FormData()
        dataSend.append('idpeg', e.target.closest('tr').dataset.id)
        response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        responseMessage = await response.json()
        console.log(responseMessage);
        if (responseMessage.status) {
            listPegawaiContainer.removeChild(e.target.closest('tr'));
            setPembimbing();
        } else {
            console.log(responseMessage.pesan);
            alert('ada kesalahan, coba lagi');
        }
    });
    listPembimbingContainer.addEventListener('click', async function(e) {
        const url = "{{route('pembimbing-internal.destroy',$pplData->id)}}";
        let dataSend = new FormData()
        dataSend.append('idpeg', e.target.closest('tr').dataset.id)
        response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        responseMessage = await response.json()
        // console.log(responseMessage);
        if (responseMessage.status) {
            listPembimbingContainer.removeChild(e.target.closest('tr'));
            setPegawai();
        } else {
            console.log(responseMessage.pesan);
            alert('ada kesalahan, coba lagi');
        }
    });
    let fieldCari = document.querySelector("#cari-pegawai")
    fieldCari.addEventListener("change", async function(e) {

        // return alert("masuk");
        const templateLoader = document.querySelector("#cari-data-peserta")
        const firstClone = templateLoader.content.cloneNode(true);

        listPegawaiContainer.innerHTML = ""
        listPegawaiContainer.appendChild(firstClone)
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let idpeg = []
        let list = await getListPembimbing('anggota');
        list.forEach(function(data) {
            idpeg.push(data.idpeg);
        });
        if (idpeg.length != 0)
            dataSend.append('pegawai_id', JSON.stringify(idpeg))
        dataSend.append('q', e.target.value)
        response = await fetch('https://sia.iainkendari.ac.id/konseling_api/search_pegawai', {
            method: "POST",
            body: dataSend
        })
        responseMessage = await response.json()
        console.log(responseMessage);
        responseMessage.forEach(function(data, i) {
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.id = data.idpegawai
            let tdNama = document.createElement('td');
            tdNama.innerText = `${data.nama} - ${data.nip}`
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.className = "fa fa-arrow-right text-success"
            tdAct.appendChild(icon)
            tr.appendChild(tdNama)
            tr.appendChild(tdAct)
            fragment.appendChild(tr);
        });
        listPegawaiContainer.innerHTML = ""
        listPegawaiContainer.appendChild(fragment);
        // console.log(responseMessage);

    });
</script>
@endsection