@extends('template')

@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Data Pendaftar</h6>
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
                                    <option value="250">250</option>
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
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <!-- <th scope="col">Prodi</th> -->
                                <th scope="col">Kelompok</th>
                                <!-- <th scope="col">Hapus</th> -->
                            </tr>
                        </thead>
                        <tbody id="tbody">

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
    // const searchInput = document.querySelector('#search')

    // searchInput.addEventListener('change', function(e) {
    //     get(1, true)
    // })

    const limit = document.querySelector('#limit')
    limit.addEventListener('change', function(e) {
        get(1)
    })
    const get = async (page, search = false) => {
        let url = "{{route('pendaftar.get',[$data->id,':limit'])}}"
        url = url.replace(':limit', limit.value)
        if (search)
            url += `?search=${searchInput.value}`
        else
            url += `?page=${page}`
        let send = await fetch(url);
        let response = await send.json()
        console.log(response);
        if (response.status === true) {
            const tbody = document.querySelector('#tbody')
            tbody.innerHTML = ""
            let pagination = document.querySelector('#pagination')
            let from = document.querySelector('#from')
            let to = document.querySelector('#to')
            let total = document.querySelector('#total')
            pagination.innerHTML = ""
            from.textContent = response.details.from
            to.textContent = response.details.to
            total.textContent = response.details.total
            response.details.links.forEach(function(data, i) {
                const list = document.createElement('li')
                if (data.active)
                    list.className = "page-item active"
                else
                    list.className = "page-item"
                const link = document.createElement('a')
                link.className = "page-link page"
                let label = data.label
                let page = label
                if (label == "&laquo; Previous") {
                    label = label.replace(" Previous", "")
                    if (data.url == null) {
                        link.setAttribute('disabled', '')
                    } else {
                        page = response.details.current_page - 1
                        link.setAttribute('onclick', `get('${page}')`)
                    }
                } else if (label == "Next &raquo;") {
                    label = label.replace("Next ", "")
                    if (data.url == null) {
                        link.setAttribute('disabled', '')
                    } else {
                        page = response.details.current_page + 1
                        link.setAttribute('onclick', `get('${page}')`)
                    }
                } else {
                    link.setAttribute('onclick', `get('${page}')`)
                }
                link.innerHTML = label
                link.dataset.page = label
                list.appendChild(link)
                pagination.appendChild(list)
            })
            let number = response.details.from
            response.details.data.forEach(function(data, i) {
                const fragment = document.createDocumentFragment()
                const tr = document.createElement('tr')
                tr.dataset.dataId = data.id
                tr.className = "text-center"
                const tdNo = document.createElement('td')
                tdNo.textContent = number
                tr.appendChild(tdNo)
                const tdNim = document.createElement('td')
                tdNim.textContent = data.mahasiswa.nim
                tr.appendChild(tdNim)
                const tdNama = document.createElement('td')
                tdNama.textContent = `${data.mahasiswa.data_diri.nama_lengkap} (${data.mahasiswa.prodi.prodi_kode})`
                tr.appendChild(tdNama)

                const tdKelompok = document.createElement('td')
                if (data.anggota == null)
                    tdKelompok.innerHTML = `<span class="badge bg-gradient-danger">-</span>`
                else
                    tdKelompok.innerHTML = `<span class="badge bg-gradient-info">${data.anggota.kelompok.nama_kelompok} - ${data.anggota.kelompok.lokasi.lokasi}</span>`
                tr.appendChild(tdKelompok)
                fragment.appendChild(tr)
                tbody.appendChild(fragment)
                number++
            })
            return
        }
        tbody.innerHTML = ""
        const fragment = document.createDocumentFragment()
        const tr = document.createElement('tr')
        const td = document.createElement('td')
        td.className = "text-center"
        td.setAttribute('colspan', 4)
        td.textContent = 'Tidak ada data'
        tr.appendChild(td)
        fragment.appendChild(tr)
        tbody.appendChild(fragment)
    }
    get(1)
</script>
@endsection