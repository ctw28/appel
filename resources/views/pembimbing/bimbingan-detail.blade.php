@extends('template')

@section('content')
<div class="row">
    <div class="col-md-12 mt-5">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Informasi Kelompok</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                @if(count($data)>0)
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0 ps-0 text-sm">Tahun Akademik : &nbsp; <strong class="text-dark">{{$data[0]->pplLokasi->ppl->tahunAjar->sebutan}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Nama PLP : &nbsp; <strong class="text-dark">{{$data[0]->pplLokasi->ppl->ppl_nama}}</strong></li>
                    @if(count($data[0]->pplKelompokAnggota) > 0)
                    <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">{{$data[0]->pplLokasi->lokasi}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">{{$data[0]->nama_kelompok}}</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark"><span id="nama-pembimbing"></span></strong></li>
                    @else
                    <li class="list-group-item border-0 ps-0 text-sm">Lokasi : &nbsp; <strong class="text-dark">-</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Kelompok : &nbsp; <strong class="text-dark">-</strong></li>
                    <li class="list-group-item border-0 ps-0 text-sm">Pembimbing : &nbsp; <strong class="text-dark">-</strong></li>

                    @endif


                </ul>
                @else
                <p>Anda belum mengikuti PLP</p>
                @endif

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-5">
        <div class="card mb-5 px-3">
            <div class="card-header p-0 position-relative mt-n4 mx-1 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2 mb-3">
                    <h6 class="text-white text-capitalize ps-3">Anggota Kelompok</h6>
                </div>
            </div>
            <div class="card-body p-3 pt-1">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">NIM</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">PRODI</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="list-anggota-kelompok">



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    setDataMahasiswa()

    var namaMahasiswa = document.querySelector('#nama-mahasiswa')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setDataMahasiswa() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/data_siswa/{{session('data')}}");
        let responseMessage = await response.json()
        // console.log(responseMessage);
        namaMahasiswa.innerHTML = responseMessage[0].nama
    }
</script>
@if(count($data)>0 && count($data[0]->pplKelompokAnggota))
<script>
    setDataMahasiswa()

    var namaMahasiswa = document.querySelector('#nama-mahasiswa')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setDataMahasiswa() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/data_siswa/{{session('data')}}");
        let responseMessage = await response.json()
        // console.log(responseMessage);
        namaMahasiswa.innerHTML = responseMessage[0].nama
    }


    setPembimbing()
    var namaPembimbing = document.querySelector('#nama-pembimbing')
    // let dataSend = new FormData()
    // dataSend.append('nim', username)
    async function setPembimbing() {
        let response = await fetch("https://sia.iainkendari.ac.id/konseling_api/get_pegawai/{{$data[0]->pplKelompokAnggota[0]->pplKelompok->pplPembimbing->pplPembimbingInternal->idpeg}}");
        let responseMessage = await response.json()
        // console.log(responseMessage);
        namaPembimbing.innerHTML = `${responseMessage[0].glrdepan} ${responseMessage[0].nama} ${responseMessage[0].glrbelakang} (NIP. ${responseMessage[0].nip})`
    }

    async function getListAnggota(status) {
        let url = "{{route('get.pendaftar',[$data[0]->pplLokasi->ppl->id,$data[0]->id,'sudah'])}}";
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
        console.log(list)
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
        // console.log(responseMessage.length);
        responseMessage.forEach(function(data, i) {
            // console.log(data);
            let tr = document.createElement('tr');
            tr.dataset.id = data.iddata
            if (data.iddata == "{{session()->get('data')}}")
                tr.className = 'text-bold'
            let tdNo = document.createElement('td');
            tdNo.className = 'insert text-center'
            tdNo.innerText = i + 1
            let tdNim = document.createElement('td');
            tdNim.innerText = data.nim
            let tdNama = document.createElement('td');
            tdNama.innerText = data.nama
            let tdProdi = document.createElement('td');
            tdProdi.innerText = `${data.prodi} (${data.idprodi})`
            let tdAksi = document.createElement('td');
            tdAksi.className = 'text-center'
            let aksi = document.createElement('a');
            aksi.className = 'btn btn-info btn-sm'
            aksi.innerText = 'Lihat LKH'
            // aksi.href = `#`
            for (let mhs of list) {
                if (mhs.iddata === data.iddata) {
                    url = "{{route('pembimbing.detail.lkh',[$data[0]->id,':id'])}}"
                    url = url.replace(':id', mhs.ppl_kelompok_anggota[0].id)
                    aksi.href = url
                    break
                }
            }

            tdAksi.appendChild(aksi)
            tr.appendChild(tdNo)
            tr.appendChild(tdNim)
            tr.appendChild(tdNama)
            tr.appendChild(tdProdi)
            tr.appendChild(tdAksi)
            fragment.appendChild(tr);
        });
        listAnggotaContainer.innerHTML = ""
        listAnggotaContainer.appendChild(fragment);
    }
</script>
@endif


@endsection