<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Menambahkan halaman menu di admin WordPress.
 */
function coa_add_admin_menu() {
    add_menu_page(
        'Pengaturan CTA Otomatis',
        'CTA Otomatis',
        'manage_options',
        'cta_otomatis',
        'coa_options_page_html',
        'dashicons-phone',
        20
    );
}
add_action( 'admin_menu', 'coa_add_admin_menu' );

/**
 * Mendaftarkan skrip dan style untuk halaman admin (khususnya untuk Color Picker).
 */
function coa_admin_enqueue_scripts($hook_suffix) {
    // Hanya muat skrip jika kita berada di halaman pengaturan plugin
    if ( $hook_suffix != 'toplevel_page_cta_otomatis' ) {
        return;
    }
    // Daftarkan WordPress Color Picker
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'coa_admin_enqueue_scripts' );


/**
 * Mendaftarkan pengaturan menggunakan Settings API.
 */
function coa_settings_init() {
    register_setting( 'coa_options_group', 'coa_settings', 'coa_sanitize_options' );

    for ( $i = 1; $i <= 3; $i++ ) {
        add_settings_section(
            "coa_cta_{$i}_section",
            "Pengaturan CTA #{$i}",
            null,
            'cta_otomatis'
        );

        add_settings_field("coa_cta_{$i}_active", "Aktifkan CTA #{$i}", 'coa_render_field', 'cta_otomatis', "coa_cta_{$i}_section", ['type' => 'checkbox', 'id' => "coa_cta_{$i}_active", 'label' => "Ya, aktifkan CTA ini"]);
        add_settings_field("coa_cta_{$i}_heading", 'Judul / Heading CTA', 'coa_render_field', 'cta_otomatis', "coa_cta_{$i}_section", ['type' => 'text', 'id' => "coa_cta_{$i}_heading", 'placeholder' => 'Contoh: Butuh Bantuan? Hubungi Kami!']);
        
        add_settings_field(
            "coa_cta_{$i}_phones",
            'Tombol Aksi (Telepon/WhatsApp)',
            'coa_render_field',
            'cta_otomatis',
            "coa_cta_{$i}_section",
            [
                'type' => 'textarea',
                'id' => "coa_cta_{$i}_phones",
                'placeholder' => "Format: Tipe, Label Tombol, Nomor\n\nContoh:\ntelepon, Hubungi Sales, 081234567890\nwhatsapp, Chat via WhatsApp, 6281234567890",
                'description' => 'Gunakan tipe "telepon" atau "whatsapp". Untuk WhatsApp, gunakan format internasional tanpa tanda + (contoh: 628... bukan 08...).'
            ]
        );
        
        add_settings_field("coa_cta_{$i}_placement", 'Posisi Penempatan', 'coa_render_field', 'cta_otomatis', "coa_cta_{$i}_section", ['type' => 'select', 'id' => "coa_cta_{$i}_placement", 'options' => ['awal' => 'Awal Artikel', 'tengah' => 'Tengah Artikel', 'akhir' => 'Akhir Artikel']]);
        
        add_settings_field("coa_cta_{$i}_bg_color", 'Warna Latar CTA', 'coa_render_field', 'cta_otomatis', "coa_cta_{$i}_section", ['type' => 'color', 'id' => "coa_cta_{$i}_bg_color", 'default' => '#f7f7f7']);
        add_settings_field("coa_cta_{$i}_btn_color", 'Warna Tombol', 'coa_render_field', 'cta_otomatis', "coa_cta_{$i}_section", ['type' => 'color', 'id' => "coa_cta_{$i}_btn_color", 'default' => '#0073aa']);
        add_settings_field("coa_cta_{$i}_btn_text_color", 'Warna Teks Tombol', 'coa_render_field', 'cta_otomatis', "coa_cta_{$i}_section", ['type' => 'color', 'id' => "coa_cta_{$i}_btn_text_color", 'default' => '#ffffff']);
    }
}
add_action( 'admin_init', 'coa_settings_init' );

