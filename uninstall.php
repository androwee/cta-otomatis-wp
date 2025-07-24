<?php
/**
 * File Uninstall untuk CTA Otomatis
 *
 * Skrip ini dipicu ketika plugin dihapus dari dashboard WordPress.
 * Fungsinya untuk membersihkan data yang disimpan di database.
 *
 * @package           CTA_Otomatis
 */

// Keamanan: Pastikan file ini tidak diakses secara langsung.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Hapus opsi plugin dari tabel wp_options.
// 'coa_settings' adalah nama opsi yang kita daftarkan di admin-settings.php.
delete_option( 'coa_settings' );

// Jika di masa depan Anda menambahkan opsi lain, daftarkan juga di sini.
// delete_option( 'nama_opsi_lain' );