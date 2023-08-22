@extends('template')

@section('content')
<div class="card bg-gradient-secondary mb-4 mt-4 mt-lg-0">
    <div class="card-body p-3">
        <div class="row">
            <div class="col-8 my-auto">
                <div class="numbers">
                    <p class="text-white text-sm mb-0 text-capitalize font-weight-bold opacity-7">{{$data[0]->lokasi->kuliahLapangan->kuliah_lapangan_nama}}
                        ({{$data[0]->lokasi->kuliahLapangan->tahunAkademik->sebutan}})</p>
                    <h5 class="text-white font-weight-bolder my-1">
                        {{$data[0]->lokasi->lokasi}} - <span class="text-small">{{$data[0]->lokasi->alamat}}</span>
                    </h5>
                    <h5 class="font-weight-bolder mb-0" style="color:yellow">
                        {{$data[0]->nama_kelompok}}
                    </h5>
                </div>
            </div>
            <!-- <div class="col-4 text-end">
                <img class="w-50" src="../../assets/img/small-logos/icon-sun-cloud.png" alt="image sun">
                <h5 class="mb-0 text-white text-end me-1">Cloudy</h5>
            </div> -->
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">

        <div class="card">
            <div class="card-header mb-2">
                <div class="row">
                    <div class="col-6 d-flex align-items-center ">
                        <!-- <i class="material-icons opacity-10 text-dark me-2" style="font-size:30px">villa</i> -->
                        <h4 class="mb-0 me-2">
                            Anggota Kelompok
                        </h4>
                    </div>

                </div>
            </div>
            <div class="card-body">
                @if(count($data[0]->anggota)==0)
                <div class="col-12">
                    <h1 class="text-center">Tidak ada anggota kelompok</h1>
                </div>
                @else
                <div class="col-12">
                    <div class="row">
                        @foreach($data[0]->anggota as $index => $item)

                        <div class="col-12 col-xxl-4 col-xl-4 col-md-6 mb-5">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div class="icon icon-lg icon-shape shadow text-center border-radius-xl mt-n4 position-absolute" style="width:100px;height:100px;">
                                        <img src="{{asset('/')}}assets/img/user_icon.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                    </div>
                                    <div class="text-end pt-1">
                                        <p class="text-sm mb-0 text-capitalize">{{$item->pendaftar->mahasiswa->prodi->prodi_nama}} ({{$item->pendaftar->mahasiswa->prodi->prodi_kode}})</p>
                                        <h5 class="mb-0">
                                            {{$item->pendaftar->mahasiswa->dataDiri->nama_lengkap}}
                                        </h5>
                                        <h6 class="mb-0">
                                            NIM : {{$item->pendaftar->mahasiswa->nim}}
                                        </h6>
                                        <a id="kirimwa_{{$item->id}}" href="https://web.whatsapp.com/send?phone={{$item->pendaftar->mahasiswa->dataDiri->no_hp}}" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 16px;color:green"></i> {{$item->pendaftar->mahasiswa->dataDiri->no_hp}}</a>

                                    </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3" style="vertical-align:center">

                                    <a href="{{route('pembimbing.detail.lkh',[$data[0]->id,$item->id])}}" class="btn btn-info btn-sm"><i class="material-icons" style="font-size:16px">post_add</i> LKH</a>
                                    <button data-id="{{$item->id}}" onclick="laporan(event,'laporan_akhir')" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary btn-sm"><i class="material-icons" style="font-size:16px">post_add</i> Laporan Akhir</button>
                                    <button data-id="{{$item->id}}" onclick="laporan(event,'laporan_sekolah')" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success btn-sm"><i class="material-icons" style="font-size:16px">post_add</i> Bukti Setor</button>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Laporan Akhir <span id="nama"></span></h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="show-laporan">

            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
@endsection

@section('script')
@foreach($data[0]->anggota as $index => $item)
<script>
    let kirimwa = document.querySelector('#kirimwa_{{$item->id}}')
    let noHp = "{{$item->pendaftar->mahasiswa->dataDiri->no_hp}}"
    let noHpubah = noHp.replace(/^08/, "628")
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        jenisDevice = 'smartphone'
        kirimwa.href = `https://wa.me/${noHpubah}`
    } else {
        jenisDevice = 'pclaptop'
        kirimwa.href = `https://wa.me/${noHpubah}`
        // kirimwa.href = `https://web.whatsapp.com/send?phone=${noHpubah}`
    }
</script>
<script>
    async function laporan(event, kategori) {
        let url = "{{route('laporan.show',[':id',':kategori'])}}"
        url = url.replace(':id', event.target.dataset.id)
        url = url.replace(':kategori', kategori)
        let send = await fetch(url);
        let response = await send.json()
        console.log(response);
        // alert(event.target.dataset.id)
        console.log();
        const showLaporan = document.querySelector('#show-laporan')
        showLaporan.innerHTML = ''

        if (response.status == true) {
            // showLaporan.innerHTML = '<h2>ada ji</h2>'
            // return
            if (kategori == 'laporan_akhir')
                showLaporan.innerHTML = `<embed src="{{asset('/')}}${response.data.file_path}" width="100%" height="600" frameborder="0" allowfullscreen>`
            else
                showLaporan.innerHTML = `<img src="{{asset('/')}}${response.data.file_path}" width="100%" height="600">`
        } else {
            showLaporan.innerHTML = "<h3 class='text-center'>Laporan belum diupload</h3>"
        }
    }
</script>
@endforeach

@endsection