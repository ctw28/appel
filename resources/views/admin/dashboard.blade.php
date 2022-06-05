<h1>{{$title}}</h1>
<h2>Selamat Datang, {{Auth::user()->role->keterangan}}</h2>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
<button type="submit">Logout</button>
</form>