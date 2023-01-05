@extends('template')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h2>Selamat Datang, {{Auth::user()->name}}</h2>

        </div>
    </div>
</div>

@endsection