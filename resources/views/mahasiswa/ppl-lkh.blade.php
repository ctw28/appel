@extends('template')

@section('css')
<style>
    .remove {
        cursor: pointer;
    }
</style>
@endsection
@section('content')

<div class="col-lg-12 position-relative">
    <a href="{{route('mahasiswa.lkh.add',[$data->kuliah_lapangan_id,$data->anggota->id])}}" class="btn btn-primary btn-sm mb-0">+ Tambah LKH</a>
    <a href="{{route('mahasiswa.lkh.print',[$data->kuliah_lapangan_id])}}" class="btn btn-success btn-sm mb-0">Cetak LKH</a>
    <div class="row" id="contents">

    </div>
    <div class="row mt-5" id="contents">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-primary" id="pagination">
                <!-- Pagination akan ditampilkan di sini -->
            </ul>
        </nav>
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
            foto += `
            @if(env('APP_ENV')=="local")
            
            <img width='200px' src='{{asset('/>')}}/${data.foto_path}' alt='ggwp'>
            @else
            <img width='200px' src='{{asset('/')}}/${data.foto_path}' alt='ggwp'>
            @endif
            `
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
    async function showData(page = 1) {
        let url = "{{route('lkh.index',':id')}}"
        url = url.replace(':id', "{{$data->anggota->id}}")
        url += `?page=${page}`
        let send = await fetch(url);
        let response = await send.json()
        console.log(response);
        let contents = ''
        response.data.forEach(function(data, i) {
            contents += `
            <div class="col-xl-3 col-lg-4 col-md-6 mt-5">
                <div class="card" data-animation="true">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <a class="d-block blur-shadow-image">
                        @if(env('APP_ENV')=="local")
                            <img src="{{asset('/')}}/${data.dokumentasi[0].foto_path}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                        @else
                            <img src="{{asset('/')}}/${data.dokumentasi[0].foto_path}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                            @endif
                            </a>
                        <div class="colored-shadow" style="background-image: url(&quot;https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/products/product-1-min.jpg&quot;);"></div>
                    </div>
                    <div class="card-body text-center">
                        <div class="d-flex mt-n6 mx-auto">
                            <a onclick="remove(event)" data-id="${data.id}"" class="btn btn-link text-primary ms-auto border-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="hapus">
                                <i data-id="${data.id}" class="material-icons text-lg">delete</i>
                            </a>
                            <button data-id="${data.id}" onclick="detail(event)" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-link text-info me-auto border-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lihat atau Edit">
                                <i data-id="${data.id}" class="material-icons text-lg">edit</i>
                            </button>
                        </div>
               
                        <p class="text-md text-dark text-start mb-0">
                        <b><a href="#" data-id="${data.id}" onclick="detail(event)" data-bs-toggle="modal" data-bs-target="#exampleModal">${data.tgl_lkh}</a></b>
                       <br>
                            ${data.kegiatan}
                            
                        </p>
                    </div>
                </div>
            </div>`
        });


        document.querySelector('#contents').innerHTML = contents
        displayPagination(response);
    }

    // Function untuk membuat elemen pagination link
    function createPaginationLink(page, active) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        const link = document.createElement('a');
        link.href = '#';
        link.textContent = page;
        link.classList.add('page-link');

        if (active) {
            li.classList.add('active');
        }
        link.addEventListener('click', () => showData(page));
        // console.log(link);
        li.appendChild(link)
        return li;
    }

    // Function untuk menampilkan pagination links ke halaman
    function displayPagination(pagination) {
        // return console.log('sakdfjkahs');
        const paginationDiv = document.getElementById('pagination');
        paginationDiv.innerHTML = ''; // Kosongkan konten sebelumnya
        console.log(pagination);
        for (let i = 1; i <= pagination.last_page; i++) {
            const link = createPaginationLink(i, i === pagination.current_page);
            paginationDiv.appendChild(link);
        }
    }


    async function remove(e) {
        // alert(e.target.parentNode.parentNode.dataset.id)
        // let confirm = 
        if (confirm('yakin hapus data?')) {
            let url = "{{route('lkh.delete',':id')}}"
            url = url.replace(':id', e.target.dataset.id)
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