@extends('template')

@section('content')
<div class="col-md-12 mb-5 mt-3">
    <h2>Selamat Datang, {{Auth::user()->userMahasiswa->mahasiswa->dataDiri->nama_lengkap}}</h2>
</div>

<div class="row">
    <div class="col-md-12 mt-2">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3"> {{session('fakultasData')->singkatan}} yang diikuti</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-0">
                {{$data}}


            </div>
        </div>
    </div>
</div>
@endsection