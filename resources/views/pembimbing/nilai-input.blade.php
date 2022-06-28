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
            <form action="{{route('pembimbing.nilai.store',$data->id)}}" method="POST">
                @csrf
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Prodi</th>
                            <th scope="col">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->pplKelompokAnggota as $index => $item)
                        <tr>
                            <td class="text-center">{{$index + 1}}</td>
                            <td><span id="nim_{{$item->pplPendaftar->iddata}}"></span></td>
                            <td><span id="nama_{{$item->pplPendaftar->iddata}}"></span></td>
                            <td><span id="prodi_{{$item->pplPendaftar->iddata}}"></span></td>
                            @if($item->pplNilai!=null)
                            <td class="input-group input-group-outline"><input type="text" class="form-control" name="nilai[{{$item->id}}]" value="{{$item->pplNilai->nilai}}"></td>
                            @else
                            <td><input type="text" name="nilai[{{$item->id}}]" value="0"></td>
                            @endif
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    async function getListAnggota(status) {
        let url = "{{route('get.pendaftar',[$data->pplLokasi->ppl->id,$data->id,'sudah'])}}";
        let response = await fetch(url);
        let responseMessage = await response.json()
        console.log(responseMessage.data);
        return responseMessage.data
    }
    setAnggotaKelompok()
    const listAnggotaContainer = document.querySelector('#list-anggota-kelompok');
    async function setAnggotaKelompok() {
        let urlListPesertaBukanAnggota = 'https://sia.iainkendari.ac.id/konseling_api/data_mahasiswa'
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        let iddata = []
        let list = await getListAnggota('anggota');
        list.forEach(function(data) {
            iddata.push(data.iddata);
        });
        if (iddata.length != 0)
            dataSend.append('iddata', JSON.stringify(iddata))

        let response = await fetch(urlListPesertaBukanAnggota, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()
        console.log(responseMessage.length);
        responseMessage.forEach(function(data, i) {
            let nim = document.querySelector(`#nim_${data.iddata}`);
            let nama = document.querySelector(`#nama_${data.iddata}`);
            let prodi = document.querySelector(`#prodi_${data.iddata}`);
            // console.log(pegawaiText);
            nim.innerText = data.nim;
            nama.innerText = data.nama;
            prodi.innerText = data.idprodi;
        });
    }
</script>
@endsection