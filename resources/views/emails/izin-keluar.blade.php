<h3 class="text-center font-bold text-lg mb-4">{{ \App\Models\Setting::get('school_name') }}</h3>
            
            <h4 class="text-center font-bold text-lg mb-4">Detil Izin Keluar</h4>
            <table class="w-full">
                <tr><td><strong>Nama</strong></td><td> : </td><td>{{ $izin->user->name }}</td></tr>
                <tr><td><strong>Kelas</strong></td></td><td> : </td><td>{{ $izin->user->kelas }}</td></tr>
                <tr><td><strong>Alasan</strong></td></td><td> : </td><td>{{ $izin->alasan }}</td></tr>
                <tr><td><strong>Waktu</strong></td></td><td> : </td><td>{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i') }}</td></tr>
            </table>
            <p>Anda akan menerima notifikasi saat siswa sudah kembali. Bagi orang tua/wali pastikan anda menerima 
    notifikasi yang menandakan siswa sudah kembali. Pesan ini dikirim secara otomatis oleh sistem</p>

