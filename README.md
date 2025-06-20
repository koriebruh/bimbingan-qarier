### Installation Steps

```bash
git clone https://github.com/koriebruh/bimbingan-qarier.git
cd bimbingan-qarier

composer install
cp .env.example .env
php artisan key:generate

# (Edit .env untuk setting database)

php artisan migrate --seed
npm install && npm run dev 

php artisan serve
```

Akses: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📋 Source Code Shortcuts for View (Blade) `xixixix`

Catatan pribadi untuk potongan (snippet) Blade Laravel.

---

### 🔁 `@foreach` untuk Menampilkan Data Tabel

```blade
@foreach($obats as $index => $obat)
    <tr>
        <td class="border border-gray-400 px-4 py-2">{{ $index + 1 }}</td>
        <td class="border border-gray-400 px-4 py-2">{{ $obat->nama }}</td>
        <td class="border border-gray-400 px-4 py-2">{{ $obat->deskripsi }}</td>
        <td class="border border-gray-400 px-4 py-2">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
    </tr>
@endforeach
```

---

### 📝 Form Input (Create Data)

```blade
<form action="{{ route('obat.store') }}" method="POST">
    @csrf <!-- Token untuk keamanan form -->
    <input type="text" name="nama" placeholder="Nama Obat" required>
    <input type="text" name="deskripsi" placeholder="Deskripsi" required>
    <input type="number" name="harga" placeholder="Harga" required>
    <button type="submit">Simpan</button>
</form>
```

---

### ✏️ Form Edit (Update Data)

```blade
<form action="{{ route('obat.update', $obat->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Method spoofing untuk PUT request -->
    <input type="text" name="nama" value="{{ $obat->nama }}" required>
    <input type="text" name="deskripsi" value="{{ $obat->deskripsi }}" required>
    <input type="number" name="harga" value="{{ $obat->harga }}" required>
    <button type="submit">Update</button>
</form>
```

---

### 🗑️ Tombol Delete (Hapus Data)

```blade
<form action="{{ route('obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
    @csrf
    @method('DELETE') <!-- Method spoofing untuk DELETE request -->
    <button type="submit">Hapus</button>
</form>
```

---

Berikut adalah tambahan untuk bagian **Validation Error Handling** di file Blade kamu, supaya catatan shortcut-mu makin lengkap:

---

### ⚠️ Validation Error Handling (Menampilkan Pesan Validasi)

```blade
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <strong>Ups! Ada masalah dengan inputan Anda:</strong>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

Letakkan kode ini di bagian atas form (create/edit), agar pesan error muncul ketika validasi gagal.

---

### 📌 Contoh Implementasi di Form Input

```blade
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <strong>Ups! Ada masalah dengan inputan Anda:</strong>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('obat.store') }}" method="POST">
    @csrf
    <input type="text" name="nama" placeholder="Nama Obat" value="{{ old('nama') }}" required>
    <input type="text" name="deskripsi" placeholder="Deskripsi" value="{{ old('deskripsi') }}" required>
    <input type="number" name="harga" placeholder="Harga" value="{{ old('harga') }}" required>
    <button type="submit">Simpan</button>
</form>
```

---

