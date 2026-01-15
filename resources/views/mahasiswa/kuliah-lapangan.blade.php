@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card mt-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Nama {{session('fakultasData')->singkatan}}</th>
                            <th scope="col">Pendaftaran</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $item)
                        <tr>
                            <td class="text-center">{{$index + 1}}</td>
                            <td>{{$item->kuliahLapangan->kuliah_lapangan_nama}} - {{$item->kuliahLapangan->tahunAkademik->sebutan}}</td>
                            <td>
                                Pendaftaran<br>
                                <b>{{$item->kuliahLapangan->waktu_daftar_mulai}} - {{$item->kuliahLapangan->waktu_daftar_selesai}}</b><br>
                                Pelaksanaan<br>
                                <b>{{$item->kuliahLapangan->waktu_pelaksanaan_mulai}} - {{$item->kuliahLapangan->waktu_pelaksanaan_selesai}}</b>
                            </td>
                            <td><span class="badge bg-gradient-{{$item->kuliahLapangan->label}}">{{$item->kuliahLapangan->is_finished}}</span></td>
                            <td>
                                <a data-id="{{$item->kuliahLapangan->id}}" href="{{$item->link}}" class="btn btn-sm btn-{{$item->status_label}}" id="test">{{$item->status_daftar}}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    // document.querySelector('#test').addEventListener('click', async (e) => {
    //     alert('ggwp')
    //     // e.preventDefault()
    //     // getSyarat()
    //     cekSyarat(e.target.dataset.id)
    // })

    // async function getSyarat(pplId) {
    //     let url = "{{route('syarat',':pplId')}}"
    //     url = url.replace(':pplId', pplId)
    //     const send = await fetch(url)
    //     const response = await send.json()
    //     console.log(response)
    //     return response.data
    // }

    // async function cekSyarat(pplId) {
    //     let url = "https://sia.iainkendari.ac.id/konseling_api/cek_prodi";
    //     let dataSend = new FormData()
    //     let idprodi = []
    //     let list = await getSyarat(pplId);
    //     list.syarat_prodi.forEach(function(data) {
    //         idprodi.push(data.prodi_id);
    //     });
    //     console.log(idprodi);
    //     dataSend.append('iddata', '{{session("data")}}')
    //     dataSend.append('idprodi', JSON.stringify(idprodi))

    //     let send = await fetch(url, {
    //         method: "POST",
    //         body: dataSend
    //     })
    //     let response = await send.json()
    //     console.log(response);
    // }
</script>
@endsection