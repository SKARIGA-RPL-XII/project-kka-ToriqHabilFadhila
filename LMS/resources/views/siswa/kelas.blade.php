
@section('content')
    <h1>Kelas Saya</h1>

    @forelse ($classes as $kelas)
        <div>
            <strong>{{ $kelas->nama_kelas }}</strong>
        </div>
    @empty
        <p>Belum join kelas apa pun.</p>
    @endforelse
@endsection
