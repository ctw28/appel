@extends('template')

@section('css')
<style>
    .remove {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                <h6 class="text-white text-capitalize ps-3">{{$title}}</h6>
            </div>
        </div>
        <div class="card-body pb-2 pt-0">
            @if(!empty($data))
            <ul class="list-group mb-2">
                <li class="list-group-item border-0 ps-0 text-sm">Nama Kuliah : &nbsp; <strong class="text-dark"></strong></li>
                @if(!empty($data->anggota))
                <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">{{$data->anggota->kelompok->lokasi->lokasi}}</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">{{$data->anggota->kelompok->nama_kelompok}}</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">

                        @if($data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_depan!="-")
                        {{$data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_depan}}
                        @endif
                        {{$data->anggota->kelompok->pembimbing->pegawai->dataDiri->nama_lengkap}}
                        {{$data->anggota->kelompok->pembimbing->pegawai->gelar->gelar_belakang}}
                    </strong></li>
                @else
                <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">-</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">-</strong></li>
                <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">-</strong></li>

                @endif


            </ul>
            <div class="text-start">
                <a href="{{route('mahasiswa.lkh.add',[$data->kuliah_lapangan_id,$data->anggota->id])}}" class="btn btn-primary float-right">+ Tambah LKH</a>
                <!-- <button type="button" class="btn btn-primary" id="add"><i class="material-icons opacity-10">add</i> Tambah</button> -->

                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">{{session('success')}}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

            </div>
            @else
            <p>Anda belum mengikuti PLP</p>
            @endif
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Hari / Tanggal</th>
                        <th scope="col">Uraian Kegiatan</th>
                        <!-- <th scope="col">Dokumentasi</th> -->
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="lkh-data">

                    <!-- @foreach ($data->anggota->lkh as $key => $item)
                    <tr>
                        <td class="text-center">{{$key+1}}</td>
                        <td>{{$item->tgl_lkh}}</td>
                        <td><a href="#" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="detail(event)">{{\Illuminate\Support\Str::limit($item->kegiatan, 30, $end='...')}}</a></td>
                        <td>
                            <a href="{{route('mahasiswa.lkh.delete', $item->id)}}" onclick="return confirm('Yakin Hapus?')" class="btn btn-danger btn-sm"><i class="material-icons opacity-10">delete</i></a>
                        </td>

                    </tr>
                    @endforeach -->


                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Detail LKH</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Hari / Tanggal</h6>
                <p id="tanggal"></p>
                <h6>Uraian Kegiatan</h6>
                <p id="uraian"></p>
                <h6>Dokumentasi</h6>
                <div id="dokumentasi"></div>
                <h6 class="mt-4">Link Lainnya</h6>
                <div id="lainnya">-</div>
                <hr>
                <div id="buttonArea">
                    <button class="btn btn-warning" id="buttonEdit" onclick="edit(event)">Edit LKH</button>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="col-md-12 mt-3">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail LKH</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1" id="lkh-list">
            </div>
        </div>
    </div>
</div> -->
@endsection

@section('script')
<script>
    const tanggal = document.querySelector("#tanggal")
    const uraian = document.querySelector("#uraian")
    const dokumentasi = document.querySelector("#dokumentasi")
    const lainnya = document.querySelector("#lainnya")
    const buttonEdit = document.querySelector("#buttonEdit")
    const buttonArea = document.querySelector("#buttonArea")

    async function detail(e) {
        // alert(e.target.dataset.id)
        let url = "{{route('lkh.detail',':id')}}"
        url = url.replace(':id', e.target.dataset.id)
        let send = await fetch(url);
        let response = await send.json()
        tanggal.textContent = response.tgl_lkh
        uraian.textContent = response.kegiatan
        let foto = ''
        response.dokumentasi.forEach(function(data) {
            foto += `<img width='200px' src='{{asset('/storage/')}}/${data.foto_path}' alt='ggwp'>`
        })
        dokumentasi.innerHTML = foto
        buttonEdit.dataset.id = response.id
    }

    async function edit(e) {
        e.target.remove()
        buttonArea.innerHTML = `<button class="btn btn-success" data-id="${e.target.dataset.id}" onclick="update(event)">Update</button>'
        <button class="btn btn-danger" data-id="${e.target.dataset.id}" onclick='cancel(event)'>Batal</button>'`
        let url = "{{route('lkh.edit',':id')}}"
        url = url.replace(':id', e.target.dataset.id)
        let send = await fetch(url);
        let response = await send.json()
        tanggal.innerHTML = `
        <div class="input-group input-group-outline is-filled">
        <input type="date" id='tgl_lkh' class='form-control' value="${response.tgl_lkh}">
        </div>
        `
        uraian.innerHTML = `
        <div class="input-group input-group-outline is-filled">
        <textarea id='kegiatan' class='form-control' rows='5' cols='50'>${response.kegiatan}</textarea>
        </div>
        `
    }

    async function cancel(e) {
        showEditButton(e)
        let url = "{{route('lkh.edit',':id')}}"
        url = url.replace(':id', e.target.dataset.id)
        let send = await fetch(url);
        let response = await send.json()
        tanggal.textContent = response.tgl_lkh
        uraian.textContent = response.kegiatan
        buttonEdit.dataset.id = response.id

    }

    async function update(e) {
        showEditButton(e)
        let url = "{{route('lkh.update',':id')}}"
        url = url.replace(':id', e.target.dataset.id)
        let dataSend = new FormData()
        dataSend.append('anggota_id', e.target.dataset.id)
        dataSend.append('kegiatan', document.querySelector('#kegiatan').value)
        dataSend.append('tgl_lkh', document.querySelector('#tgl_lkh').value)

        let send = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let response = await send.json()
        console.log(response);
        tanggal.textContent = response.data.tgl_lkh
        uraian.textContent = response.data.kegiatan
        buttonEdit.dataset.id = response.id
        showData()
    }

    function showEditButton(e) {
        buttonArea.innerHTML = `<button class="btn btn-warning" data-id="${e.target.dataset.id}" id="buttonEdit" onclick="edit(event)">Edit</button>`
    }
    showData()
    async function showData() {
        let url = "{{route('lkh.index',':id')}}"
        url = url.replace(':id', "{{$data->anggota->id}}")
        let send = await fetch(url);
        let response = await send.json()
        console.log(response);
        let fragment = document.createDocumentFragment();
        const lkhData = document.querySelector('#lkh-data');
        lkhData.innerHTML = ""
        response.data.forEach(function(data, i) {
            let tr = document.createElement('tr');
            tr.className = 'text-center'
            tr.dataset.id = data.id
            let tdNo = document.createElement('td');
            tdNo.innerText = i + 1
            let tdTanggal = document.createElement('td');
            tdTanggal.innerText = data.tgl_lkh
            let tdKegiatan = document.createElement('td');
            let detail = document.createElement('a')
            detail.href = "#"
            detail.dataset.id = data.id
            detail.dataset.bsToggle = "modal"
            detail.dataset.bsTarget = "#exampleModal"
            detail.setAttribute('onclick', "detail(event)")
            detail.innerText = data.kegiatan
            // data-bs-toggle="modal" data-bs-target="#exampleModal"
            // tdKegiatan.innerText = data.kegiatan
            tdKegiatan.appendChild(detail)
            let tdAct = document.createElement('td');
            let icon = document.createElement('i');
            icon.setAttribute('onclick', 'remove(event)')
            icon.className = "fa fa-times text-danger remove"
            tdAct.appendChild(icon)
            tr.appendChild(tdNo)
            tr.appendChild(tdTanggal)
            tr.appendChild(tdKegiatan)
            tr.appendChild(tdAct)
            fragment.appendChild(tr);
        });
        lkhData.innerHTML = ""
        lkhData.appendChild(fragment);
    }

    async function remove(e) {
        // alert(e.target.parentNode.parentNode.dataset.id)
        // let confirm = 
        if (confirm('yakin hapus data?')) {
            let url = "{{route('lkh.delete',':id')}}"
            url = url.replace(':id', e.target.parentNode.parentNode.dataset.id)
            let send = await fetch(url);
            let response = await send.json()
            console.log(response.status);
            if (response.status == 'success') {
                alert('data berhasil dihapus')
                showData()
                return
            }
            return alert('gagal hapus data')
        }
    }
</script>
@endsection