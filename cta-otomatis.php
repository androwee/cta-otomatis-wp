<?php
/**
 * Plugin Name:       CTA Otomatis
 * Description:       Menambahkan blok Call-to-Action (CTA) dengan tombol Telepon & WhatsApp secara otomatis di awal, tengah, atau akhir artikel.
 * Version:           1.2.0
 * Author:            andro
 * Author URI:        https://google.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cta-otomatis
 *
 * @package           CTA_Otomatis
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Definisikan konstanta untuk path dan URL plugin agar mudah dikelola
define( 'COA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'COA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Memuat file-file yang dibutuhkan dari folder masing-masing
require_once COA_PLUGIN_PATH . 'admin/admin-settings.php';
require_once COA_PLUGIN_PATH . 'includes/frontend-display.php';

/**
 * Mendaftarkan stylesheet untuk tampilan frontend.
 */
function coa_enqueue_styles() {
    // Hanya daftarkan CSS di halaman single post untuk efisiensi
    if ( is_singular('post') ) {
        wp_enqueue_style(
            'coa-style', // handle
            COA_PLUGIN_URL . 'assets/css/style.css', // path ke file css
            [], // dependencies
            '1.2.0' // version
        );
    }
}
add_action( 'wp_enqueue_scripts', 'coa_enqueue_styles' );

/**
 * Mendaftarkan Font Awesome dari CDN.
 */
function coa_enqueue_fontawesome() {
    // Hanya muat di halaman single post
    if ( is_singular('post') ) {
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', // Link CDN Font Awesome
            [],
            '6.5.2'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'coa_enqueue_fontawesome' );