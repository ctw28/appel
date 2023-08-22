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
                                <h6 class="mb-0">Laporan Akhir</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <span class="btn btn-primary btn-file">
                            <span id="text_laporan_akhir_file">Unggah Laporan Akhir (.pdf)</span>
                            <input type="file" name="laporan_akhir_file" id="laporan_akhir_file" onchange="uploadFile(event,'laporan_akhir','create')" required>
                        </span>
                        <div id="show-laporan">
                            <h5>Anda Belum Upload Laporan Akhir</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-5 col-md-5">
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
                                <input type="file" name="laporan_sekolah_file" id="laporan_sekolah_file" onchange="uploadFile(event,'laporan_sekolah','create')" required>
                            </span>
                            <div id="show-laporan-sekolah">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    const showLaporan = document.querySelector('#show-laporan')
    const showLaporanSekolah = document.querySelector('#show-laporan-sekolah')
    const buttonUploadLaporanAkhir = document.querySelector('#text_laporan_akhir_file')
    const buttonUploadLaporanAkhirSekolah = document.querySelector('#text_laporan_sekolah_file')
    let file_delete_if_update = '';
    let file_sekolah_delete_if_update = '';
    init()

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
        let targetId = `text_${event.target.id}`

        let button = document.querySelector("[id=" + CSS.escape(targetId) + "]")
        button.innerHTML = '<i class="fa fa-circle-o-notch fa-spin"></i> Mohon Tunggu'
        //sampai sini animasi loading

        let anggotaId = "{{$data[0]->id}}";
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
        // if (kategori == 'laporan_sekolah') {
        //     const fileInput = document.getElementById('laporan_sekolah_file');
        //     const files = fileInput.files;
        //     formData.append("kelompok_anggota_id", anggotaId);
        //     let foto = []
        //     for (let i = 0; i < files.length; i++) {
        //         // foto = ;
        //         formData.append("file_path[]", files[i]);
        //     }
        // } else {
        // }
        let url = "{{route('laporan.store')}}"
        let response = await fetch(url, {
            method: "POST",
            body: formData
        });
        let responseMessage = await response.json();
        console.log(responseMessage)
        // return console.log(responseMessage)
        if (kategori == "laporan_akhir") {
            button.innerHTML = `Upload Ulang laporan Akhir (.pdf)` //setelah selesai loading ganti animasi loading dengan tulisan unggah file kembali

            if (responseMessage.status == true) {
                // console.log(responseMessage.message)
                // document.querySelector('#show-laporan').src = `${responseMessage.data.file_path}`
                document.querySelector('#laporan_akhir_file').setAttribute('onchange', "uploadFile(event, 'laporan_akhir', 'update')")
                file_delete_if_update = responseMessage.data.file_path
                const embed = document.createElement('embed');
                embed.setAttribute('width', '100%')
                embed.setAttribute('height', '700')
                embed.setAttribute('frameborder', '0')
                embed.setAttribute('allowfullscreen', 'allowfullscreen')
                @if(env('APP_ENV') == "local")
                embed.setAttribute("src", `{{asset('/')}}${responseMessage.data.file_path}`)
                @else
                embed.setAttribute("src", `{{asset('/')}}${responseMessage.data.file_path}`)
                @endif
                buttonUploadLaporanAkhir.innerText = 'Upload Ulang laporan Akhir (.pdf)'
                buttonUploadLaporanAkhir.parentNode.classList.remove('btn-primary')
                buttonUploadLaporanAkhir.parentNode.classList.add('btn-warning')
                // buttonUploadLaporanAkhir.className('btn-warning')
                showLaporan.innerHTML = ''
                showLaporan.appendChild(embed)

                alert(responseMessage.message);
            } else {
                alert(responseMessage.message)
            }
        } else { //ini untuk bukti setor laporan akhir ke sekolahsekolah

            if (responseMessage.status == true) {
                // console.log(responseMessage.message)
                // document.querySelector('#show-laporan').src = `${responseMessage.data.file_path}`
                document.querySelector('#laporan_sekolah_file').setAttribute('onchange', "uploadFile(event, 'laporan_sekolah', 'update')")
                file_sekolah_delete_if_update = responseMessage.data.file_path
                const img = document.createElement('img');
                img.setAttribute('width', '100%')
                img.setAttribute("src", `{{asset('/')}}${responseMessage.data.file_path}`)
                buttonUploadLaporanAkhirSekolah.innerText = 'Upload Ulang Bukti Setor Laporan (.jpg)'
                buttonUploadLaporanAkhirSekolah.parentNode.classList.remove('btn-info')
                buttonUploadLaporanAkhirSekolah.parentNode.classList.add('btn-warning')
                // buttonUploadLaporanAkhirSekolah.className('btn-warning')
                showLaporanSekolah.innerHTML = ''
                showLaporanSekolah.appendChild(img)
                alert(responseMessage.message);
            } else {
                alert(responseMessage.message)
            }
        }

        // button.disabled = false
    }
</script>
@endsection