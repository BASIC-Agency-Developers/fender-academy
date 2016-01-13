<?php

/**
 * Class LPR_Certificate_Helper
 */
class LPR_Certificate_Helper{
    /**
     * Return the list of Google web fonts
     *
     * @return array
     */
    static function google_fonts(){
        $fonts = array("Abel", "Abril Fatface", "Aclonica", "Actor", "Adamina", "Aguafina Script", "Aladin", "Aldrich", "Alice", "Alike Angular", "Alike", "Allan", "Allerta Stencil", "Allerta", "Amaranth", "Amatic SC", "Andada", "Andika", "Annie Use Your Telescope", "Anonymous Pro", "Antic", "Anton", "Arapey", "Architects Daughter", "Arimo", "Artifika", "Arvo", "Asset", "Astloch", "Atomic Age", "Aubrey", "Bangers", "Bentham", "Bevan", "Bigshot One", "Bitter", "Black Ops One", "Bowlby One SC", "Bowlby One", "Brawler", "Bubblegum Sans", "Buda", "Butcherman Caps", "Cabin Condensed", "Cabin Sketch", "Cabin", "Cagliostro", "Calligraffitti", "Candal", "Cantarell", "Cardo", "Carme", "Carter One", "Caudex", "Cedarville Cursive", "Changa One", "Cherry Cream Soda", "Chewy", "Chicle", "Chivo", "Coda Caption", "Coda", "Comfortaa", "Coming Soon", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Cousine", "Coustard", "Covered By Your Grace", "Crafty Girls", "Creepster Caps", "Crimson Text", "Crushed", "Cuprum", "Damion", "Dancing Script", "Dawning of a New Day", "Days One", "Delius Swash Caps", "Delius Unicase", "Delius", "Devonshire", "Didact Gothic", "Dorsa", "Dr Sugiyama", "Droid Sans Mono", "Droid Sans", "Droid Serif", "EB Garamond", "Eater Caps", "Expletus Sans", "Fanwood Text", "Federant", "Federo", "Fjord One", "Fondamento", "Fontdiner Swanky", "Forum", "Francois One", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar Fill", "Geostar", "Give You Glory", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Goudy Bookletter 1911", "Gravitas One", "Gruppo", "Hammersmith One", "Herr Von Muellerhoff", "Holtwood One SC", "Homemade Apple", "IM Fell DW Pica SC", "IM Fell DW Pica", "IM Fell Double Pica SC", "IM Fell Double Pica", "IM Fell English SC", "IM Fell English", "IM Fell French Canon SC", "IM Fell French Canon", "IM Fell Great Primer SC", "IM Fell Great Primer", "Iceland", "Inconsolata", "Indie Flower", "Irish Grover", "Istok Web", "Jockey One", "Josefin Sans", "Josefin Slab", "Judson", "Julee", "Jura", "Just Another Hand", "Just Me Again Down Here", "Kameron", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kreon", "Kristi", "La Belle Aurore", "Lancelot", "Lato", "League Script", "Leckerli One", "Lekton", "Lemon", "Limelight", "Linden Hill", "Lobster Two", "Lobster", "Lora", "Love Ya Like A Sister", "Loved by the King", "Luckiest Guy", "Maiden Orange", "Mako", "Marck Script", "Marvel", "Mate SC", "Mate", "Maven Pro", "Meddon", "MedievalSharp", "Megrim", "Merienda One", "Merriweather", "Metrophobic", "Michroma", "Miltonian Tattoo", "Miltonian", "Miss Fajardose", "Miss Saint Delafield", "Modern Antiqua", "Molengo", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas", "Mr Bedford", "Mr Dafoe", "Mr De Haviland", "Mrs Sheppards", "Muli", "Neucha", "Neuton", "News Cycle", "Niconne", "Nixie One", "Nobile", "Nosifer Caps", "Nothing You Could Do", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Numans", "Nunito", "Old Standard TT", "Open Sans Condensed", "Open Sans", "Orbitron", "Oswald", "Over the Rainbow", "Ovo", "PT Sans Caption", "PT Sans Narrow", "PT Sans", "PT Serif Caption", "PT Serif", "Pacifico", "Passero One", "Patrick Hand", "Paytone One", "Permanent Marker", "Petrona", "Philosopher", "Piedra", "Pinyon Script", "Play", "Playfair Display", "Podkova", "Poller One", "Poly", "Pompiere", "Prata", "Prociono", "Puritan", "Quattrocento Sans", "Quattrocento", "Questrial", "Quicksand", "Radley", "Raleway", "Rammetto One", "Rancho", "Rationale", "Redressed", "Reenie Beanie", "Ribeye Marrow", "Ribeye", "Righteous", "Rochester", "Rock Salt", "Rokkitt", "Rosario", "Ruslan Display", "Salsa", "Sancreek", "Sansita One", "Satisfy", "Schoolbell", "Shadows Into Light", "Shanti", "Short Stack", "Sigmar One", "Signika Negative", "Signika", "Six Caps", "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Sorts Mill Goudy", "Special Elite", "Spinnaker", "Spirax", "Stardos Stencil", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Syncopate", "Tangerine", "Tenor Sans", "Terminal Dosis", "The Girl Next Door", "Tienne", "Tinos", "Tulpen One", "Ubuntu Condensed", "Ubuntu Mono", "Ubuntu", "Ultra", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "VT323", "Varela Round", "Varela", "Vast Shadow", "Vibur", "Vidaloka", "Volkhov", "Vollkorn", "Voltaire", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", "Wire One", "Yanone Kaffeesatz", "Yellowtail", "Yeseva One", "Zeyada");
        return $fonts;
    }

