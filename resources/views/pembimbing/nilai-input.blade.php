@extends('template')

@section('content')

<div class="card bg-gradient-dark mb-4 mt-4 mt-lg-0">
    <div class="card-body p-3">
        <div class="row">
            <div class="col-8 my-auto">
                <div class="numbers">
                    <p class="text-white text-sm mb-0 text-capitalize font-weight-bold opacity-7">
                        {{$data->lokasi->kuliahLapangan->kuliah_lapangan_nama}}
                        ({{$data->lokasi->kuliahLapangan->tahunAkademik->sebutan}})
                    </p>
                    <h5 class="text-white font-weight-bolder my-1">
                        {{$data->lokasi->lokasi}} - <span class="text-small">{{$data->lokasi->alamat}}</span>
                    </h5>
                    <h5 class="font-weight-bolder mb-0" style="color:yellow">
                        {{$data->nama_kelompok}}
                    </h5>
                </div>
            </div>
            <!-- <div class="col-4 text-end">
                <img class="w-50" src="../../assets/img/small-logos/icon-sun-cloud.png" alt="image sun">
                <h5 class="mb-0 text-white text-end me-1">Cloudy</h5>
            </div> -->
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="row">

        <div class="card my-1">
            <div class="card-body pb-2">
                <form action="{{route('pembimbing.nilai.store',$data->id)}}" method="POST">
                    @csrf
                    <div class="table-responsive mb-3">
                        <table class="table table-hover">
                            <thead class="bg-gradient-secondary text-white">
                                <tr>
                                    <th scope="col" rowspan="2" class="text-center" style="vertical-align: middle">No</th>
                                    <th scope="col" rowspan="2" style="vertical-align: middle">Sinkron SIA</th>
                                    <th scope="col" rowspan="2" style="vertical-align: middle">NIM / Nama</th>
                                    <th scope="col" rowspan="2" style="vertical-align: middle">Prodi</th>
                                    <!-- <th scope="col" rowspan="2" style="vertical-align: middle">KRS</th> -->
                                    <th scope="col" colspan="5" style="border-bottom-width: 0" class="text-center">Nilai</th>
                                    <!-- <th scope="col" rowspan="2" style="vertical-align: middle">Keterangan</th> -->
                                </tr>
                                <tr>
                                    <th class="text-center">Pembimbing</th>
                                    <th class="text-center">Eksternal</th>
                                    <th class="text-center">Nilai Akhir</th>
                                    <!-- <th class="text-center">Angka</th> -->
                                    <!-- <th class="text-center">Huruf</th> -->
                                </tr>
                                <!-- <tr>
                                <th colspan="5">Pamong</th>
                            </tr> -->
                            </thead>
                            <tbody class="mt-2">
                                @foreach($data->anggota as $index => $item)
                                <tr>
                                    <td class=" text-center" style="padding:20px;">{{$index + 1}}</td>
                                    <!-- <td class=" text-center" style="padding:20px;">{{$data->id}}</td> -->
                                    @if($item->pendaftar->id_krs_sia!=null)
                                    <td style="padding:20px;">
                                        <button type="button" class="btn btn-dark btn-sm"
                                            data-krs="{{$item->pendaftar->id_krs_sia}}"
                                            data-nilai="{{$item->nilai->total_nilai}}"
                                            data-huruf="{{$item->nilai->nilai_huruf}}"
                                            data-id="{{$item->pendaftar->id}}"
                                            onclick="sinkron(this)"><i class="material-icons opacity-10" style="font-size:14px">sync</i> Sinkron ke SIA</button>
                                        @if($item->pendaftar->is_sinkron_sia == 1)
                                        <br><small>Status Sinkron : <span id="sinkron_status"><span class="badge bg-gradient-success">Sukses</span></span></small>
                                        @else
                                        <br>Status Sinkron : <small><span id="sinkron_status"><span class="badge bg-gradient-danger">Belum Sinkron</span></span></small>
                                        @endif
                                    </td>
                                    @else
                                    <td style="padding:20px;">Belum ada KRS</td>
                                    @endif
                                    <td style="padding:20px;">{{$item->pendaftar->mahasiswa->nim}} - {{$item->pendaftar->mahasiswa->dataDiri->nama_lengkap}}</td>
                                    <td style="padding:20px;">{{$item->pendaftar->mahasiswa->prodi->prodi_nama}} ({{$item->pendaftar->mahasiswa->prodi->prodi_kode}})</td>
                                    <!-- <td style="padding:20px;">{{$item->pendaftar->id_krs_sia}}</td> -->
                                    @if($item->nilai!=null)
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group input-group-outline" style="width:60px">
                                                <input type="text" class="form-control" name="nilai[{{$item->id}}]" value="{{$item->nilai->nilai_pembimbing}}">
                                            </div>
                                        </div>
                                    </td>
                                    @else
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group input-group-outline" style="width:60px">
                                                <input type="text" class="form-control" name="nilai[{{$item->id}}]" value="0">
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    @if($item->nilai!=null)
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group input-group-outline" style="width:60px">
                                                <input type="text" class="form-control" name="nilai_eksternal[{{$item->id}}]" value="{{$item->nilai->nilai_eksternal}}">
                                            </div>
                                        </div>
                                    </td>
                                    @else
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="input-group input-group-outline" style="width:60px">
                                                <input type="text" class="form-control" name="nilai_eksternal[{{$item->id}}]" value="0">
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    @if($item->nilai!=null)
                                    <td class="text-center" style="padding:20px;"><strong>{{$item->nilai->total_nilai}}</strong></td>
                                    <!-- <td class="text-center" style="padding:20px;">{{$item->nilai->nilai_angka}}</td> -->
                                    <!-- <td class="text-center" style="padding:20px;"><strong>{{$item->nilai->nilai_huruf}}</strong></td> -->
                                    <!-- <td class="text-center" style="padding:20px;"> -->
                                    <!-- <span class="badge bg-gradient-{{$item->nilai->label}}">{{$item->nilai->keterangan}}</span> -->
                                    <!-- </td> -->
                                    @else
                                    <td class="text-center" style="padding:20px;">0</td>
                                    <!-- <td class="text-center" style="padding:20px;">0</td> -->
                                    <!-- <td class="text-center" style="padding:20px;">-</td> -->
                                    <!-- <td class="text-center" style="padding:20px;">-</td> -->
                                    @endif


                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="material-icons opacity-10" style="font-size:14px">send</i> Simpan</button>
                    <!-- <button type="button" onclick="sinkron()" class="btn btn-dark text-end"><i class="material-icons opacity-10" style="font-size:14px">sync</i> Sinkron Ke SIA</button> -->

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    async function sinkron(button) {
        // return alert('sementara maintenance')
        // return console.log(button.parentNode.querySelector('#sinkron_status'));

        // return alert(button.dataset.krs)
        let dataSend = new FormData()
        let url = `https://sia.iainkendari.ac.id/khs/sinkron`
        dataSend.append('prodi', "{{$item->pendaftar->mahasiswa->prodi->prodi_kode}}")
        dataSend.append('idkhs', button.dataset.krs)
        dataSend.append('idkrs', button.dataset.krs)
        dataSend.append('nilaiakhir', button.dataset.nilai)

        let send = await fetch(url, {
            method: "POST",
            body: dataSend
        })
        let response = await send.json()
        console.log(response.data)
        if (response.status) {

            let url2 = "{{route('update.status.khs.sia',':id')}}"
            url2 = url2.replace(':id', button.dataset.id)
            let send2 = await fetch(url2)
            let response2 = await send2.json()
            console.log(response2)
            if (response2.status) {
                button.parentNode.querySelector('#sinkron_status').innerHTML = '<span class="badge bg-gradient-success">Sukses</span>'
                return alert(response.pesan)

            }
        }
        return alert(response.pesan)
        // return alert('ada kesalahan, atau anda belum menawar di SIA, hubungi pembimbing / panitia')
    }
</script>
@endsection