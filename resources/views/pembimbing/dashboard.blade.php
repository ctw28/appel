@extends('template')

@section('content')
<div class="col-md-12 mb-5 mt-3">
    <!-- <h2>Selamat Datang, <span id="nama-pembimbing"></span></h2> -->
</div>

<div class="row">
    <div class="col-md-6 mt-3">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Bimbingan Saat Ini</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                @if(count($data)>0)
                @foreach($data as $item)
                <h5>Nama PLP : &nbsp; <strong class="text-dark">{{$item->ppl->ppl_nama}}</strong></h5>
                @foreach($item->pplPembimbing as $row)
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0 ps-0 text-sm"><i class="material-icons opacity-10">pin_drop</i> <strong class="text-dark">{{$row->pplKelompok->pplLokasi->lokasi}} ({{$row->pplKelompok->pplLokasi->alamat}})</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">{{$row->pplKelompok->nama_kelompok}} ({{$row->pplKelompok->ppl_kelompok_anggota_count}} Peserta)</strong></li>
                </ul>
                <div class="text-end">
                    <a href="{{route('pembimbing.detail.kelompok',$row->pplKelompok->id)}}" class="btn btn-primary">Detail <i class="material-icons">double_arrow</i></a>
                </div>
                @endforeach
                <hr>
                @endforeach
                @else
                <p>Anda tidak memiliki bimbingan PLP</p>
                @endif


            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    setDataPembimbing()

    var namaPembimbing = document.querySelector('#nama-pembimbing')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setDataPembimbing() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/get_pegawai/{{session('data')}}");
        let responseMessage = await response.json()
        console.log(responseMessage);
        namaPembimbing.innerHTML = `${responseMessage[0].glrdepan} ${responseMessage[0].nama} ${responseMessage[0].glrbelakang}`
    }
</script>
@endsection