    static function is_hex($hex){
        return $hex && preg_match( '/^#?([a-f0-9]{3})$/i', $hex, $matches ) || preg_match( '/^#?([a-f0-9]{6})$/i', $hex, $matches );
    }
    /**
     * Convert color from hex to rgb
     *
     * @param string $hex
     * @return array
     */
    static function hex_to_rgb( $hex ) {
        if( ! self::is_hex( $hex ) ) return $hex;
        if( preg_match( '/^#?([a-f0-9]{3})$/i', $hex, $matches ) ){
            $hex = $matches[1];
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } elseif( preg_match( '/^#?([a-f0-9]{6})$/i', $hex, $matches ) ) {
            $hex = $matches[1];
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        return $rgb;
    }

    /**
     * Get common options for all layers
     *
     * @return array
     */
    static function get_default_field_options(){
        $fields = array(
            array(
                'name'  => 'fontFamily',
                'type'  => 'font',
                'title' => __( 'Font', 'lpr_certificate' ),
                'std'   => '',
                'google_font' => true
            ),
            array(
                'name'  => 'fontSize',
                'type'  => 'slider',
                'title' => __( 'Font size', 'lpr_certificate' ),
                'std'   => '',
                'min'   => 8,
                'max'   => 512
            ),
            array(
                'name'  => 'fill',
                'type'  => 'color',
                'title' => __( 'Color', 'lpr_certificate' ),
                'std'   => ''
            ),
            array(
                'name'  => 'originX',
                'type'  => 'text_align',
                'title' => __( 'Text align', 'lpr_certificate' ),
                'std'   => ''
            ),
            array(
                'name'  => 'originY',
                'type'  => 'vertical_align',
                'title' => __( 'Text vertical align', 'lpr_certificate' ),
                'std'   => ''
            ),
            array(
                'name'  => 'angle',
                'type'  => 'slider',
                'title' => __( 'Angle', 'lpr_certificate' ),
                'std'   => '',
                'min'   => 0,
                'max'   => 360
            ),
            array(
                'name'  => 'scaleX',
                'type'  => 'slider',
                'title' => __( 'Scale X', 'lpr_certificate' ),
                'std'   => '',
                'min'   => -50,
                'max'   => 50,
                'step'  => 0.1
            ),
            array(
                'name'  => 'scaleY',
                'type'  => 'slider',
                'title' => __( 'Scale Y', 'lpr_certificate' ),
                'std'   => '',
                'min'   => -50,
                'max'   => 50,
                'step'  => 0.1
            )
        );
        return $fields;
    }

    static function get_cert_preview_list(){
        $cert_posts = get_posts(
            array(
                'post_type'         => 'lpr_certificate',
                'posts_per_page'    => 9999
            )
        );
        $preview = array();
        if( $cert_posts ){
            foreach( $cert_posts as $p ){
                $cert_data = get_post_meta( $p->ID, '_lpr_cert', true );
                if( $cert_data && ! empty( $cert_data['preview'] ) ){
                    $preview[ $p->ID ] = $cert_data['preview'];
                }
            }
        }
        return $preview;
    }

    static function get_google_fonts_from_data( $cert_data ){
        $fonts = self::google_fonts();
        $used_fonts = array();
        if( ! empty(  $cert_data['layers'] ) && is_array( $cert_data['layers'] ) ){
            foreach( $cert_data['layers'] as $layer ){
                settype( $layer, 'array' );
                foreach( $layer as $k => $prop ){
                    if( $prop && is_string( $prop ) && strlen( $prop ) > 3 && in_array( $prop, $fonts ) ){
                        $used_fonts[] = $prop;
                    }
                }
            }
        }
        return $used_fonts;
    }

    static function get_cert_data( $user_id, $course_id ){
        global $post;
        $cert_id = get_post_meta( $course_id, '_lpr_course_certificate', true );
        $data = get_post_meta( $cert_id, '_lpr_cert', true );
        if( $data ){
            if( ! empty( $data['id'] ) ){
                $data['url'] = wp_get_attachment_url( $data['id'] );
            }
            if( $data['preview'] ){
                unset( $data['preview'] );
            }
        }
        if( $data['layers'] ) foreach( $data['layers'] as $k => $layer){

            $field = LPR_Certificate_Field::instance( (array)$layer );
            $field->set_data( 'user', get_user_by( 'id', $user_id ) );
            $field->set_data( 'course', get_post( $course_id ) );
            $data['layers'][ $k ]->text = $field->parse_text();
        }
        if( $post ) {
            $cert = get_post( $cert_id );
            $data['post_id'] = $post->ID;
            $data['cert_name'] = $cert->post_name;
        }

        return $data;
    }

    static function validate_json( $object ){
        if( is_object( $object ) || is_array( $object ) ) {
            $json = json_encode($object);
        }else {
            $json = $object;
        }
        $json = preg_replace( '!"(true|false|-?[0-9]+(.[0-9]+)?)"!i', '$1', $json );
        if( is_object( $object ) ){
            return json_decode( $json );
        }elseif( is_array( $object ) ){
            return (array)json_decode( $json );
        }
        return $json;
    }

    /**
     * Convert color from rgb to hex
     *
     * @param string
     * @return string
     */
    static function rgb_to_hex( $rgb ) {
        if( self::is_hex( $rgb ) ) return $rgb;
        echo "[$rgb]";
        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
        return $hex;
    }
}