@extends('template')

@section('css')
<style>
    .row-success {
        background-color: rgb(172, 209, 175, 0.2);
    }

    .insert,
    .remove {
        cursor: pointer;
    }

    .selected {
        background-color: rgb(172, 209, 175, 0.8);
    }
</style>
<link rel="stylesheet" href="{{asset('/')}}niceselect/css/nice-select2.css" />

@endsection
@section('content')
<div class="col-md-12">
    <!-- <select id="pembimbing">
        <option value="1">Some option</option>
        <option value="2">Another option</option>
        <option value="3" disabled>A disabled option</option>
        <option value="4">Potato</option>
    </select> -->
    <!-- <div id="test">

    </div> -->
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                <h6 class="text-white text-capitalize ps-3">{{$data->lokasi[0]->lokasi}} - {{$data->kuliah_lapangan_nama}} ({{$data->tahunAkademik->sebutan}})</h6>
            </div>
        </div>
        <div class="card-body pb-2">
            <button type="button" class="btn btn-primary" id="add"><i class="material-icons opacity-10">add</i> Tambah</button>
            <table id="datatable" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Kelompok</th>
                        <th>Pembimbing</th>
                        <th>{{session('fakultasData')->sebutan_eksternal}}</th>
                        <!-- ini nanti berubah sesuai fakultas -->
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Data Peserta (<span id="kelompok"></span>)</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                                    <h6 class="text-white text-capitalize ps-3">Pendaftar</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group input-group-outline">
                                    <input style="height: 41px;" type="text" class="form-control" id="cari-pendaftar" name="q" placeholder="ketikkan Nama untuk pencarian">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                </div>
                                <table class="table table-striped responsive">
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
                    <div class="col-lg-12 col-md-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-success shadow-success border-radius-lg pt-3 pb-2">
                                    <h6 class="text-white text-capitalize ps-3">data Peserta</h6>
                                </div>
                            </div>
                            <div class="card-body pb-2">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">No</th>
                                            <th scope="col">NIM</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Prodi</th>
                                            <th scope="col">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-peserta">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
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

<!-- kelompok.get -->
@section('script')

<script src="{{asset('/')}}niceselect/js/nice-select2.js"></script>

<script>

