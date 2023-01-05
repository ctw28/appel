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
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-text text-white">{{session('error')}}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form action="{{route('mahasiswa.lkh.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline is-filled my-3">
                    <label class="form-label">Tanggal LKH</label>
                    <input type="hidden" name="kuliah_lapangan_id" value="{{$kuliah_lapangan_id}}" required>
                    <input type="hidden" name="anggota_id" value="{{$anggotaID}}" required>
                    <input type="date" name="tgl_lkh" class="form-control" value="{{old('tgl_lkh')}}" required>
                </div>
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Uraian Kegiatan</label>
                    <textarea name="kegiatan" class="form-control" rows="7" cols="50" required>{{old('kegiatan')}}</textarea>
                </div>

                <div class="input-group input-group-outline is-filled my-3">
                    <label class="form-label">Foto / Dokumentasi (ukuran maksimal 500kb, maksimal 4 foto)</label>
                    <input type="file" name="photos[]" class="form-control" multiple required>
                </div>
                <div class="input-group input-group-outline my-3">
                    <label class="form-label">Link Lampiran lainnya (Dokumen, Video, Dll) Jika Ada</label>
                    <input type="text" name="link" class="form-control">
                </div>
                <div class="input-group  input-group-outline is-filled my-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    const textarea = document.querySelector('textarea');
    textarea.addEventListener('input', function(e) {
        // alert('gg')
        // console.log(e.target.parentElement);
        if (e.target.value == "")
            e.target.parentElement.classList.remove("is-filled");
        else
            e.target.parentElement.classList.add("is-filled");

    })
</script>
@endsection