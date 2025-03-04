@extends('template')

@section('css')
<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>
@endsection
@section('content')
<div class="container-fluid ">

    <div class="card card-body">
        <div class="row">
            <div class="row">
                <div class="col-12 col-xl-7 col-md-7">
                    <div class="card card-plain">
                        <div class="card-header pb-0 p-3">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">Pilih PLP / PPL yang diikuti</h6>
                            </div>
                            <select id="pilih">
                                <option value="">Pilih</option>
                            </select>
                            <br>
                            <button class="btn btn-dark btn-sm mt-2" onclick="lihatLaporan()">Pelaporan</button>
                        </div>
                    </div>
                </div>
                <div id="show-laporan" style="display: none">
                    <div class=" row">
                        <div class="col-12">
                            <div class="card card-plain">
                                <div class="card-header pb-0 p-3">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Laporan Akhir dan Bukti Penyerahan</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <table class="table table-striped">
                                    <thead>
                                        <th>NO</th>
                                        <th>Jenis</th>
                                        <th>Unggah</th>
                                        <th>status</th>
                                        <th>Lihat File</th>
                                    </thead>
                                    <div class="tbody">
                                        <tr>
                                            <td>1</td>
                                            <td>Laporan Akhir</td>
                                            <td>
                                                <span class="btn btn-info btn-file">
                                                    <span id="text_laporan_akhir_file">Unggah Laporan Akhir</span>
                                                    <input type="file" name="laporan_akhir_file" id="laporan_akhir_file" onchange="uploadFile(event,'laporan_akhir','create')" required>
                                                </span>
                                                <br>
                                                <small>dalam bentuk pdf</small>
                                            </td>
                                            <td id="status-laporan"><span class="badge badge bg-gradient-danger">Belum Unggah</span></td>
                                            <td id="file-laporan">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Bukti Penyerahan Laporan Akhir</td>
                                            <td>
                                                <span class="btn btn-info btn-file">
                                                    <span id="text_laporan_sekolah_file">Unggah Foto Penyerahan Laporan</span>
                                                    <input type="file" name="laporan_sekolah_file" id="laporan_sekolah_file" onchange="uploadFile(event,'laporan_sekolah','create')" required>
                                                </span>
                                                <br>
                                                <small>dalam bentuk pdf / jpg</small>

                                            </td>
                                            <td id="status-bukti">
                                                <span class="badge badge bg-gradient-danger">Belum Unggah</span>
                                            </td>
                                            <td id="file-bukti">
                                                -
                                            </td>
                                        </tr>
                                    </div>
                                </table>

                                <!-- <span class="btn btn-primary btn-file">
                                    <span id="text_laporan_akhir_file">Unggah Laporan Akhir (.pdf)</span>
                                </span>
                                <div id="show-laporan">
                                    <h5>Anda Belum Upload Laporan Akhir</h5>
                                </div>
                            </div> -->
                            </div>
                            <!-- <div class="col-12 col-xl-5 col-md-5">
                            <div class="card card-plain">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0">Bukti Penyerahan Laporan (.jpg)</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <span class="btn btn-info btn-file">
                                        <span id="text_laporan_sekolah_file">Unggah Foto Penyerahan Laporan</span>
                                        
                                    </span>
                                    <div id="show-laporan-sekolah">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @section('script')
    <script>
        @if(env('APP_ENV') == "local")
        const base_url = 'http://127.0.0.1:8000'
        @else
        const base_url = 'https://appel.iainkendari.ac.id'
        @endif
        const showLaporan = document.querySelector('#show-laporan')
        const showLaporanSekolah = document.querySelector('#show-laporan-sekolah')
        const buttonUploadLaporanAkhir = document.querySelector('#text_laporan_akhir_file')
        const buttonUploadLaporanAkhirSekolah = document.querySelector('#text_laporan_sekolah_file')
        let file_delete_if_update = '';
        let file_sekolah_delete_if_update = '';
        showKuliahLapangan();
        async function showKuliahLapangan() {
            let url = "{{route('kuliah.lapangan.diikuti')}}"
            let formData = new FormData();

            formData.append("mahasiswa_id", '{{$mahasiswa_id}}');
            let response = await fetch(url, {
                method: "POST",
                body: formData
            });
            let responseMessage = await response.json();
            console.log(responseMessage)
            let listKuliahLapangan = document.querySelector('#pilih')
            let contents = ''
            contents += `
        <option value="">Pilih PLP / PPL yang diikuti</option>
        `
            responseMessage.map(data => {
                if (data.anggota != null)
                    contents += `<option value="${data.anggota.id}">${data.kuliah_lapangan.kuliah_lapangan_nama}</option>`
                else
                    contents += `<option value="belum">${data.kuliah_lapangan.kuliah_lapangan_nama}</option>`
            })
            listKuliahLapangan.innerHTML = contents

        }
        async function lihatLaporan() {
            let plp = document.querySelector('#pilih')
            let showLaporan = document.querySelector('#show-laporan')
            showLaporan.setAttribute('style', 'display:none')
            // return alert(plp)
            if (plp.value == "")
                return alert('Pilih PLP/PPL dulu')
            if (plp.value == "belum")
                return alert(`kelompokmu di ${plp.options[plp.selectedIndex].text} belum ditentukan / belum ada`)
            showLaporan.setAttribute('style', 'display:block')
            let url = "{{route('get.laporan',':id')}}"
            url = url.replace(':id', plp.value)
            let response = await fetch(url);
            let responseMessage = await response.json();
            console.log(responseMessage)
            // let link 
            if (responseMessage.laporanAkhir.length > 0) {
                document.querySelector('#status-laporan').innerHTML = `<span class="badge bg-gradient-success">Sudah Unggah</span>`
                // document.querySelector('#file-laporan').innerHTML = `<a class="btn btn-info btn-sm" href="/${responseMessage.laporanAkhir[0].file_path}" target="_blank">Lihat File</a>`
                document.querySelector('#file-laporan').innerHTML = `<a class="btn btn-info btn-sm" href="${base_url}/${responseMessage.laporanAkhir[0].file_path}" target="_blank">Lihat File</a>`
                document.querySelector('#laporan_akhir_file').setAttribute('onchange', "uploadFile(event, 'laporan_akhir', 'update')")
                file_delete_if_update = responseMessage.laporanAkhir[0].file_path;

                buttonUploadLaporanAkhir.innerText = 'Upload Ulang laporan Akhir (.pdf)'
                buttonUploadLaporanAkhir.parentNode.classList.remove('btn-primary')
                buttonUploadLaporanAkhir.parentNode.classList.add('btn-warning')
            }
            if (responseMessage.laporanSekolah.length > 0) {
                file_delete_if_update = responseMessage.laporanSekolah[0].file_path
                document.querySelector('#status-bukti').innerHTML = `<span class="badge bg-gradient-success">Sudah Unggah</span>`
                // document.querySelector('#file-bukti').innerHTML = `<a class="btn btn-info btn-sm" href="https://appel.iainkendari.ac.id/${responseMessage.laporanSekolah[0].file_path}" target="_blank">Lihat File</a>`
                document.querySelector('#file-bukti').innerHTML = `<a class="btn btn-info btn-sm" href="${base_url}/${responseMessage.laporanSekolah[0].file_path}" target="_blank">Lihat File</a>`
                document.querySelector('#laporan_sekolah_file').setAttribute('onchange', "uploadFile(event, 'laporan_sekolah', 'update')")
                buttonUploadLaporanAkhirSekolah.innerText = 'Upload Ulang Bukti Setor (.jpg / .pdf)'
                buttonUploadLaporanAkhirSekolah.parentNode.classList.remove('btn-primary')
                buttonUploadLaporanAkhirSekolah.parentNode.classList.add('btn-warning')

            }
        }
        // init()

        function init() {
            @if(count($laporanAkhir) != 0)
            @if($laporanAkhir != [])
            file_delete_if_update = "{{$laporanAkhir[0]->file_path}}";
            console.log(file_delete_if_update);
            document.querySelector('#laporan_akhir_file').setAttribute('onchange', "uploadFile(event, 'laporan_akhir', 'update')")
            const embed = document.createElement('embed');
            embed.setAttribute('width', '100%')
            embed.setAttribute('height', '700')
            embed.setAttribute('frameborder', '0')
            embed.setAttribute('allowfullscreen', 'allowfullscreen')
            @if(env('APP_ENV') == "local")
            embed.setAttribute("src", "{{asset('/')}}{{$laporanAkhir[0]->file_path}}")
            @else
            embed.setAttribute("src", "{{asset('/')}}{{$laporanAkhir[0]->file_path}}")
            @endif
            buttonUploadLaporanAkhir.innerText = 'Upload Ulang laporan Akhir (.pdf)'
            buttonUploadLaporanAkhir.parentNode.classList.remove('btn-primary')
            buttonUploadLaporanAkhir.parentNode.classList.add('btn-warning')
            // buttonUploadLaporanAkhir.className('btn-warning')
            showLaporan.innerHTML = ''
            showLaporan.appendChild(embed)
            @endif
            @endif

            @if(count($laporanSekolah) != 0)
            @if($laporanSekolah != [])
            const img = document.createElement('img');
            img.setAttribute('width', '100%')
            img.setAttribute("src", "{{asset('/')}}{{$laporanSekolah[0]->file_path}}")

            file_sekolah_delete_if_update = "{{$laporanSekolah[0]->file_path}}";
            // console.log(file_delete_if_update);
            document.querySelector('#laporan_sekolah_file').setAttribute('onchange', "uploadFile(event, 'laporan_sekolah', 'update')")
            buttonUploadLaporanAkhirSekolah.innerText = 'Upload Ulang laporan Akhir (.pdf)'
            buttonUploadLaporanAkhirSekolah.parentNode.classList.remove('btn-primary')
            buttonUploadLaporanAkhirSekolah.parentNode.classList.add('btn-warning')

            showLaporanSekolah.innerHTML = ''
            showLaporanSekolah.appendChild(img)
            @endif
            @endif

        }
        var uploadFile = async function(event, kategori, status) {
            //ini untuk animasi loading

            // return console.log(event.target.files[0]);
            //  event.target.files[0]
            let targetId = `text_${event.target.id}`

            let button = document.querySelector("[id=" + CSS.escape(targetId) + "]")
            button.innerHTML = '<i class="fa fa-circle-o-notch fa-spin"></i> ... Mohon Tunggu'
            // sampai sini animasi loading

            let anggotaId = document.querySelector('#pilih').value;
            // return console.log(anggotaId);
            let formData = new FormData();

            formData.append("kelompok_anggota_id", anggotaId);
            formData.append("kategori", kategori);
            formData.append("status", status);
            formData.append("file_path", event.target.files[0]);
            if (status == "update" && kategori == 'laporan_akhir') {
                formData.append("file_delete_if_update", file_delete_if_update);
            }
            if (status == "update" && kategori == 'laporan_sekolah') {
                formData.append("file_delete_if_update", file_sekolah_delete_if_update);
            }
            let url = "{{route('laporan.store')}}"
            let response = await fetch(url, {
                method: "POST",
                body: formData
            });
            let responseMessage = await response.json();
            console.log(responseMessage)
            // return console.log(responseMessage)
            if (kategori == "laporan_akhir") {

                if (responseMessage.status == true) {
                    button.innerHTML = `Upload Ulang laporan Akhir (.pdf)` //setelah selesai loading ganti animasi loading dengan tulisan unggah file kembali
                    document.querySelector('#laporan_akhir_file').setAttribute('onchange', "uploadFile(event, 'laporan_akhir', 'update')")
                    file_delete_if_update = responseMessage.data.file_path
                    buttonUploadLaporanAkhir.innerText = 'Upload Ulang laporan Akhir (.pdf)'
                    buttonUploadLaporanAkhir.parentNode.classList.remove('btn-primary')
                    buttonUploadLaporanAkhir.parentNode.classList.add('btn-warning')
                    document.querySelector('#status-laporan').innerHTML = `<span class="badge bg-gradient-success">Sudah Unggah</span>`
                    // document.querySelector('#file-laporan').innerHTML = `<a class="btn btn-info btn-sm" href="https://appel.iainkendari.ac.id/${responseMessage.data.file_path}" target="_blank">Lihat File</a>`
                    document.querySelector('#file-laporan').innerHTML = `<a class="btn btn-info btn-sm" href="${base_url}/${responseMessage.data.file_path}" target="_blank">Lihat File</a>`
                    alert(responseMessage.message);
                } else {
                    button.innerHTML = `Unggah Laporan Akhir` //setelah selesai loading ganti animasi loading dengan tulisan unggah file kembali
                    alert(responseMessage.message)
                }
            } else { //ini untuk bukti setor laporan akhir ke sekolahsekolah

                if (responseMessage.status == true) {
                    button.innerHTML = `Upload Ulang Bukti Setor (.jpg / .pdf)` //setelah selesai loading ganti animasi loading dengan tulisan unggah file kembali
                    document.querySelector('#laporan_sekolah_file').setAttribute('onchange', "uploadFile(event, 'laporan_sekolah', 'update')")
                    file_sekolah_delete_if_update = responseMessage.data.file_path
                    buttonUploadLaporanAkhirSekolah.innerText = 'Upload Ulang Bukti Setor Laporan (.jpg / .pdf)'
                    buttonUploadLaporanAkhirSekolah.parentNode.classList.remove('btn-info')
                    buttonUploadLaporanAkhirSekolah.parentNode.classList.add('btn-warning')
                    document.querySelector('#status-bukti').innerHTML = `<span class="badge bg-gradient-success">Sudah Unggah</span>`
                    // document.querySelector('#file-bukti').innerHTML = `<a class="btn btn-info btn-sm" href="https://appel.iainkendari.ac.id/${responseMessage.data.file_path}" target="_blank">Lihat File</a>`
                    document.querySelector('#file-bukti').innerHTML = `<a class="btn btn-info btn-sm" href="${base_url}/${responseMessage.data.file_path}" target="_blank">Lihat File</a>`
                    alert(responseMessage.message);
                } else {
                    button.innerHTML = `Unggah Foto Penyerahan Laporan` //setelah selesai loading ganti animasi loading dengan tulisan unggah file kembali
                    alert(responseMessage.message)
                }
            }

            // button.disabled = false
        }
    </script>
    @endsection