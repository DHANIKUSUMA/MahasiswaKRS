<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Mata Kuliah</title>
</head>
<body>
    <h1>Katalog Mata Kuliah</h1>

    <h2>Tambah Mata Kuliah</h2>

    <form id="form-mk" novalidate>
        <div>
            <label>Program Studi ID</label>
            <input type="number" id="program_studi_id">
            <small id="error-program_studi_id"></small>
        </div>

        <div>
            <label>Kode Mata Kuliah</label>
            <input type="text" id="kode_mk">
            <small id="error-kode_mk"></small>
        </div>

        <div>
            <label>Nama Mata Kuliah</label>
            <input type="text" id="nama_mk">
            <small id="error-nama_mk"></small>
        </div>

        <div>
            <label>SKS</label>
            <input type="number" id="sks">
            <small id="error-sks"></small>
        </div>

        <div>
            <label>Status</label>
            <select id="status_aktif">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
            <small id="error-status_aktif"></small>
        </div>

        <div>
            <label>Tanggal Dibuka</label>
            <input type="date" id="tanggal_dibuka">
            <small id="error-tanggal_dibuka"></small>
        </div>

        <button type="submit">Simpan</button>
    </form>

    <p id="pesan"></p>

    <hr>

    <h2>Daftar Mata Kuliah</h2>

    <button type="button" id="btn-muat">Muat Ulang Data</button>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>SKS</th>
                <th>Program Studi</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody id="daftar-mk"></tbody>
    </table>

    <script>
        const API = '/api/v1/mata-kuliah';

        // 1. Mengambil data dari API.
        async function muatData() {
            const tabel = document.getElementById('daftar-mk');

            tabel.innerHTML = '<tr><td colspan="5">Memuat data...</td></tr>';

            try {
                const response = await fetch(API, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const hasil = await response.json();

                if (!response.ok) {
                    throw new Error('Gagal mengambil data.');
                }

                tabel.innerHTML = '';

                hasil.data.forEach(mk => {
                    const baris = document.createElement('tr');

                    const nilai = [
                        mk.kode_mk,
                        mk.nama_mk,
                        mk.sks,
                        mk.program_studi?.nama ?? '-',
                        mk.status_aktif ? 'Aktif' : 'Nonaktif'
                    ];

                    nilai.forEach(teks => {
                        const kolom = document.createElement('td');
                        kolom.textContent = teks ?? '';
                        baris.appendChild(kolom);
                    });

                    tabel.appendChild(baris);
                });

                if (hasil.data.length === 0) {
                    tabel.innerHTML =
                        '<tr><td colspan="5">Belum ada data.</td></tr>';
                }
            } catch (error) {
                tabel.innerHTML =
                    '<tr><td colspan="5">Gagal memuat data.</td></tr>';

                document.getElementById('pesan').textContent =
                    error.message;
            }
        }

        // 2. Mengirim data baru ke API.
        document.getElementById('form-mk').addEventListener(
            'submit',
            async function (event) {
                event.preventDefault();

                const pesan = document.getElementById('pesan');
                const form = event.target;

                pesan.textContent = '';

                document.querySelectorAll('small[id^="error-"]')
                    .forEach(el => el.textContent = '');

                const body = {
                    program_studi_id:
                        Number(document.getElementById('program_studi_id').value),

                    kode_mk:
                        document.getElementById('kode_mk').value.trim(),

                    nama_mk:
                        document.getElementById('nama_mk').value.trim(),

                    sks:
                        Number(document.getElementById('sks').value),

                    status_aktif:
                        document.getElementById('status_aktif').value === '1',

                    tanggal_dibuka:
                        document.getElementById('tanggal_dibuka').value || null
                };

                try {
                    const response = await fetch(API, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(body)
                    });

                    const hasil = await response.json();

                    // Jika validasi Laravel gagal.
                    if (response.status === 422) {
                        Object.entries(hasil.errors).forEach(
                            ([field, errors]) => {
                                const elemen = document.getElementById(
                                    'error-' + field
                                );

                                if (elemen) {
                                    elemen.textContent = errors[0];
                                }
                            }
                        );

                        pesan.textContent =
                            'Periksa kembali data yang dimasukkan.';

                        return;
                    }

                    if (!response.ok) {
                        throw new Error(
                            hasil.message || 'Gagal menyimpan data.'
                        );
                    }

                    pesan.textContent = 'Data berhasil ditambahkan.';

                    form.reset();

                    // Muat ulang tabel setelah menyimpan.
                    await muatData();

                } catch (error) {
                    pesan.textContent = error.message;
                }
            }
        );

        // Tombol untuk mengambil data kembali.
        document.getElementById('btn-muat')
            .addEventListener('click', muatData);

        // Ambil data saat halaman pertama kali dibuka.
        muatData();
    </script>
</body>
</html>