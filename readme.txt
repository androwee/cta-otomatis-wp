=== CTA Otomatis ===
Contributors: (andro)
Tags: cta, call to action, whatsapp, phone, button, automatic cta, content, post, article, custom color, font awesome
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Menambahkan tombol Telepon & WhatsApp dengan ikon, secara otomatis ke dalam artikel WordPress Anda.

== Description ==

Tingkatkan konversi secara dramatis dengan **CTA Otomatis**, solusi lengkap untuk menambahkan tombol Telepon dan WhatsApp di setiap artikel.

Fitur Unggulan:
* **Tombol Telepon & WhatsApp**: Beri pengunjung pilihan untuk menelepon atau langsung chat via WhatsApp.
* **Ikon Otomatis**: Ikon Font Awesome (📞 & 💬) ditambahkan secara otomatis untuk memperjelas fungsi tombol.
* **Kustomisasi Penuh**: Ubah warna latar belakang CTA, warna tombol, dan warna teks tombol.
* **Penempatan Fleksibel**: Tempatkan CTA di awal, tengah, atau akhir artikel.
* **Manajemen Mudah**: Buat hingga 3 blok CTA berbeda dan aktifkan/nonaktifkan sesuai kebutuhan.
* **Tanpa Shortcode**: Cukup atur sekali, dan biarkan plugin bekerja untuk Anda.

== Installation ==

1.  **Cara Termudah (melalui Dashboard WordPress):**
    * Unduh file `.zip` dari plugin ini.
    * Masuk ke Dashboard WordPress Anda, navigasi ke `Plugins > Add New`.
    * Klik `Upload Plugin`, pilih file `.zip` yang sudah Anda unduh, dan klik `Install Now`.
    * Setelah instalasi selesai, klik `Activate`.

2.  **Cara Manual (melalui FTP):**
    * Ekstrak file `.zip`. Anda akan mendapatkan folder `cta-otomatis`.
    * Unggah folder `cta-otomatis` ke direktori `/wp-content/plugins/` di hosting Anda.
    * Masuk ke Dashboard WordPress, navigasi ke menu `Plugins`.
    * Cari "CTA Otomatis" dan klik `Activate`.

Setelah aktivasi, akan muncul menu baru **"CTA Otomatis"** di dashboard Anda untuk mulai melakukan konfigurasi.

== Frequently Asked Questions ==

= Bagaimana cara menambahkan tombol Telepon dan WhatsApp? =

Di halaman pengaturan plugin, pada bagian "Tombol Aksi", gunakan format `Tipe, Label Tombol, Nomor` untuk setiap baris.

**Contoh Input:**
`telepon, Hubungi Kami, 081234567890`
`whatsapp, Chat di WhatsApp, 6281234567890`

* Gunakan tipe `telepon` untuk panggilan biasa.
* Gunakan tipe `whatsapp` untuk chat WhatsApp. Untuk nomor WhatsApp, **sangat disarankan** menggunakan format internasional tanpa `+` atau `0` di depan (misal: `6281...`).

= Apakah saya perlu menginstal Font Awesome secara terpisah? =

Tidak. Plugin ini akan otomatis memuat library Font Awesome dari CDN ketika dibutuhkan, sehingga tidak memberatkan website Anda.

= Bagaimana cara mengubah warna CTA? =

Di halaman pengaturan plugin, Anda akan menemukan opsi pemilih warna untuk "Warna Latar CTA", "Warna Tombol", dan "Warna Teks Tombol" untuk setiap CTA.

== Screenshots ==

1.  Halaman pengaturan plugin yang fleksibel.
2.  Contoh input untuk membuat tombol Telepon dan WhatsApp.
3.  Hasil akhir CTA di artikel dengan ikon dan warna kustom.

== Changelog ==

= 1.2.0 =
* **Fitur Baru**: Menambahkan opsi untuk membuat tombol chat WhatsApp (`https://wa.me/`).
* **Fitur Baru**: Integrasi dengan Font Awesome. Ikon telepon dan WhatsApp kini muncul otomatis di tombol.
* **Peningkatan**: Memperbarui format input tombol menjadi `Tipe, Label, Nomor` untuk mendukung berbagai jenis aksi.
* **Peningkatan**: Memuat Font Awesome secara efisien dari CDN.

= 1.1.0 =
* **Fitur Baru**: Menambahkan opsi kustomisasi warna untuk latar CTA, tombol, dan teks tombol.
* **Peningkatan**: Menggunakan WordPress Color Picker di halaman admin.

= 1.0.1 =
* **Peningkatan**: Memperbaiki struktur folder agar lebih rapi.
* **Penambahan**: Menambahkan file `readme.txt` dan `uninstall.php`.

= 1.0.0 =
* Rilis awal.