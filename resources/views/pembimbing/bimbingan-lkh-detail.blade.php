@extends('template')

@section('content')

<div class="row">
    <div class="col-md-12 mt-3">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail LKH</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                @foreach ($data as $key => $value)
                <p><strong class="text-dark">{{$value->tgl_lkh}}</strong></p>
                <p>{{$value->kegiatan}}</p>
                @foreach($value->dokumentasi as $dokumentasi)
                <img src="{{asset('//')}}/{{$dokumentasi->foto_path}}" alt="dokumentasi" class="img-fluid" width="300px">
                @endforeach
                <hr>
                @endforeach
                {{ $data->links('pagination::bootstrap-4') }}
                <!-- {{ $data->currentPage()	 }} -->


            </div>
        </div>
    </div>
</div>
@endsection