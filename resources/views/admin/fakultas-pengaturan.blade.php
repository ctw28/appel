@extends('template')
@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                <h6 class="text-white text-capitalize ps-3">Pengaturan Kuliah Lapangan {{$data->fakultas->fakultas_singkatan}}</h6>
            </div>
        </div>
        <div class="card-body pb-2">
            <form action="{{route('admin.pengaturan.fakultas.update')}}" method="post" enctype="multipart/form">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline {{($data->sebutan)?'is-filled':''}} my-3">
                            <label class="form-label" for="sebutan">Sebutan Kuliah Lapangan</label>
                            <input type="text" class="form-control" name="sebutan" id="sebutan" value="{{$data->sebutan}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline {{($data->singkatan)?'is-filled':''}} my-3">
                            <label class="form-label" for="singkatan">Singkatan</label>
                            <input type="text" class="form-control" name="singkatan" id="singkatan" value="{{$data->singkatan}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline {{($data->sebutan_eksternal)?'is-filled':''}} my-3">
                            <label class="form-label" for="sebutan_eksternal">Sebutan Pembimbing Eksternal</label>
                            <input type="text" class="form-control" name="sebutan_eksternal" id="sebutan_eksternal" value="{{$data->sebutan_eksternal}}" required>
                        </div>
                    </div>
                </div>


                <div class="input-group input-group-outline is-filled my-3">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection