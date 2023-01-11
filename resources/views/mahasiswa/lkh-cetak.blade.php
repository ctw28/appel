@foreach($data->anggota->lkh as $lkh)
<p><b>{{$lkh->tgl_lkh}}</b></p>
<p>{{$lkh->kegiatan}}</p>
@foreach($lkh->dokumentasi as $dokumentasi)
<img src="{{asset('/storage/app/')}}/{{$dokumentasi->foto_path}}" alt="dokumentasi" class="img-fluid" width="200px">
@endforeach
<hr>
@endforeach