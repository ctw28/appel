@extends('template')

@section('css')
<style>
    .row-success {
        background-color: rgb(172, 209, 175, 0.2);
    }
</style>
@endsection
@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                <h6 class="text-white text-capitalize ps-3">{{$data->kuliah_lapangan_nama}} ({{$data->tahunAkademik->sebutan}})</h6>
            </div>
        </div>
        <div class="card-body pb-2">
            <button type="button" class="btn btn-primary" id="add"><i class="material-icons opacity-10">add</i> Tambah</button>
            <div class="row my-3">
                <div class="col-md-9 col-sm-12">
                    <div class="col-md-6 col-lg-3 col-sm-12 align-middle">
                        <div style="display:inline">
                            <small class="px-0">Tampilkan : &nbsp</small>
                            <select class="px-0" id="limit">
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
                            <input type="text" id="search" placeholder="Pencarian (Tekan Enter)" class="form-control">
                        </div>
                        <!-- <button type="button" class="btn btn-info mx-2" id="search-button"><i class="material-icons opacity-10">search</i></button> -->
                    </div>
                </div>
            </div>
            <div style="overflow-x:auto;">
                <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
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

<!-- Button trigger modal -->
<!-- <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Pembimbing Eksternal (Pamong)</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label" for="nama">Nama Pembimbing Eksternal</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label" for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>
    let fields = [{
            id: 'lokasi',
            type: 'text',
            placeholder: 'Isikan Nama Lokasi',
            autofocus: true,
            required: true,
        },
        {
            id: 'alamat',
            type: 'text',
            placeholder: 'Isikan Alamat',
            required: true,
        },
        {
            id: 'keterangan',
            type: 'text-area',
            placeholder: 'Isikan Keterangan',
        },
    ]
    const limit = document.querySelector('#limit')
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

    limit.addEventListener('change', function(e) {
        setDataLokasi(1)
    })

    const getLokasi = async (id) => {
        let url = "{{route('lokasi.get',':id')}}"
        url = url.replace(':id', id)
        let send = await fetch(url);
        let response = await send.json()
        return response
    }

    const searchInput = document.querySelector('#search')

    searchInput.addEventListener('change', function(e) {
        setDataLokasi(1, false, true)
    })

    const setDataLokasi = async (page, AddAgain = false, search = false) => {
        buttonAddState(buttonAdd, 'enabled');
        let url = "{{route('lokasi.index',[$data->id, ':limit'])}}"
        url = url.replace(':limit', limit.value)
        if (search)
            url += `?search=${searchInput.value}`
        else
            url += `?page=${page}`
        let send = await fetch(url);
        let response = await send.json()
        if (response.status === true) {
            const tbody = document.querySelector('#tbody')
            tbody.innerHTML = ""
            let pagination = document.querySelector('#pagination')
            let from = document.querySelector('#from')
            let to = document.querySelector('#to')
            let total = document.querySelector('#total')
            pagination.innerHTML = ""
            console.log(response.data);
            from.textContent = response.data.from
            to.textContent = response.data.to
            total.textContent = response.data.total
            response.data.links.forEach(function(data, i) {
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
                        page = response.data.current_page - 1
                        link.setAttribute('onclick', `setDataLokasi('${page}')`)
                    }
                } else if (label == "Next &raquo;") {
                    label = label.replace("Next ", "")
                    if (data.url == null) {
                        link.setAttribute('disabled', '')
                    } else {
                        page = response.data.current_page + 1
                        link.setAttribute('onclick', `setDataLokasi('${page}')`)
                    }
                } else {
                    link.setAttribute('onclick', `setDataLokasi('${page}')`)
                }
                link.innerHTML = label
                link.dataset.page = label
                list.appendChild(link)
                pagination.appendChild(list)
            })
            let number = response.data.from
            if (response.data.data.length == 0) {
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
                response.data.data.forEach(function(data, i) {
                    console.log(data);
                    const fragment = document.createDocumentFragment()
                    const tr = document.createElement('tr')
                    tr.dataset.dataId = data.id
                    const tdNo = document.createElement('td')
                    tdNo.className = "text-center"
                    tdNo.textContent = number
                    tr.appendChild(tdNo)
                    fields.forEach(function(item, index) {
                        const td = document.createElement('td')
                        td.dataset.value = data[item.id]
                        td.textContent = data[item.id]
                        tr.appendChild(td)
                    })
                    const tdAksi = document.createElement('td');
                    tdAksi.className = "text-center"
                    const linkKelompok = document.createElement('a')
                    let urlKelompok = "{{route('admin.kelompok',[':id1',':id2'])}}"
                    urlKelompok = urlKelompok.replace(':id1', data.kuliah_lapangan_id)
                    urlKelompok = urlKelompok.replace(':id2', data.id)
                    linkKelompok.href = urlKelompok
                    linkKelompok.style = "margin : 0 10px 0 0"
                    linkKelompok.textContent = `Kelompok (${data.kelompok_count})`
                    linkKelompok.className = "btn btn-info btn-sm"
                    tdAksi.appendChild(linkKelompok)
                    // const addEksternal = document.createElement('a')
                    // addEksternal.dataset.bsToggle = "modal"
                    // addEksternal.dataset.bsTarget = "#exampleModal"
                    // addEksternal.className = "btn btn-secondary btn-sm"
                    // addEksternal.textContent = "Pembimbing Eksteral"
                    // addEksternal.style = "margin : 0 10px 0 0"

                    // tdAksi.appendChild(addEksternal)
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
                    number++
                })
            }
            if (AddAgain) {
                createRowInput()
            }
        }
    }

    setDataLokasi(1)

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
            item['value'] = ''
            if (item.autofocus)
                autofocus = true
            td.appendChild(createInputField(item, autofocus))
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

    const createInputField = (properties, autofocus = false) => {
        var div = document.createElement('div')
        div.className = `input-group input-group-static`
        div.id = `error_${properties.id}`
        var input = document.createElement('input')
        if (properties.type === 'text-area') {
            input = document.createElement('textarea')
            input.innerHTML = properties.value
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
        //ini kalau cancel di pas mengedit
        if (state === 'edit') {
            let parent = e.target.closest('tr')
            let lokasi = await getLokasi(parent.dataset.dataId)
            // console.log(lokasi);
            if (!lokasi.status)
                return alert('ada kesalahan, coba lagi atau refresh halaman')
            return showEditOrCancel(e, 'cancel', [
                lokasi.details.lokasi,
                lokasi.details.alamat,
                lokasi.details.keterangan,
                lokasi.details.kelompok_count,
            ])
            return
        }
        //ini dia cancel kalau sementara mau tambah data tapi dia pencet batal, jadi di remove form input datanya
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
            let id = e.target.closest('tr').dataset.dataId
            let url = "{{route('lokasi.delete',':id')}}"
            url = url.replace(':id', id)
            let send = await fetch(url);
            let response = await send.json()
            if (response.status === true) {
                alert(response.pesan)
                setDataLokasi(1)
                buttonAddState(buttonAdd, 'enabled')
                return
            }
            return alert(response.pesan)
        }
    }

    const showEditOrCancel = (e, state, data) => {
        let parent = e.target.closest('tr');
        // console.log(data);
        fields.forEach(function(item, index) {
            parent.childNodes[index + 1].innerHTML = ''
            let actionColumnIndex = fields.length + 1
            parent.childNodes[actionColumnIndex].innerHTML = ''
            if (state === "edit") {
                item['dataset'] = 'input'
                item['value'] = data[index]
                let autofocus = false
                if (item.autofocus)
                    autofocus = true
                parent.childNodes[index + 1].appendChild(createInputField(item, autofocus))

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
                const linkKelompok = document.createElement('a')
                let urlKelompok = "{{route('admin.kelompok',[':id1',':id2'])}}"
                urlKelompok = urlKelompok.replace(':id1', "{{$data->id}}")
                urlKelompok = urlKelompok.replace(':id2', parent.dataset.dataId)
                linkKelompok.href = urlKelompok
                linkKelompok.style = "margin : 0 10px 0 0"
                linkKelompok.textContent = `Kelompok (${data[3]})`
                linkKelompok.className = "btn btn-info btn-sm"
                parent.childNodes[actionColumnIndex].appendChild(linkKelompok)
                // const addEksternal = document.createElement('a')
                // addEksternal.dataset.bsToggle = "modal"
                // addEksternal.dataset.bsTarget = "#exampleModal"
                // addEksternal.className = "btn btn-secondary btn-sm"
                // addEksternal.textContent = "Pembimbing Eksteral"
                // addEksternal.style = "margin : 0 10px 0 0"
                // parent.childNodes[actionColumnIndex].appendChild(addEksternal)
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
        let lokasi = await getLokasi(parent.dataset.dataId)
        console.log(lokasi);
        if (!lokasi.status)
            return alert('ada kesalahan, coba lagi atau refresh halaman')
        return showEditOrCancel(e, 'edit', [
            lokasi.details.lokasi,
            lokasi.details.alamat,
            lokasi.details.keterangan,
        ])
    }

    const save = async (e, state) => {
        const parent = e.target.closest('tr');
        let urutan = parent.parentElement.childNodes.length
        const inputData = parent.querySelectorAll('[data-group]')
        let dataSend = new FormData()
        dataSend.append('kuliah_lapangan_id', "{{$data->id}}")
        dataSend.append('lokasi', inputData[0].value)
        dataSend.append('alamat', inputData[1].value)
        dataSend.append('keterangan', inputData[2].value)
        let send
        if (state == "store") {
            let url = "{{route('lokasi.store',$data->id)}}"
            send = await fetch(url, {
                method: "POST",
                body: dataSend
            });
        } else if (state == "update") {
            let url = "{{route('lokasi.update',':id')}}"
            url = url.replace(':id', parent.dataset.dataId)
            send = await fetch(url, {
                method: "POST",
                body: dataSend
            });
        }
        let response = await send.json()
        console.log(response);
        if (response.status === true) {
            alert(response.message);
            if (state == "update") {
                // editData = []
                showEditOrCancel(e, 'update', [
                    response.details.lokasi,
                    response.details.alamat,
                    response.details.keterangan,
                    response.details.kelompok_count,
                ])
                return;
            }
            let confirmNext = confirm('Ingin Tambah Data lagi?')
            if (confirmNext) {
                setDataLokasi(1, true)
                return
            }
            setDataLokasi(1)
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
</script>
@endsection