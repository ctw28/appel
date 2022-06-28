@extends('template')

@section('content')
<div class="col-md-12">

    <div class="card my-4">
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Tahun Ajar</th>
                        <th scope="col">Nama PLP</th>
                        <th scope="col">Pendaftaran</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pplData as $index => $data)
                    <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{$data->tahunAjar->sebutan}}</td>
                        <td>{{$data->ppl_nama}}</td>
                        <td>{{$data->ppl_waktu_daftar_mulai}} - {{$data->ppl_waktu_daftar_selesai}}</td>
                        <td><span class="badge bg-gradient-{{$data->label}}">{{$data->is_finished}}</span></td>
                        <td>
                            <a data-id="{{$data->id}}" href="{{$data->link}}" class="btn btn-sm btn-{{$data->status_label}}" id="test">{{$data->status_daftar}}</a>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    document.querySelector('#test').addEventListener('click', async (e) => {
        alert('ggwp')
        // e.preventDefault()
        // getSyarat()
        cekSyarat(e.target.dataset.id)
    })

    async function getSyarat(pplId) {
        let url = "{{route('syarat',':pplId')}}"
        url = url.replace(':pplId', pplId)
        const send = await fetch(url)
        const response = await send.json()
        console.log(response)
        return response.data
    }

    async function cekSyarat(pplId) {
        let url = "https://sia.iainkendari.ac.id/konseling_api/cek_prodi";
        let dataSend = new FormData()
        let idprodi = []
        let list = await getSyarat(pplId);
        list.syarat_prodi.forEach(function(data) {
            idprodi.push(data.prodi_id);
        });
        console.log(idprodi);
        dataSend.append('iddata', '{{session("data")}}')
        dataSend.append('idprodi', JSON.stringify(idprodi))

        let send = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let response = await send.json()
        console.log(response);
    }
</script>
@endsection