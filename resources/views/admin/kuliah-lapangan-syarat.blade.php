@extends('template')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Pengaturan Syarat Prodi ({{$data->kuliah_lapangan_nama}} {{$data->tahunAkademik->sebutan}})</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <div style="overflow-x:auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Prodi</th>
                                <!-- <th scope="col">Syarat SKS</th> -->
                                <th scope="col">Semester Penawaran</th>
                                <th scope="col">Ikutkan Prodi</th>
                                <!-- <th scope="col">Syarat Mata Kuliah</th> -->
                            </tr>
                        </thead>
                        <tbody id="list-prodi">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- <button type="button" class="btn btn-block btn-light mb-3" data-bs-toggle="modal" data-bs-target="#modal-form">Form</button>
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h5 class="">Pengaturan Syarat Mata Kuliah</h5>
                    </div>
                    <div class="card-body">
                        <form role="form text-left">
                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" id="pilih-kurikulum">
                                    <option value="">Pilih Kurikulum</option>
                                </select>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" id="mata-kuliah">

                                </select>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Pilih Status Mata Kuliah</label>
                                <select class="form-control" name="status" id="status">

                                </select>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Sign in</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('script')
<script>
    // let listAnggota = getProdi()
    // setDataAnggota()
    // getListAnggota()
    var fakultasId = "01"
    getProdi()
    async function getProdi() { //ambil data prodi yang sudah ada di tabel syarat
        let fragment = document.createDocumentFragment();

        let url = "{{route('get.prodi',$data->id)}}";
        let send = await fetch(url);
        let response = await send.json()
        // console.log(response);
        // return response.data
        response.data.prodi.forEach(async function(data, i) {
            console.log(data);
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.id = data.id
            let tdProdi = document.createElement('td');
            tdProdi.innerText = `${data.prodi_nama} (${data.prodi_kode})`
            let no = document.createElement('td');
            no.innerText = i + 1
            let divCheckbox = document.createElement('div');
            let checkbox = document.createElement('input');
            checkbox.className = 'form-check-input text-center jadiSyarat'
            checkbox.type = "checkbox"
            // checkbox.id = ""
            checkbox.value = 0
            checkbox.checked = false
            checkbox.setAttribute('onclick', 'addOrRemove(event)')
            divCheckbox.className = 'form-check form-switch d-flex justify-content-center'
            divCheckbox.appendChild(checkbox)
            let tdCheckbox = document.createElement('td');
            tdCheckbox.appendChild(divCheckbox)
            let div = document.createElement('div');
            div.className = 'input-group input-group-outline text-center'
            // let sksInput = document.createElement('input');
            // let buttonSyaratMatkul = document.createElement('a');
            // buttonSyaratMatkul.dataset.id = data.idprodi
            // buttonSyaratMatkul.setAttribute('href', 'pilihMatkul(event)')
            // buttonSyaratMatkul.className = 'btn btn-sm btn-secondary'
            // buttonSyaratMatkul.setAttribute('disabled', 'disabled')
            // buttonSyaratMatkul.innerText = 'Syarat Mata Kuliah'
            // buttonSyaratMatkul.dataset.bsToggle = "modal"
            // buttonSyaratMatkul.dataset.bsTarget = "#modal-form"
            // sksInput.type = "number"
            // sksInput.dataset.id = data.id
            // sksInput.className = 'text-center'
            // sksInput.setAttribute('value', 0)
            // sksInput.setAttribute('onkeypress', 'updateSks(event)')
            if (data.syarat != null) {
                checkbox.checked = true
                // sksInput.setAttribute('value', data.syarat.sks)
                // buttonSyaratMatkul.className = "btn btn-sm btn-primary"
                // let url = "{{route('admin.ppl.syarat.mata.kuliah',[$data->id,':syarat-prodi-id'])}}"
                // url = url.replace(':syarat-prodi-id', data.syarat.id)
                // buttonSyaratMatkul.href = url
            }
            // if (!checkbox.checked)
            // sksInput.setAttribute('disabled', 'disabled')
            // div.appendChild(sksInput)
            // div.appendChild(sksInput)
            // let tdInput = document.createElement('td');
            // tdInput.appendChild(sksInput)
            // let tdAksi = document.createElement('td');
            // tdAksi.appendChild(buttonSyaratMatkul)
            // Membuat elemen <select>
            let select = document.createElement('select');
            // select.className = 'form-control'
            // Daftar opsi yang akan ditambahkan
            let options = [{
                    value: '',
                    text: 'Pilih Semester Penawaran PLP/PPL'
                },
                {
                    value: '20242',
                    text: 'Tahun 2024 Semester Genap (20242)'
                },
                {
                    value: '20241',
                    text: 'Tahun 2024 Semester Ganjil (20241)'
                },
                {
                    value: '20232',
                    text: 'Tahun 2023 Semester Genap (20232)'
                },
                {
                    value: '20231',
                    text: 'Tahun 2023 Semester Ganjil (20231)'
                },
            ];

            // Menambahkan setiap opsi ke elemen <select>
            options.forEach(function(optionData) {
                let option = document.createElement('option');
                option.value = optionData.value;
                option.text = optionData.text;
                if (data.syarat != null) {
                    if (data.syarat.tahun_penawaran == optionData.value) {
                        option.selected = true;
                    }
                }
                // if(data.syarat.tahun_penawaran==null)
                select.appendChild(option);
            }); // Menambahkan elemen <select> ke dalam dokumen (misalnya, ke dalam body)
            let tdSelect = document.createElement('td');
            tdSelect.appendChild(select)
            tr.appendChild(no)
            tr.appendChild(tdProdi)
            // tr.appendChild(tdInput)
            tr.appendChild(tdSelect)
            tr.appendChild(tdCheckbox)
            fragment.appendChild(tr);
        });
        listProdi.innerHTML = ""
        listProdi.appendChild(fragment);
    }
    // setProdi()
    const listProdi = document.querySelector('#list-prodi');
    async function setProdi() {

        let url = `https://sia.iainkendari.ac.id/Konseling_api/prodi_data/${fakultasId}`
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let idprodi = []
        let list = await getProdi();
        console.log(list.syarat_prodi);
        if (list.syarat_prodi.length != 0) {
            list.syarat_prodi.forEach(function(data) {
                idprodi.push(data.prodi_id);
            });
            console.log(idprodi);
            // dataSend.append('idprodi', JSON.stringify(idprodi))

        }

        let response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()


        // let test = {
        //     'BING': 0

        // }

        // console.log(responseMessage.length);
        responseMessage.forEach(async function(data, i) {
            // console.log(data);
            let tr = document.createElement('tr');
            tr.className = 'insert text-center'
            tr.dataset.id = data.idprodi
            let tdProdi = document.createElement('td');
            tdProdi.innerText = `${data.prodi} (${data.idprodi})`
            let no = document.createElement('td');
            no.innerText = i + 1
            let divCheckbox = document.createElement('div');
            let checkbox = document.createElement('input');
            checkbox.className = 'form-check-input text-center jadiSyarat'
            checkbox.type = "checkbox"
            // checkbox.id = ""
            checkbox.value = 0
            checkbox.checked = false
            checkbox.setAttribute('onclick', 'addOrRemove(event)')
            divCheckbox.className = 'form-check form-switch d-flex justify-content-center'
            divCheckbox.appendChild(checkbox)
            let tdCheckbox = document.createElement('td');
            tdCheckbox.appendChild(divCheckbox)
            let div = document.createElement('div');
            div.className = 'input-group input-group-outline text-center'
            let sksInput = document.createElement('input');
            let buttonSyaratMatkul = document.createElement('a');
            buttonSyaratMatkul.dataset.id = data.idprodi
            // buttonSyaratMatkul.setAttribute('href', 'pilihMatkul(event)')
            buttonSyaratMatkul.className = 'btn btn-sm btn-secondary'
            buttonSyaratMatkul.setAttribute('disabled', 'disabled')
            buttonSyaratMatkul.innerText = 'Syarat Matkul'
            // buttonSyaratMatkul.dataset.bsToggle = "modal"
            // buttonSyaratMatkul.dataset.bsTarget = "#modal-form"
            sksInput.type = "number"
            sksInput.dataset.id = data.idprodi
            sksInput.className = 'text-center'
            sksInput.setAttribute('value', 0)
            sksInput.setAttribute('onkeypress', 'updateSks(event)')
            if (list.syarat_prodi.length != 0) {
                for (let prodi of list.syarat_prodi) {
                    if (prodi.prodi_id === data.idprodi) {
                        checkbox.checked = true
                        sksInput.setAttribute('value', prodi.sks)
                        buttonSyaratMatkul.className = "btn btn-sm btn-primary"
                        let url = "{{route('admin.ppl.syarat.mata.kuliah',[$data->id,':syarat-prodi-id'])}}"
                        url = url.replace(':syarat-prodi-id', prodi.id)
                        buttonSyaratMatkul.href = url
                        break
                    }
                }
            }
            if (!checkbox.checked)
                sksInput.setAttribute('disabled', 'disabled')
            div.appendChild(sksInput)
            let tdInput = document.createElement('td');
            tdInput.appendChild(sksInput)
            let tdAksi = document.createElement('td');
            tdAksi.appendChild(buttonSyaratMatkul)
            tr.appendChild(no)
            tr.appendChild(tdProdi)
            tr.appendChild(tdInput)
            tr.appendChild(tdCheckbox)
            tr.appendChild(tdAksi)
            fragment.appendChild(tr);
        });
        listProdi.innerHTML = ""
        listProdi.appendChild(fragment);
    }

    async function updateSks(e) {
        if (event.key === "Enter") {
            addOrRemove(e)
        }
    }
    async function addOrRemove(e, f = null) {
        if (e.target.closest('tr').querySelector('select').value == "") {
            alert('mohon pilih tahun penawaran PLP/PPL')
            e.target.checked = false
            return
        }
        // return console.log(e.target.closest('tr').querySelector('select').value);
        const tr = e.target.closest('tr')
        const input = tr.querySelectorAll('td')
        // console.log(tr.dataset.id);
        // return;
        const toggle = input[3].lastElementChild.querySelectorAll('input')
        console.log(input[2]);
        if (toggle[0].checked) {

            let url = "{{route('syarat.prodi.store')}}"
            let dataSend = new FormData()
            dataSend.append('kuliah_lapangan_id', '{{$data->id}}')
            dataSend.append('master_prodi_id', tr.dataset.id)
            dataSend.append('sks', 0)
            dataSend.append('tahun_penawaran', e.target.closest('tr').querySelector('select').value)

            let send = await fetch(url, {
                method: "POST",
                body: dataSend
            })
            let response = await send.json()
            console.log(response);
            if (response.status) {
                alert('prodi berhasil ditambahkan')
                input[2].firstElementChild.removeAttribute('disabled')
                let url = "{{route('admin.ppl.syarat.mata.kuliah',[$data->id,':syarat-prodi-id'])}}"
                url = url.replace(':syarat-prodi-id', response.data.id)
                // input[4].firstElementChild.href = url
                // input[4].firstElementChild.className = 'btn btn-sm btn-primary'

            }

        } else {

            let url = "{{route('syarat.prodi.delete')}}"
            let dataSend = new FormData()
            dataSend.append('kuliah_lapangan_id', '{{$data->id}}')
            dataSend.append('master_prodi_id', tr.dataset.id)
            // console.log(input[4].firstElementChild);
            let send = await fetch(url, {
                method: "POST",
                body: dataSend
            })
            let response = await send.json()
            if (response.status) {
                alert('prodi dihapus dari syarat')
                const selectElement = e.target.closest('tr').querySelector('select');
                if (selectElement) {
                    const optionToSelect = selectElement.querySelector('option[value=""]');
                    if (optionToSelect) {
                        optionToSelect.selected = true;
                    }
                }
                // input[2].firstElementChild.setAttribute('value', '0')
                // input[2].firstElementChild.setAttribute('disabled', 'disabled')
                // input[4].firstElementChild.removeAttribute('href')
                // input[4].firstElementChild.className = 'btn btn-sm btn-secondary'

            }

        }
    }

    async function pilihMatkul(e) {
        // alert(e.target.dataset.id)
        const url = 'https://sia.iainkendari.ac.id/api/listkurikulum';
        let dataSend = new FormData();
        dataSend.append('idprodi', e.target.dataset.id);
        let send = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let response = await send.json()
        console.log(response);
        if (response.status) {
            const pilihKurikulum = document.querySelector('#pilih-kurikulum')
            const fragment = document.createDocumentFragment()
            response.data.forEach(function(data, i) {
                let option = document.createElement('option')
                option.value = data.idkurikulum
                option.innerText = data.kurikulum
                fragment.appendChild(option)
            })
            // pilihKurikulum.innerHTML = ""
            pilihKurikulum.appendChild(fragment)
            console.log(response.data);
        }

    }
</script>
@endsection