/**
 * Fungsi serbaguna untuk merender field input.
 */
function coa_render_field( $args ) {
    $options = get_option( 'coa_settings' );
    $id = $args['id'];
    $value = isset($options[$id]) && $options[$id] !== '' ? $options[$id] : ($args['default'] ?? '');

    switch ($args['type']) {
        case 'checkbox':
            $val_cb = isset($options[$id]) ? $options[$id] : '0';
            echo '<label><input type="checkbox" name="coa_settings[' . esc_attr($id) . ']" value="1" ' . checked(1, $val_cb, false) . '> ' . esc_html($args['label']) . '</label>';
            break;
        case 'text':
            echo '<input type="text" name="coa_settings[' . esc_attr($id) . ']" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr($args['placeholder'] ?? '') . '">';
            break;
        case 'textarea':
            echo '<textarea name="coa_settings[' . esc_attr($id) . ']" rows="5" class="large-text" placeholder="' . esc_attr($args['placeholder'] ?? '') . '">' . esc_textarea($value) . '</textarea>';
            if (isset($args['description'])) echo '<p class="description">' . esc_html($args['description']) . '</p>';
            break;
        case 'select':
            echo '<select name="coa_settings[' . esc_attr($id) . ']">';
            foreach ($args['options'] as $key => $label) {
                echo '<option value="' . esc_attr($key) . '" ' . selected($value, $key, false) . '>' . esc_html($label) . '</option>';
            }
            echo '</select>';
            break;
        case 'color':
            echo '<input type="text" name="coa_settings[' . esc_attr($id) . ']" value="' . esc_attr($value) . '" class="coa-color-picker" data-default-color="' . esc_attr($args['default'] ?? '') . '">';
            break;
    }
}

/**
 * Fungsi untuk membersihkan (sanitize) input sebelum disimpan.
 */
function coa_sanitize_options( $input ) {
    $sanitized_input = [];
    if ( empty( $input ) ) {
        return $sanitized_input;
    }
    
    $all_keys = [];
    for ($i = 1; $i <= 3; $i++) {
        $all_keys[] = "coa_cta_{$i}_active";
        $all_keys[] = "coa_cta_{$i}_heading";
        $all_keys[] = "coa_cta_{$i}_phones";
        $all_keys[] = "coa_cta_{$i}_placement";
        $all_keys[] = "coa_cta_{$i}_bg_color";
        $all_keys[] = "coa_cta_{$i}_btn_color";
        $all_keys[] = "coa_cta_{$i}_btn_text_color";
    }

    foreach ( $all_keys as $key ) {
        if ( !isset($input[$key]) ) {
            if (substr($key, -6) === 'active') {
                 $sanitized_input[$key] = '0';
            }
            continue;
        }

        $value = $input[$key];

        if ( strpos($key, '_color') !== false ) {
            $sanitized_input[$key] = sanitize_hex_color($value);
        } elseif (substr($key, -6) === 'active') {
            $sanitized_input[$key] = '1';
        } elseif (substr($key, -6) === 'phones') {
            $sanitized_input[$key] = sanitize_textarea_field($value);
        } else {
            $sanitized_input[$key] = sanitize_text_field($value);
        }
    }
    return $sanitized_input;
}

/**
 * Menampilkan HTML untuk halaman pengaturan.
 */
function coa_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <p>Atur blok CTA yang akan ditampilkan otomatis pada setiap artikel Anda, kini dengan tombol Telepon & WhatsApp, ikon, dan pengaturan warna.</p>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'coa_options_group' );
            do_settings_sections( 'cta_otomatis' );
            submit_button( 'Simpan Pengaturan' );
            ?>
        </form>
    </div>
    
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('.coa-color-picker').wpColorPicker();
        });
    </script>
    <?php
}