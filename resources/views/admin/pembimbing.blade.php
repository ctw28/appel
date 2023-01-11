@extends('template')
@section('css')
<style>
    .insert,
    .remove {
        cursor: pointer;
    }

    .selected {
        background-color: rgb(172, 209, 175, 0.8);
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Pegawai</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="input-group input-group-outline">
                    <input style="height: 41px;" type="text" class="form-control" id="cari-pegawai" name="q" placeholder="ketikkan Nama / NIP untuk pencarian">
                    <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table table-striped responsive">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Nip</th>
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
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Pembimbing Internal</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="row my-3">
                    <div class="col-md-9 col-sm-12">
                        <div class="col-md-6 col-lg-6 col-sm-12 align-middle">
                            <div style="display:inline">
                                <small class="px-0">Tampilkan : &nbsp</small>
                                <select class="px-0" id="limit">
                                    <!-- <option value="5">5</option> -->
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <small class="px-0">&nbsp;Data</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="d-flex justify-content-end ">
                            <div class="input-group input-group-outline">
                                <!-- <input type="text" id="search" placeholder="Pencarian (Tekan Enter)" class="form-control"> -->
                            </div>
                            <!-- <button type="button" class="btn btn-info mx-2" id="search-button"><i class="material-icons opacity-10">search</i></button> -->
                        </div>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">NIP</th>
                                <th scope="col">Nama Pembimbing</th>
                                <th scope="col">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="list-pembimbing">

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <small>
                            Menampilkan <span id="from"></span> ke <span id="to"></span> dari <span id="total"></span> Data
                        </small>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end pagination-secondary" id="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
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
    const limit = document.querySelector('#limit')
    limit.addEventListener('change', function(e) {
        setPembimbing(1)
    })
    setPembimbing(1)

    async function getListPembimbing(status, page, searchPegawai = false) {
        let url = "{{route('pembimbing.get',[$data->id,':limit'])}}";
        if (!searchPegawai) {
            url = url.replace(':limit', limit.value)
            url += `?page=${page}`
        } else {
            url = url.replace(':limit', 0)
        }
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage.data);
        return responseMessage.data
    }

    const listPembimbingContainer = document.querySelector('#list-pembimbing');
    async function setPembimbing(page) {
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()

        let list = await getListPembimbing('anggota', page);
        let pagination = document.querySelector('#pagination')

        let from = document.querySelector('#from')
        let to = document.querySelector('#to')
        let total = document.querySelector('#total')
        pagination.innerHTML = ""
        // console.log(response.data);
        from.textContent = list.from
        to.textContent = list.to
        total.textContent = list.total
        list.links.forEach(function(data, i) {
            const li = document.createElement('li')
            if (data.active)
                li.className = "page-item active"
            else
                li.className = "page-item"
            const link = document.createElement('a')
            link.className = "page-link page"
            let label = data.label
            let pageLabel = label
            if (label == "&laquo; Previous") {
                label = label.replace(" Previous", "")
                if (data.url == null) {
                    link.setAttribute('disabled', '')
                } else {
                    pageLabel = list.current_page - 1
                    link.setAttribute('onclick', `setPembimbing('${pageLabel}')`)
                }
            } else if (label == "Next &raquo;") {
                label = label.replace("Next ", "")
                if (data.url == null) {
                    link.setAttribute('disabled', '')
                } else {
                    pageLabel = list.current_page + 1
                    link.setAttribute('onclick', `setPembimbing('${pageLabel}')`)
                }
            } else {
                link.setAttribute('onclick', `setPembimbing('${pageLabel}')`)
            }
            link.innerHTML = label
            link.dataset.page = label
            li.appendChild(link)
            pagination.appendChild(li)
        })
        let number = list.from
        list.data.forEach(function(data, i) {
            // console.log(data);
            let tr = document.createElement('tr');
            tr.className = 'text-center'
            tr.dataset.id = data.id
            let tdNo = document.createElement('td');
            tdNo.innerText = number
            let tdNip = document.createElement('td');
            tdNip.innerText = data.pegawai.pegawai_nomor_induk
            let tdNama = document.createElement('td');
            tdNama.innerText = data.pegawai.data_diri.nama_lengkap
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.setAttribute('onclick', 'remove(event)')
            icon.className = "fa fa-times text-danger remove"
            tdAct.appendChild(icon)
            tr.appendChild(tdNo)
            tr.appendChild(tdNip)
            tr.appendChild(tdNama)
            tr.appendChild(tdAct)
            fragment.appendChild(tr);
            number++
        });
        listPembimbingContainer.innerHTML = ""
        listPembimbingContainer.appendChild(fragment);
    }
    const listPegawaiContainer = document.querySelector('#list-pegawai');

    listPegawaiContainer.addEventListener('click', async function(e) {
        const target = e.target.closest('tr')
        console.log(target.dataset);
        const url = "{{route('pembimbing.store',$data->id)}}";
        let requestData = new FormData()
        Object.keys(target.dataset).map(function(key, value) {
            requestData.append(key, target.dataset[key])
        });

        let sendRequest = await fetch(url, {
            method: "POST",
            body: requestData
        })
        response = await sendRequest.json()
        console.log(response);
        if (response.status) {
            listPegawaiContainer.removeChild(e.target.closest('tr'));
            setPembimbing();
        } else {
            console.log(response.pesan);
            alert('ada kesalahan, coba lagi');
        }
        // alert(e.target.closest('tr').dataset.id)
        // return listPegawaiContainer.removeChild(e.target.closest('tr'));
        // e.target.closest('tr').classList.add('selected')
        // let conf = confirm('Tambah jadi pembimbing?')
        // if (conf) {
        //     const url = "{{route('pembimbing-internal.store', $data->id)}}";
        //     let dataSend = new FormData()
        //     dataSend.append('idpeg', e.target.closest('tr').dataset.id)
        //     response = await fetch(url, {
        //         method: "POST",
        //         body: dataSend
        //     })
        //     responseMessage = await response.json()
        //     console.log(responseMessage);
        //     if (responseMessage.status) {
        //         listPegawaiContainer.removeChild(e.target.closest('tr'));
        //         setPembimbing();
        //     } else {
        //         console.log(responseMessage.pesan);
        //         alert('ada kesalahan, coba lagi');
        //     }
        // }
    });

    const add = async function(e) {


    }

    const remove = async (e) => {
        let confirmDelete = confirm('Hapus dari pembimbing?')
        if (confirmDelete) {
            const url = "{{route('pembimbing-internal.destroy',$data->id)}}";
            let dataSend = new FormData()
            dataSend.append('id', e.target.closest('tr').dataset.id)
            response = await fetch(url, {
                method: "POST",
                body: dataSend
            })
            responseMessage = await response.json()
            if (responseMessage.status) {
                setPembimbing(1)
                // listPembimbingContainer.removeChild(e.target.closest('tr'));
            } else {
                console.log(responseMessage.pesan);
                alert('ada kesalahan, coba lagi');
            }
        }
    };

    let fieldCari = document.querySelector("#cari-pegawai")
    fieldCari.addEventListener("change", async function(e) {
        const templateLoader = document.querySelector("#cari-data-peserta")
        const firstClone = templateLoader.content.cloneNode(true);

        listPegawaiContainer.innerHTML = ""
        listPegawaiContainer.appendChild(firstClone)
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let idpeg = []
        let list = await getListPembimbing('anggota', 1, true);
        console.log(list);
        list.forEach(function(data) {
            idpeg.push(data.pegawai.idpeg);
        });
        if (idpeg.length != 0)
            dataSend.append('pegawai_id', JSON.stringify(idpeg))
        dataSend.append('q', e.target.value)
        response = await fetch('https://sia.iainkendari.ac.id/konseling_api/search_pegawai', {
            method: "POST",
            body: dataSend
        })
        responseMessage = await response.json()
        console.log('ini dari sia');
        console.log(responseMessage);
        responseMessage.forEach(function(data, i) {
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.idpeg = data.idpegawai
            tr.dataset.nama_lengkap = data.nama
            tr.dataset.pegawai_nomor_induk = data.nip
            tr.dataset.jenis_kelamin = data.kelamin
            tr.dataset.lahir_tempat = data.tmplahir
            tr.dataset.lahir_tanggal = data.tgllahir
            tr.dataset.no_hp = data.hp
            tr.dataset.alamat_ktp = data.alamat
            tr.dataset.statuspeg = data.statuspeg
            tr.dataset.dosentetap = data.dosentetap
            let gelarDepan = (data.glrdepan != "") ? data.glrdepan : '-'
            let gelarBelakang = (data.glrbelakang != "") ? data.glrbelakang : '-'
            tr.dataset.glrdepan = gelarDepan
            tr.dataset.glrbelakang = gelarBelakang
            let tdNip = document.createElement('td');
            tdNip.innerText = data.nip
            let tdNama = document.createElement('td');
            tdNama.innerText = data.nama
            let tdProdi = document.createElement('td');
            tdProdi.innerText = data.idprodi
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.className = "fa fa-arrow-right text-success"
            // icon.setAttribute('onclick', `add(event)`)
            tdAct.appendChild(icon)
            tr.appendChild(tdNip)
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