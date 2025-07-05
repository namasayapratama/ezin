@php
    use Carbon\Carbon;

    Carbon::setLocale('id');

    $start = !empty(trim(request('start_date')))
        ? Carbon::parse(request('start_date'))
        : Carbon::now()->startOfMonth();

    $end = !empty(trim(request('end_date')))
        ? Carbon::parse(request('end_date'))
        : Carbon::now()->endOfMonth();
@endphp

<h2>{{ setting('school_name', 'APLIKASI E-IZIN SEKOLAH') }}</h2>
<h3> REKAP IZIN MASUK</h3>
<p>
    Periode: {{ $start->translatedFormat('d F Y') }} s/d {{ $end->translatedFormat('d F Y') }}
</p>
<table border="1" cellspacing="0" cellpadding="5" style="width:100%; font-size:12px;">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Alasan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($izinMasuk as $izin)
            <tr>
                <td>{{ $izin->user->name }}</td>
                <td>{{ $izin->user->kelas }}</td>
                <td>{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i') }}</td>
                <td>{{ $izin->alasan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
