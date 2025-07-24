<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Menyisipkan CTA ke dalam konten artikel.
 */
function coa_inject_cta( $content ) {
    if ( is_singular( 'post' ) && in_the_loop() && is_main_query() ) {
        
        $options = get_option( 'coa_settings' );
        if ( empty( $options ) ) return $content;

        $ctas_to_inject = ['awal' => '', 'tengah' => '', 'akhir' => ''];

        for ( $i = 1; $i <= 3; $i++ ) {
            if ( ! empty( $options["coa_cta_{$i}_active"] ) && ! empty( $options["coa_cta_{$i}_heading"] ) && ! empty( $options["coa_cta_{$i}_phones"] ) ) {
                
                $heading   = esc_html( $options["coa_cta_{$i}_heading"] );
                $placement = esc_attr( $options["coa_cta_{$i}_placement"] );
                $phones_raw = $options["coa_cta_{$i}_phones"];

                $bg_color       = !empty($options["coa_cta_{$i}_bg_color"]) ? esc_attr($options["coa_cta_{$i}_bg_color"]) : '#f7f7f7';
                $btn_color      = !empty($options["coa_cta_{$i}_btn_color"]) ? esc_attr($options["coa_cta_{$i}_btn_color"]) : '#0073aa';
                $btn_text_color = !empty($options["coa_cta_{$i}_btn_text_color"]) ? esc_attr($options["coa_cta_{$i}_btn_text_color"]) : '#ffffff';

                $container_style = 'background-color: ' . $bg_color . ';';
                $button_style    = 'background-color: ' . $btn_color . '; color: ' . $btn_text_color . ';';

                $cta_html = '<div class="coa-cta-container" style="' . $container_style . '">';
                $cta_html .= '<h3 class="coa-heading">' . $heading . '</h3>';
                $cta_html .= '<div class="coa-buttons">';

                $phone_lines = explode( "\n", trim( $phones_raw ) );
                
                foreach ( $phone_lines as $line ) {
                    $parts = explode( ',', trim( $line ), 3 );
                    if ( count( $parts ) !== 3 ) continue;

                    $type   = trim( strtolower( $parts[0] ) );
                    $label  = trim( $parts[1] );
                    $number = trim( $parts[2] );
                    
                    $href = '';
                    $icon_html = '';

                    switch ( $type ) {
                        case 'telepon':
                            $icon_html = '<i class="fa-solid fa-phone"></i> ';
                            $sanitized_number = preg_replace( '/[^0-9+]/', '', $number );
                            $href = 'tel:' . esc_attr( $sanitized_number );
                            break;
                        
                        case 'whatsapp':
                            $icon_html = '<i class="fa-brands fa-whatsapp"></i> ';
                            $sanitized_number = preg_replace( '/\D/', '', $number );
                            $href = 'https://wa.me/' . esc_attr( $sanitized_number );
                            break;
                        
                        default:
                            continue 2;
                    }

                    $cta_html .= '<a href="' . $href . '" class="coa-button" style="' . $button_style . '" target="_blank" rel="noopener noreferrer">' . $icon_html . esc_html( $label ) . '</a>';
                }

                $cta_html .= '</div></div>';

                if (isset($ctas_to_inject[$placement])) {
                    $ctas_to_inject[$placement] .= $cta_html;
                }
            }
        }

        if ( ! empty( $ctas_to_inject['awal'] ) ) $content = $ctas_to_inject['awal'] . $content;
        if ( ! empty( $ctas_to_inject['akhir'] ) ) $content = $content . $ctas_to_inject['akhir'];
        if ( ! empty( $ctas_to_inject['tengah'] ) ) {
            $paragraphs = explode( '</p>', $content );
            $paragraph_count = count( $paragraphs );
            $middle_index = floor( $paragraph_count / 2 );

            if ( $paragraph_count > 2 && $middle_index > 0 ) {
                $paragraphs[$middle_index] .= $ctas_to_inject['tengah'];
                $content = implode( '</p>', $paragraphs );
            } else {
                $content .= $ctas_to_inject['tengah'];
            }
        }
    }
    
    return $content;
}
add_filter( 'the_content', 'coa_inject_cta' );