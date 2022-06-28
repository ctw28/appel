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
            <form action="{{route('admin.ppl.kelompok.store', [$data->id,$data->pplLokasi[0]->id])}}" method="post" enctype="multipart/form">
                @csrf
                <input type="hidden" name="ppl_lokasi_id" value="{{$data->pplLokasi[0]->id}}">
                <div class="input-group input-group-static is-valid my-3">
                    <label>Nama Kelompok</label>
                    <input type="text" class="form-control" name="nama_kelompok" required>
                </div>
                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Pilih Pembimbing</label>
                    <select class="form-control" name="idpeg" id="list-pembimbing" required>
                    </select>
                </div>
                <div class="input-group input-group-static is-valid my-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control"></textarea>
                </div>
                <div class="input-group input-group-outline my-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    async function getListPembimbing(status) {
        let url = "{{route('ppl.pembimbing',$data->id)}}";
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage.data);
        return responseMessage.data
    }
    setPembimbing()

    const listPembimbingContainer = document.querySelector('#list-pembimbing');
    async function setPembimbing() {
        let url = 'https://sia.iainkendari.ac.id/konseling_api/data_konselor'
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let idpeg = []
        let list = await getListPembimbing('anggota');
        list.forEach(function(data) {
            idpeg.push(data.idpeg);
        });
        if (idpeg.length != 0)
            dataSend.append('konselor_pegawai_id', JSON.stringify(idpeg))

        let response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()
        // console.log(responseMessage.length);
        let option = document.createElement('option');
        option.value = ''
        option.innerHTML = `Pilih Pembimbing`;
        fragment.appendChild(option);
        responseMessage.forEach(function(data, i) {
            // console.log(data);
            let option = document.createElement('option');
            option.value = data.idpegawai;
            option.innerHTML = `${data.nip} - ${data.nama}`;
            fragment.appendChild(option);
        });
        listPembimbingContainer.innerHTML = ""
        listPembimbingContainer.appendChild(fragment);
    }
</script>
@endsection