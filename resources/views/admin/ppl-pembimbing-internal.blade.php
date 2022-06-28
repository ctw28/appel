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
            <div class="col-12 col-xl-4">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">Info PLP</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group mb-2">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Tahun Ajar:</strong> &nbsp; {{$pplData->tahunAjar->sebutan}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Nama PLP:</strong> &nbsp; {{$pplData->ppl_nama}}</li>
                        </ul>
                        <a href="{{route('admin.ppl.pembimbing-internal.add',$pplData->id)}}" class="btn btn-primary text-right">+ Manage Pembimbing</a>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama Pembimbing</th>
                    </tr>
                </thead>
                <tbody id="list-pembimbing">



                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    // getListPembimbing()
    let listAnggota = getListPembimbing()
    // setDataAnggota()
    // getListAnggota()
    async function getListPembimbing() {
        let url = "{{route('ppl.pembimbing',$pplData->id)}}";
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage.data);
        return responseMessage.data
    }
    // setPembimbing()
    var pembimbingContainer = document.querySelector('#list-pembimbing')
    setListPembimbing()
    const listPendaftarContainer = document.querySelector('#list-pendaftar');
    async function setListPembimbing() {
        let url = 'https://sia.iainkendari.ac.id/konseling_api/data_konselor'
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let idpeg = []
        let list = await getListPembimbing();
        list.forEach(function(data) {
            idpeg.push(data.idpeg);
        });
        if (idpeg.length != 0)
            dataSend.append('konselor_pegawai_id', JSON.stringify(idpeg))
        else
            dataSend.append('konselor_pegawai_id', JSON.stringify([]))

        let response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()
        console.log(responseMessage.length);
        responseMessage.forEach(function(data, i) {
            console.log(data);
            let tr = document.createElement('tr');
            tr.dataset.id = data.iddata
            let tdNo = document.createElement('td');
            tdNo.className = 'text-center'
            tdNo.innerText = i + 1
            let tdNip = document.createElement('td');
            tdNip.innerText = data.nip
            let tdNama = document.createElement('td');
            tdNama.innerText = `${data.glrdepan} ${data.nama} ${data.glrbelakang}`

            tr.appendChild(tdNo)
            tr.appendChild(tdNip)
            tr.appendChild(tdNama)
            fragment.appendChild(tr);
        });
        pembimbingContainer.innerHTML = ""
        pembimbingContainer.appendChild(fragment);
    }
</script>
@endsection