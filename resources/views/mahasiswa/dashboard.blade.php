@extends('template')

@section('content')
<div class="col-md-12 mb-5 mt-3">
    <h2>Selamat Datang, <span id="nama-mahasiswa"></span></h2>
</div>

<div class="row">
    <div class="col-md-6 mt-3">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">PLP Diikuti Saat ini</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                @if(count($data)>0)
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0 ps-0 text-sm">Nama PLP : &nbsp; <strong class="text-dark">{{$data[0]->ppl->ppl_nama}}</strong></li>
                    @if(count($data[0]->pplKelompokAnggota) > 0)
                    <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">{{$data[0]->pplKelompokAnggota[0]->pplKelompok->pplLokasi->lokasi}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">{{$data[0]->pplKelompokAnggota[0]->pplKelompok->nama_kelompok}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark"><span id="nama-pembimbing"></span></strong></li>
                    @else
                    <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">-</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">-</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">-</strong></li>

                    @endif


                </ul>
                <div class="text-end">
                    <a href="{{route('mahasiswa.lkh')}}" class="btn btn-primary"><i class="material-icons">post_add</i> Isi LKH</a>
                    @if(count($data[0]->pplKelompokAnggota) > 0)

                    <a href="{{route('mahasiswa.kelompok.detail',$data[0]->pplKelompokAnggota[0]->pplKelompok->id)}}" class="btn btn-success"><i class="material-icons">info</i> Detail Kelompok</a>
                    @else
                    <a href="#" class="btn btn-secondary"><i class="material-icons">info</i> Detail Kelompok</a>
                    @endif
                </div>
                @else
                <p>Anda belum mengikuti PLP</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    setDataMahasiswa()

    var namaMahasiswa = document.querySelector('#nama-mahasiswa')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setDataMahasiswa() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/data_siswa/{{session('data')}}");
        let responseMessage = await response.json()
        console.log(responseMessage);
        namaMahasiswa.innerHTML = responseMessage[0].nama
    }
</script>
@if(count($data)>0 && count($data[0]->pplKelompokAnggota))
<script>
    setDataMahasiswa()

    var namaMahasiswa = document.querySelector('#nama-mahasiswa')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setDataMahasiswa() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/data_siswa/{{session('data')}}");
        let responseMessage = await response.json()
        console.log(responseMessage);
        namaMahasiswa.innerHTML = responseMessage[0].nama
    }


    setPembimbing()
    var namaPembimbing = document.querySelector('#nama-pembimbing')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setPembimbing() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/get_pegawai/{{$data[0]->pplKelompokAnggota[0]->pplKelompok->pplPembimbing->pplPembimbingInternal->idpeg}}");
        let responseMessage = await response.json()
        console.log(responseMessage);
        namaPembimbing.innerHTML = `${responseMessage[0].glrdepan} ${responseMessage[0].nama} ${responseMessage[0].glrbelakang} (NIP. ${responseMessage[0].nip})`
    }
</script>
@endif
@endsection