</script>
<script>
    let fields = [{
            id: 'nama_kelompok',
            type: 'text',
            placeholder: 'Isikan Nama Kelompok',
            autofocus: true,
            required: true,
        },
        {
            id: 'pembimbing',
            type: 'select',
            placeholder: 'Pilih Pembimbing',
            required: true,
        },
        {
            id: 'pembimbing_eksternal',
            type: 'text',
            placeholder: 'Isikan {{session("fakultasData")->sebutan_eksternal}}',
        },
        {
            id: 'keterangan',
            type: 'text-area',
            placeholder: 'Isikan Keterangan',
        },
    ]
    const buttonAdd = document.querySelector('#add')
    const buttonAddState = (button, state) => {
        if (state === 'enabled') {
            button.removeAttribute('disabled')
            button.setAttribute(state, state)
            return
        }
        button.removeAttribute('enabled')
        button.setAttribute(state, state)
    }

    const getKelompok = async (id) => {
        let url = "{{route('kelompok.get',':id')}}"
        url = url.replace(':id', id)
        let send = await fetch(url);
        let response = await send.json()
        console.log(response);
        return response
    }

    const setData = async (page, AddAgain = false, search = false) => {
        buttonAddState(buttonAdd, 'enabled');
        let url = "{{route('kelompok.get.all',[$data->id, $data->lokasi[0]->id])}}"
        let send = await fetch(url);
        let response = await send.json()
        console.log(response);
        if (response.status === true) {
            const tbody = document.querySelector('#tbody')
            tbody.innerHTML = ""
            if (response.details.lokasi[0].kelompok.length == 0) {
                const fragment = document.createDocumentFragment()
                const tr = document.createElement('tr')
                const td = document.createElement('td')
                td.className = "text-center"
                td.setAttribute('colspan', fields.length + 2)
                td.textContent = 'Tidak ada data'
                tr.appendChild(td)
                fragment.appendChild(tr)
                tbody.appendChild(fragment)
            } else {
                response.details.lokasi[0].kelompok.forEach(function(data, index) {
                    console.log(data);
                    const fragment = document.createDocumentFragment()
                    const tr = document.createElement('tr')
                    tr.dataset.id = data.id
                    const tdNo = document.createElement('td')
                    tdNo.className = "text-center"
                    tdNo.textContent = index + 1
                    tr.appendChild(tdNo)
                    fields.forEach(function(item, index) {
                        const td = document.createElement('td')
                        if (item.id == "pembimbing") {
                            // if()
                            if (data.pembimbing != null) {
                                td.dataset.value = data.pembimbing.id
                                td.textContent = data.pembimbing.pegawai.data_diri.nama_lengkap
                            } else {
                                td.dataset.value = null
                                td.textContent = '-'
                            }

                        } else {
                            td.dataset.value = data[item.id]
                            td.textContent = data[item.id]
                        }

                        tr.appendChild(td)
                    })
                    const tdAksi = document.createElement('td');
                    tdAksi.className = "text-center"
                    const addAnggota = document.createElement('a')
                    // addAnggota.id = "anggota"
                    addAnggota.dataset.bsToggle = "modal"
                    addAnggota.dataset.bsTarget = "#exampleModal"
                    addAnggota.setAttribute("onclick", 'seePendaftar(event)')
                    addAnggota.className = "btn btn-secondary btn-success anggota"
                    addAnggota.textContent = `Anggota (${data.anggota_count})`
                    addAnggota.style = "margin : 0 10px 0 0"

                    tdAksi.appendChild(addAnggota)
                    tdAksi.appendChild(createButtonAksi({
                        href: '#',
                        icon: 'fa-pencil',
                        margin: '0 10px 0 0',
                        id: 'edit',
                        onclick: 'edit(event)',
                        buttonColor: 'warning'

                    }))
                    tdAksi.appendChild(createButtonAksi({
                        href: '#',
                        icon: 'fa-trash',
                        margin: '0',
                        id: 'delete',
                        onclick: 'deleteItem(event)',
                        buttonColor: 'danger'

                    }))
                    tr.appendChild(tdAksi)
                    fragment.appendChild(tr)
                    tbody.appendChild(fragment)
                })
            }
            if (AddAgain) {
                createRowInput()
            }
        }
    }

    setData(1)

    const createRowInput = () => {
        buttonAddState(buttonAdd, 'disabled')
        const tbody = document.querySelector('#tbody')
        const fragment = document.createDocumentFragment()
        const tr = document.createElement('tr')
        tr.dataset.status = "add"
        const tdNo = document.createElement('td')
        tdNo.textContent = '+'
        tr.appendChild(tdNo)
        fields.forEach(function(item, index) {
            const td = document.createElement('td')
            if (item.type == 'select') {
                const getPembimbing = async () => {
                    let url = "{{route('pembimbing.get',[$data->id, 0])}}"
                    let send = await fetch(url);
                    let response = await send.json()
                    console.log(response);
                    // const pilihan = document.querySelector('#pembimbing')
                    const select = document.createElement('select')
                    select.id = item.id
                    select.dataset.group = ''
                    let option = document.createElement('option')
                    option.value = ''
                    option.text = "Pilih Pembimbing"
                    option.setAttribute('selected', 'selected')
                    select.appendChild(option)

                    response.data.forEach(function(data, index) {
                        let option = document.createElement('option')
                        option.value = data.id
                        option.text = ` ${data.pegawai.pegawai_nomor_induk} - ${data.pegawai.data_diri.nama_lengkap}`
                        // if (index == 2)
                        //     option.setAttribute('selected', 'selected')
                        select.appendChild(option)
                    })
                    const div = document.createElement('div')
                    div.appendChild(select)
                    td.className = "d-flex justify-content-center"
                    td.appendChild(div)
                    NiceSelect.bind(div, {
                        searchable: true
                    });
                }
                getPembimbing()
            } else {
                item['value'] = ''
                if (item.autofocus)
                    autofocus = true
                td.appendChild(createInputField(item, autofocus))
            }
            tr.appendChild(td)
        })
        const tdAksi = document.createElement('td');
        tdAksi.appendChild(createButtonAksi({
            href: '#',
            icon: 'fa-minus',
            margin: '0 10px 0 0',
            id: 'batal',
            onclick: 'cancel(event,"add")',
            buttonColor: 'danger'

        }))
        tdAksi.appendChild(createButtonAksi({
            href: '#',
            icon: 'fa-check',
            margin: '0',
            id: 'simpan',
            onclick: 'save(event,"store")',
            buttonColor: 'success'

        }))
        tr.appendChild(tdAksi)
        fragment.appendChild(tr)
        tbody.insertBefore(fragment, tbody.firstChild)
    }

    buttonAdd.addEventListener('click', function() {
        createRowInput()
    })

    const createInputField = (properties, autofocus = false, data = {}) => {
        var div = document.createElement('div')
        div.className = `input-group input-group-static`
        div.id = `error_${properties.id}`
        var input = document.createElement('input')
        if (properties.type === 'text-area') {
            input = document.createElement('textarea')
            input.innerHTML = properties.value
        } else if (properties.type === 'select') {
            input = document.createElement('select')

            let options = document.createElement('option')
            options.value = ''
            options.text = properties.placeholder

            input.appendChild(options)
        } else {
            input.setAttribute('value', properties.value)
        }
        input.className = 'form-control '
        input.id = properties.id
        input.dataset.group = properties.dataset
        input.setAttribute('placeholder', properties.placeholder)
        if (autofocus)
            input.setAttribute('autofocus', '')
        if (properties.required)
            input.setAttribute('required', '')
        div.appendChild(input)
        return div
    }

    const createButtonAksi = (properties) => {
        const aksi = document.createElement('a')
        aksi.className = `btn btn-${properties.buttonColor} btn-sm`
        // aksi.setAttribute('href', properties.href)
        aksi.setAttribute('id', properties.id)
        aksi.setAttribute('onclick', properties.onclick)
        aksi.setAttribute('title', properties.id)
        aksi.setAttribute('style', `margin : ${properties.margin}`)
        let icon = document.createElement('i');
        icon.className = `fa ${properties.icon}`
        aksi.appendChild(icon)
        return aksi
    }

    const cancel = async (e, state) => {
        if (state === 'edit') {
            let parent = e.target.closest('tr')
            let kelompok = await getKelompok(parent.dataset.id)
            if (!kelompok.status)
                return alert('ada kesalahan, coba lagi atau refresh halaman')
            return showEditOrCancel(e, 'cancel', [
                kelompok.details.nama_kelompok,
                kelompok.details.pembimbing.pegawai.data_diri.nama_lengkap,
                kelompok.details.pembimbing_eksternal,
                kelompok.details.keterangan,
                kelompok.details.anggota_count,
            ])
            return
        }
        let confirmCancel = confirm('Batal Tambah Data?')
        if (confirmCancel) {
            console.log(e.target.closest('tr'));
            e.target.closest('tr').remove()
            buttonAddState(buttonAdd, 'enabled')
        }

    }

    const deleteItem = async (e) => {
        let confirmCancel = confirm('yakin Hapus Data?')
        if (confirmCancel) {
            let id = e.target.closest('tr').dataset.id
            let url = "{{route('kelompok.delete',':id')}}"
            url = url.replace(':id', id)
            let send = await fetch(url);
            let response = await send.json()
            if (response.status === true) {
                alert(response.pesan)
                setData(1)
                buttonAddState(buttonAdd, 'enabled')
                return
            }
            return alert(response.pesan)
        }
    }

    const showEditOrCancel = (e, state, data) => {
        let parent = e.target.closest('tr');
        parent.querySelectorAll('td')[2].classList.remove('d-flex')
        parent.querySelectorAll('td')[2].classList.remove('justify-content-center')
        console.log(data[1]);
        fields.forEach(function(item, index) {
            parent.childNodes[index + 1].innerHTML = ''
            let actionColumnIndex = fields.length + 1
            parent.childNodes[actionColumnIndex].innerHTML = ''
            if (state === "edit") {
                if (item.type == 'select') {
                    const getPembimbing = async () => {
                        let url = "{{route('pembimbing.get',[$data->id, 0])}}"
                        let send = await fetch(url);
                        let response = await send.json()
                        console.log(response);
                        // const pilihan = document.querySelector('#pembimbing')
                        const select = document.createElement('select')
                        select.id = item.id
                        select.dataset.group = ''
                        let option = document.createElement('option')
                        option.value = ''
                        option.text = "Pilih Pembimbing"
                        // option.setAttribute('selected', 'selected')
                        select.appendChild(option)

                        response.data.forEach(function(item, index) {
                            console.log(item.id == data[1]);
                            let option = document.createElement('option')
                            option.value = item.id
                            option.text = ` ${item.pegawai.pegawai_nomor_induk} - ${item.pegawai.data_diri.nama_lengkap}`
                            if (item.id == data[1])
                                option.setAttribute('selected', 'selected')
                            select.appendChild(option)
                        })
                        const div = document.createElement('div')
                        div.appendChild(select)
                        parent.childNodes[index + 1].className = "d-flex justify-content-center"
                        parent.childNodes[index + 1].appendChild(div)
                        NiceSelect.bind(div, {
                            searchable: true
                        });
                    }
                    getPembimbing()
                } else {
                    item['dataset'] = 'input'
                    item['value'] = data[index]
                    let autofocus = false
                    if (item.autofocus)
                        autofocus = true
                    parent.childNodes[index + 1].appendChild(createInputField(item, autofocus))
                }
                parent.childNodes[actionColumnIndex].appendChild(createButtonAksi({
                    href: '#',
                    icon: 'fa-minus',
                    margin: '0 10px 0 0',
                    id: 'batal',
                    onclick: `cancel(event,"edit")`,
                    buttonColor: 'danger'

                }))
                parent.childNodes[actionColumnIndex].appendChild(createButtonAksi({
                    href: '#',
                    icon: 'fa-check',
                    margin: '0',
                    id: 'update',
                    onclick: 'save(event, "update")',
                    buttonColor: 'success'

                }))
            } else {
                parent.className = 'row-success';
                setTimeout(() => {
                    parent.classList.remove('row-success')
                }, 200);
                parent.childNodes[index + 1].innerHTML = data[index]
                const addAnggota = document.createElement('a')
                addAnggota.dataset.bsToggle = "modal"
                addAnggota.dataset.bsTarget = "#exampleModal"
                addAnggota.className = "btn btn-secondary btn-success"
                addAnggota.textContent = `Anggota (${data[3]})`
                addAnggota.style = "margin : 0 10px 0 0"

                parent.childNodes[actionColumnIndex].appendChild(addAnggota)
                parent.childNodes[actionColumnIndex].appendChild(createButtonAksi({
                    href: '#',
                    icon: 'fa-pencil',
                    margin: '0 10px 0 0',
                    id: 'edit',
                    onclick: 'edit(event)',
                    buttonColor: 'warning'

                }))
                parent.childNodes[actionColumnIndex].appendChild(createButtonAksi({
                    href: '#',
                    icon: 'fa-trash',
                    margin: '0',
                    id: 'delete',
                    onclick: 'deleteItem(event)',
                    buttonColor: 'danger'

                }))
            }
        })
        return
    }

    const edit = async (e) => {
        let parent = e.target.closest('tr')
        let kelompok = await getKelompok(parent.dataset.id)
        if (!kelompok.status)
            return alert('ada kesalahan, coba lagi atau refresh halaman')
        if (kelompok.details.pembimbing != null)
            return showEditOrCancel(e, 'edit', [
                kelompok.details.nama_kelompok,
                kelompok.details.pembimbing.id,
                kelompok.details.pembimbing_eksternal,
                kelompok.details.keterangan,
                kelompok.details.anggota_count,

            ])
        return showEditOrCancel(e, 'edit', [
            kelompok.details.nama_kelompok,
            null,
            kelompok.details.keterangan,
            kelompok.details.anggota_count,

        ])

    }

    const save = async (e, state) => {

        const parent = e.target.closest('tr');
        console.log(parent.dataset.id);
        let urutan = parent.parentElement.childNodes.length
        const inputData = parent.querySelectorAll('[data-group]')
        const list = document.querySelectorAll('.list')
        // console.log(list[0].querySelectorAll('.selected')[0].dataset.value);
        // console.log(inputData[1].options[inputData[1].selectedIndex].text);
        // return;
        console.log(inputData);
        // return
        let dataSend = new FormData()
        dataSend.append('lokasi_id', "{{$data->lokasi[0]->id}}")
        dataSend.append('nama_kelompok', inputData[0].value)
        dataSend.append('pembimbing_eksternal', inputData[2].value)
        dataSend.append('keterangan', inputData[3].value)
        dataSend.append('pembimbing_id', list[0].querySelectorAll('.selected')[0].dataset.value)
        let send
        if (state == "store") {
            let url = "{{route('kelompok.store',[$data->id,$data->lokasi[0]->id])}}"
            send = await fetch(url, {
                method: "POST",
                body: dataSend
            });
        } else if (state == "update") {
            let url = "{{route('kelompok.update',':id')}}"
            url = url.replace(':id', parent.dataset.id)
            send = await fetch(url, {
                method: "POST",
                body: dataSend
            });
        }
        let response = await send.json()
        console.log(response);
        // return
        if (response.status === true) {
            alert(response.message);
            if (state == "update") {
                // editData = []
                showEditOrCancel(e, 'update', [
                    response.details.nama_kelompok,
                    response.details.pembimbing.pegawai.data_diri.nama_lengkap,
                    response.details.pembimbing_eksternal,
                    response.details.keterangan,
                    response.details.anggota_count,
                ])
                return;
            }
            let confirmNext = confirm('Ingin Tambah Data lagi?')
            if (confirmNext) {
                setData(1, true)
                return
            }
            setData(1)
            return buttonAddState(buttonAdd, 'enabled')
        } else if (response.status === false) {
            const boxes = document.querySelectorAll('.error-message');
            if (boxes.length > 0) {
                boxes.forEach(box => {
                    box.remove();
                });
            }
            for (const key in response.details) {
                const element = document.querySelector(`#error_${key}`)
                const errorElement = document.createElement('small')
                errorElement.textContent = response.details[key][0]
                errorElement.className = 'text-danger error-message'
                element.appendChild(errorElement)
            }
            return
        }
        return alert('ada kesalahan coba lagi')
    }



    //ini bagian olah peserta pakai modals
    var kelompokId, index

    async function seePendaftar(e) {
        console.log(e.target.parentNode.parentNode.rowIndex);
        kelompokId = e.target.closest('tr').dataset.id
        index = e.target.parentNode.parentNode.rowIndex - 1
        document.querySelector("#kelompok").innerHTML = ""
        document.querySelector("#kelompok").textContent = e.target.closest('tr').querySelectorAll('[data-value]')[0].innerText
        setDataPeserta();
    }
    const searchInput = document.querySelector('#cari-pendaftar')
    const listPendaftar = document.querySelector('#list-pendaftar')

    searchInput.addEventListener("change", async function(e) {
        // alert('sadfa')
        const templateLoader = document.querySelector("#cari-data-peserta")
        const firstClone = templateLoader.content.cloneNode(true);

        listPendaftar.innerHTML = ""
        listPendaftar.appendChild(firstClone)
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let url = "{{route('pendaftar.get',[$data->id,10])}}"
        url += `?search=${e.target.value}`
        send = await fetch(url)

        response = await send.json()
        console.log(response);
        // return
        if (response.details.length > 0) {
            response.details.forEach(function(data, i) {
                let tr = document.createElement('tr');
                tr.className = 'insert text-center'
                tr.dataset.id = data.id
                let tdNim = document.createElement('td');
                tdNim.innerText = data.mahasiswa.nim
                let tdNama = document.createElement('td');
                tdNama.innerText = data.mahasiswa.data_diri.nama_lengkap
                let tdProdi = document.createElement('td');
                tdProdi.innerText = data.mahasiswa.prodi.prodi_kode
                let tdAct = document.createElement('td');
                let icon = document.createElement('i');
                icon.className = "fa fa-arrow-right text-success"
                // icon.setAttribute('onclick', `add(event)`)
                tdAct.appendChild(icon)
                tr.appendChild(tdNim)
                tr.appendChild(tdNama)
                tr.appendChild(tdProdi)
                tr.appendChild(tdAct)
                fragment.appendChild(tr);
            });
        } else {
            let tr = document.createElement('tr');
            const td = document.createElement('td')

            td.setAttribute('colspan', '4')
            td.className = 'text-center'
            td.innerText = "data tidak ditemukan"
            tr.appendChild(td)
            fragment.appendChild(tr);

        }
        listPendaftar.innerHTML = ""
        listPendaftar.appendChild(fragment);
        // console.log(responseMessage);

    });

    listPendaftar.addEventListener('click', async function(e) {
        // return alert(kelompokId)
        const target = e.target.closest('tr')
        console.log(target.dataset[0]);
        // if (target.dataset.length == 0)
        //     return alert('kosong');
        const url = "{{route('kelompok.anggota.store')}}";
        let requestData = new FormData()
        requestData.append('kelompok_id', kelompokId)
        requestData.append('pendaftar_id', target.dataset.id)
        requestData.append('jabatan_id', 1)
        let sendRequest = await fetch(url, {
            method: "POST",
            body: requestData
        })
        response = await sendRequest.json()
        if (response.status) {
            listPendaftar.removeChild(e.target.closest('tr'));
            setDataPeserta();
            const listPeserta = document.querySelector("#list-peserta")
            let totalAnggota = listPeserta.querySelectorAll('[data-id]').length;
            document.querySelectorAll(".anggota")[index].textContent = `Kelompok (${totalAnggota+1})`

        } else {
            console.log(response.pesan);
            alert('ada kesalahan, coba lagi');
        }
    });

    async function setDataPeserta() {
        let url = "{{route('kelompok.anggota.get',':id')}}";
        url = url.replace(':id', kelompokId)
        let sendRequest = await fetch(url)
        response = await sendRequest.json()
        console.log(response);
        const listPeserta = document.querySelector("#list-peserta")
        listPeserta.innerHTML = ""
        if (response.details.length > 0) {

            response.details.forEach(function(data, index) {
                // console.log(data);
                const fragment = document.createDocumentFragment()
                let tr = document.createElement('tr');
                tr.className = 'text-center'
                tr.dataset.id = data.id
                let tdNo = document.createElement('td');
                tdNo.innerText = index + 1
                let tdNim = document.createElement('td');
                tdNim.innerText = data.pendaftar.mahasiswa.nim
                let tdNama = document.createElement('td');
                tdNama.innerText = data.pendaftar.mahasiswa.data_diri.nama_lengkap
                let tdProdi = document.createElement('td');
                tdProdi.innerText = data.pendaftar.mahasiswa.prodi.prodi_kode
                let tdAct = document.createElement('td');
                let icon = document.createElement('i');
                icon.setAttribute('onclick', 'remove(event)')
                icon.className = "fa fa-times text-danger remove"
                tdAct.appendChild(icon)
                tr.appendChild(tdNo)
                tr.appendChild(tdNim)
                tr.appendChild(tdNama)
                tr.appendChild(tdProdi)
                tr.appendChild(tdAct)
                fragment.appendChild(tr);
                fragment.appendChild(tr)
                listPeserta.appendChild(fragment)
            })
            return
        }
        const fragment = document.createDocumentFragment()
        const tr = document.createElement('tr')
        const td = document.createElement('td')
        td.className = "text-center"
        td.setAttribute('colspan', '5')
        td.textContent = 'Tidak ada data'
        tr.appendChild(td)
        fragment.appendChild(tr)
        listPeserta.appendChild(fragment)
    }


    const remove = async (e) => {
        let confirmDelete = confirm('Hapus dari Anggota?')
        if (confirmDelete) {
            let url = "{{route('kelompok.anggota.delete',':id')}}";
            url = url.replace(':id', e.target.closest('tr').dataset.id)
            response = await fetch(url)
            responseMessage = await response.json()
            if (responseMessage.status) {
                document.querySelectorAll(".anggota")[index].textContent = `Kelompok (${e.target.closest('tbody').querySelectorAll('tr').length-1})`
                setDataPeserta()
                // listPembimbingContainer.removeChild(e.target.closest('tr'));
            } else {
                console.log(responseMessage.pesan);
                alert('ada kesalahan, coba lagi');
            }
        }
    };
</script>
@endsection