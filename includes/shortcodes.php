<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Fungsi untuk shortcode [cta_kustom].
 *
 * Atribut yang didukung:
 * - heading="Teks Judul Anda"
 * - telepon="Label Tombol,Nomor Telepon"
 * - whatsapp="Label Tombol,Nomor WhatsApp"
 * - url="Label Tombol,URL Lengkap"
 * - bg_color="#warna"
 * - btn_color="#warna"
 * - btn_text_color="#warna"
 */
function coa_custom_cta_shortcode( $atts ) {
    // Atur nilai default
    $atts = shortcode_atts(
        [
            'heading'        => '',
            'telepon'        => '',
            'whatsapp'       => '',
            'url'            => '',
            'bg_color'       => '#f7f7f7',
            'btn_color'      => '#0073aa',
            'btn_text_color' => '#ffffff',
        ],
        $atts,
        'cta_kustom'
    );

    if ( empty( $atts['heading'] ) ) {
        return ''; // Jangan tampilkan apa pun jika tidak ada heading
    }

    $container_style = 'background-color: ' . esc_attr( $atts['bg_color'] ) . ';';
    $button_style    = 'background-color: ' . esc_attr( $atts['btn_color'] ) . '; color: ' . esc_attr( $atts['btn_text_color'] ) . ';';

    $cta_html = '<div class="coa-cta-container" style="' . $container_style . '">';
    $cta_html .= '<h3 class="coa-heading">' . esc_html( $atts['heading'] ) . '</h3>';
    $cta_html .= '<div class="coa-buttons">';

    // Proses tombol-tombol
    $buttons = [
        'telepon'  => ['icon' => 'fa-solid fa-phone', 'prefix' => 'tel:'],
        'whatsapp' => ['icon' => 'fa-brands fa-whatsapp', 'prefix' => 'https://wa.me/'],
        'url'      => ['icon' => 'fa-solid fa-link', 'prefix' => ''],
    ];

    foreach ( $buttons as $type => $data ) {
        if ( ! empty( $atts[ $type ] ) ) {
            $parts = explode( ',', trim( $atts[ $type ] ), 2 );
            if ( count( $parts ) === 2 ) {
                $label = trim( $parts[0] );
                $value = trim( $parts[1] );
                $href  = '';

                if ( $type === 'telepon' ) {
                    $href = $data['prefix'] . preg_replace( '/[^0-9+]/', '', $value );
                } elseif ( $type === 'whatsapp' ) {
                    $href = $data['prefix'] . preg_replace( '/\D/', '', $value );
                } else {
                    $href = esc_url( $value );
                }

                $cta_html .= '<a href="' . $href . '" class="coa-button" style="' . $button_style . '" target="_blank" rel="noopener noreferrer">';
                $cta_html .= '<i class="' . $data['icon'] . '"></i> ' . esc_html( $label );
                $cta_html .= '</a>';
            }
        }
    }

    $cta_html .= '</div></div>';

    return $cta_html;
}
add_shortcode( 'cta_kustom', 'coa_custom_cta_shortcode' );