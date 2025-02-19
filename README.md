# IoT Sederhana - Monitoring dan Kontrol via File

## 📌 Deskripsi
Aplikasi ini adalah sistem IoT sederhana yang membaca file `bantu.txt` setiap 5 detik untuk memeriksa status tertentu. Jika angka `1` terdeteksi dalam file tersebut, maka Arduino akan mengaktifkan digital output pada pin 13 selama 3 detik.

## 🛠 Teknologi yang Digunakan
- **Arduino** (C++) untuk membaca file dan mengontrol pin output
- **Python** untuk komunikasi serial dengan Arduino
- **PHP** untuk menangani upload gambar dan menampilkan hasil deteksi
- **Laragon** sebagai server lokal

---

## 🚀 Instalasi dan Konfigurasi
### **1. Instalasi Laragon**
1. Unduh dan instal **Laragon** dari [laragon.org](https://laragon.org/).
2. Simpan proyek di folder `C:\laragon\www\iotsederhana`.

### **2. Instalasi Python dan Pustaka Tambahan**
Pastikan Anda memiliki Python terinstal. Kemudian, install pustaka `pyserial`:
```sh
pip install pyserial
```

### **3. Konfigurasi Arduino**
1. Hubungkan Arduino ke PC.
2. Pastikan port yang digunakan sesuai (`COM3`, `COM4`, dll.).
3. Upload kode Arduino ke board menggunakan Arduino IDE.

---

## 📂 Struktur Folder
```
C:\laragon\www\iotsederhana\
│── index.php         # Halaman utama untuk upload dan menampilkan hasil
│── tes.py            # Skrip Python untuk komunikasi dengan Arduino
│── bantu.txt         # File status yang dibaca oleh Arduino
│── arduino_code.ino  # Kode untuk Arduino
└── uploads/          # Folder penyimpanan gambar
```

---

## 🔥 Cara Menggunakan
### **1. Jalankan Server PHP**
Buka terminal di folder `iotsederhana`, lalu jalankan:
```sh
php -S localhost:8000
```
Atau gunakan Laragon dan pastikan Apache berjalan.

### **2. Jalankan Skrip Python**
Jalankan skrip untuk membaca file `bantu.txt` dan mengirim data ke Arduino:
```sh
python tes.py
```

### **3. Upload Gambar dan Periksa Hasil**
1. Buka browser dan akses `http://localhost:8000/index.php`.
2. Upload gambar.
3. Sistem akan memproses dan menampilkan hasil deteksi.

### **4. Arduino Membaca Status dan Mengontrol Output**
Arduino akan membaca file `bantu.txt` setiap 5 detik dan mengaktifkan pin 13 jika angka `1` ditemukan.

---

## 🛠 Troubleshooting
### **Error "could not open port 'COM3'" di Python**
- Pastikan **Arduino IDE Serial Monitor tidak terbuka**.
- Cek apakah **port yang digunakan benar**.
- Coba restart PC dan Arduino.

### **Error "Access is denied" saat upload ke Arduino**
- Tutup semua aplikasi yang menggunakan **port COM3**.
- Pastikan tidak ada aplikasi lain yang memblokir akses ke Arduino.

---

## 📜 Lisensi
Proyek ini bersifat open-source dan bebas digunakan untuk keperluan belajar.

---

## 📧 Kontak
Jika ada pertanyaan atau saran, silakan hubungi **Johannes Alexander Putra** di [wengdev.tech](https://wengdev.tech/).
