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
                                <h6 class="mb-0">Pilih Filter</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 pb-0">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Pilih PLP</label>
                            <select class="form-control" name="ppl" id="ppl">
                                <option value="">Pilih PLP</option>
                                @foreach($pplData as $ppl)
                                <option value="{{$ppl->id}}">{{$ppl->ppl_nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Pilih Lokasi</label>
                            <select class="form-control" name="lokasi-list" id="lokasi-list">
                            </select>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Pilih Kelompok</label>
                            <select class="form-control" name="kelompok-list" id="kelompok-list">
                            </select>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <a href="#" class="btn btn-primary" id="btn-filter">Atur Peserta</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    var ppl = document.querySelector('#ppl')
    var link = document.querySelector('#btn-filter')

    let optionLokasi = document.querySelector('#lokasi-list')
    let optionKelompok = document.querySelector('#kelompok-list')

    ppl.addEventListener('change', function(e) {
        setOptionLokasi(e.target.value)
        optionLokasi.addEventListener('change', function(e) {
            setOptionKelompok(e.target.value)
        })
    })
    async function setOptionLokasi(pplId) {
        // let dataSend = new FormData()
        // dataSend.append('idpeg', JSON.stringify(await getListPeserta()))
        let url = "{{route('get.lokasi',':pplId')}}"
        url = url.replace(':pplId', pplId)

        let response = await fetch(url)

        let responseMessage = await response.json()
        // let fragment = document.createDocumentFragment();
        optionLokasi.innerHTML = ''
        // console.log(optionPeserta);
        let option = document.createElement('option');
        option.innerText = 'Pilih Lokasi'
        optionLokasi.appendChild(option);
        responseMessage.forEach(data => {
            // console.log(data);
            let option = document.createElement('option');
            option.innerText = `${data.lokasi}`
            option.value = data.id
            optionLokasi.appendChild(option);
        });


        // optionPeserta.append(fragment);
        // link.removeAttribute('disabled')
        // link.setAttribute('href', 'google.com')
    }
    async function setOptionKelompok(lokasiId) {
        // let dataSend = new FormData()
        // dataSend.append('idpeg', JSON.stringify(await getListPeserta()))
        let url = "{{route('get.kelompok',':lokasiId')}}"
        url = url.replace(':lokasiId', lokasiId)

        let response = await fetch(url)

        let responseMessage = await response.json()
        // let fragment = document.createDocumentFragment();
        optionKelompok.innerHTML = ''
        // console.log(optionPeserta);
        let option = document.createElement('option');
        option.innerText = 'Pilih Kelompok'
        optionKelompok.appendChild(option);
        responseMessage.forEach(data => {
            // console.log(data);
            let option = document.createElement('option');
            option.innerText = `${data.nama_kelompok}`
            option.value = data.id
            optionKelompok.appendChild(option);
        });


        // optionPeserta.append(fragment);
        // link.removeAttribute('disabled')
        // link.setAttribute('href', 'google.com')
    }





    link.addEventListener('click', function() {
        // alert(optionLokasi.options[optionLokasi.selectedIndex].value)
        let pplId = ppl.options[ppl.selectedIndex].value
        let lokasiId = optionLokasi.options[optionLokasi.selectedIndex].value;
        let kelompokId = optionKelompok.options[optionKelompok.selectedIndex].value;
        let url = "{{route('admin.ppl.peserta.set',[':pplId',':lokasiId',':kelompokId'])}}"
        url = url.replace(':pplId', pplId)
        url = url.replace(':lokasiId', lokasiId)
        url = url.replace(':kelompokId', kelompokId)
        window.location.href = url
    })
</script>
@endsection