@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                <h6 class="text-white text-capitalize ps-3">{{$title}}</h6>
            </div>
        </div>
        <div class="card-body pb-2">
            <form action="{{route('admin.ppl-store')}}" method="post" enctype="multipart/form">
                @csrf
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">NIM</label>
                    <input type="text" class="form-control" name="nim" required readonly>
                </div>
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" readonly>
                </div>
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Prodi</label>
                    <input type="text" name="prodi" class="form-control" readonly>
                </div>

                <div class="input-group input-group-outline my-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection