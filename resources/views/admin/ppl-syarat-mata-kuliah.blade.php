@extends('template')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                        <h6 class="mb-0">Info PLP</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Tahun Akademik :</strong> &nbsp; {{$data->ppl->tahunAjar->sebutan}}</li>
                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Nama PLP :</strong> &nbsp; {{$data->ppl->ppl_nama}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
                    <h6 class="text-white text-capitalize ps-3">Pengaturan Syarat Prodi</h6>
                </div>
            </div>
            <div class="card-body pb-2">
                <!-- <div class="input-group input-group-outline my-3">
                    <select class="form-control" id="pilih-kurikulum">
                        <option value="">Pilih Kurikulum</option>
                    </select>
                </div> -->
                <button type="button" class="btn btn-block btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-form">Tambah Mata Kuliah</button>

                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">No</th>
                            <th scope="col">Kurikulum</th>
                            <th scope="col">Kode Mata Kuliah</th>
                            <th scope="col">Nama Mata Kuliah</th>
                            <th scope="col">Status Syarat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->syaratMataKuliah as $index => $mataKuliah)
                        <tr class="text-center">
                            <td>{{$index+1}}</td>
                            <td><span id="kurikulum-{{$mataKuliah->kodemk}}"></span></td>
                            <td>{{$mataKuliah->kodemk}}</td>
                            <td><span id="nama-mata-kuliah-{{$mataKuliah->kodemk}}"></span></td>
                            <td>{{$mataKuliah->status}}</td>
                            <td>

                                <a href="{{route('admin.ppl.syarat.mata.kuliah.delete',$mataKuliah->id)}}" class="btn btn-sm btn-danger"><i class="material-icons opacity-10" style="font-size:16px">delete</i></a>


                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h5 class="">Pengaturan Syarat Mata Kuliah</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.ppl.syarat.mata-kuliah.store')}}" method="POST" role="form text-left">
                            @csrf
                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" id="pilih-kurikulum" required>
                                    <option value="">Pilih Kurikulum</option>
                                </select>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="hidden" name="syarat_prodi_id" value="{{$data->id}}" required>
                                <select class="form-control" name="kodemk" id="mata-kuliah" required>

                                </select>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <!-- <label class="form-label">Pilih Sta /tus Mata Kuliah</label> -->
                                <select class="form-control" name="status" id="status" required>
                                    <option value="">Pilih Status Mata Kuliah</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="penawaran">Tawar</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" value="Tambah Syarat Mata Kuliah"></input>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    // let listAnggota = getProdi()
    // setDataAnggota()
    // getListAnggota()
    var fakultasId = "01"
    async function getProdi() { //ambil data prodi yang sudah ada di tabel syarat
        let url = "{{route('get.prodi',$data->id)}}";
        let send = await fetch(url);
        let response = await send.json()
        // console.log(response.data);
        return response.data
    }
    const listMataKuliah = document.querySelector('#list-mata-kuliah');
    async function setProdi() {

        let url = `https://sia.iainkendari.ac.id/api/listmatakuliah`
        let fragment = document.createDocumentFragment();
        let dataSend = new FormData()
        dataSend.append('idkurikulum', )

        let response = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let responseMessage = await response.json()
        responseMessage.forEach(async function(data, i) {
            // console.log(data);

        });
    }



    pilihKurikulum()
    const selectKurikulum = document.querySelector('#pilih-kurikulum')
    async function pilihKurikulum() {
        // alert(e.target.dataset.id)
        const url = 'https://sia.iainkendari.ac.id/api/listkurikulum';
        let dataSend = new FormData();
        dataSend.append('idprodi', "{{$data->prodi_id}}");
        let send = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let response = await send.json()
        console.log(response);
        if (response.status) {
            const fragment = document.createDocumentFragment()
            response.data.forEach(function(data, i) {
                let option = document.createElement('option')
                option.value = data.idkurikulum
                option.innerText = data.kurikulum
                fragment.appendChild(option)
            })
            selectKurikulum.appendChild(fragment)
        }
    }
    selectKurikulum.addEventListener('change', async function(e) {
        // alert(e.target.value)
        const url = 'https://sia.iainkendari.ac.id/api/listmatakuliah';
        let dataSend = new FormData();
        dataSend.append('idkurikulum', e.target.value);
        let send = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let response = await send.json()
        console.log(response);
        if (response.status) {
            const mataKuliah = document.querySelector('#mata-kuliah')
            const fragment = document.createDocumentFragment()
            response.data.forEach(function(data, i) {
                let option = document.createElement('option')
                option.value = data.kodemk
                option.innerText = `${data.kodemk} - ${data.mtkul}`
                fragment.appendChild(option)
            })
            mataKuliah.innerHTML = ""
            let option = document.createElement('option')
            option.value = ''
            option.innerText = `Pilih Mata Kuliah`
            mataKuliah.appendChild(option)
            mataKuliah.appendChild(fragment)
        }
    })
</script>
@endsection