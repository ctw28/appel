@extends('template')

@section('content')

<div class="row">
    <div class="col-md-12 mt-1">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail LKH</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                @foreach ($data as $key => $value)
                <h5>Tanggal : {{$value->tgl_lkh}}</h5>
                <h5>Uraian Kegiatan</h5>
                <p>{{$value->kegiatan}}</p>
                <h5>Dokumentasi</h5>
                @foreach($value->dokumentasi as $dokumentasi)
                <img src="{{asset('/storage/app/')}}/{{$dokumentasi->foto_path}}" alt="dokumentasi" class="img-fluid" width="300px">
                @endforeach
                <hr>
                @endforeach
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


@endsection