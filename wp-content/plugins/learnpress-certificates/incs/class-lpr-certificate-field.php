<?php

/**
 * Class LPR_Certificate_Field
 */
class LPR_Certificate_Field{
    /**
     * @var array
     */
    protected $_options;

    /**
     * @var array
     */
    protected $_data = array();

    /**
     * Constructor
     *
     * @param array
     */
    function __construct( $options ){
        $this->_options = $options;
    }

    /**
     * Get default options - this function should be overridden by extended class
     *
     * @param array
     * @return array
     */
    function get_option_fields( $fields = array() ){
        if( $fields ){
            foreach( $fields as $k => $v ){
                if( array_key_exists( $v['name'], $this->_options ) ){
                    $fields[ $k ]['std'] = $this->_options[ $v['name'] ];
                }
            }
        }
        return $fields;
    }

    /**
     * Output field options
     *
     * @param bool
     * @return string
     */
    function output_options( $echo = true ){
        ob_start();
        if( $fields = $this->get_option_fields() ){
            echo '<ul>';
            foreach( $fields as $field ){
                ?>
                <li>
                    <label><?php echo $field['title'];?></label>
                    <?php require LPR_CERTIFICATE_PATH . '/incs/html/fields/' . str_replace( '_', '-', $field['type'] ) . '.php';?>
                </li>
                <?php
            }
            echo '<ul>';
        }
        $output = ob_get_clean();
        if( $echo ) echo $output;
        return $output;
    }

    /**
     * Create an unique ID
     *
     * @return string
     */
    function unique_id(){
        return uniqid( 'cert-option-' );
    }

    /**
     * Get the name of this class
     *
     * @return mixed
     */
    function get_human_name(){
        $name = preg_replace( '!LPR_Certificate_Field_!', '', get_class( $this ) );
        $name = str_replace( '_', ' ', $name );
        return $name;
    }

    function set_data( $key, $value ){
        $this->_data[ $key ] = $value;
    }

    function parse_text(){
        return $this->_options['text'];
    }

    function __toString(){
        return $this->get_human_name();
    }

    /**
     * Create an instance of a field type
     *
     * @param array
     * @return bool|object
     */
    static function instance( $options ){
        $instance = false;
        if( empty( $options['field'] ) ){
            //wp_die( __( 'Unknown field type', 'lpr_certificate' ) );
            $options['field'] = 'custom';
        }
        $class_name = "LPR_Certificate_Field_" . ucfirst( preg_replace_callback( '!(_[a-z])!', create_function('$a', 'return strtoupper($a[0]);') , $options['field'] ) );
        if( ! class_exists( $class_name ) ){
            $file_name = sprintf( 'class-lpr-certificate-field-%s.php', strtolower( str_replace( '_', '-', $options['field'] ) ) );
            if( ! file_exists( $file = LPR_CERTIFICATE_PATH . '/incs/fields/' . $file_name ) ){
                wp_die( sprintf( __( 'File %s for class does not exists', 'lpr_certificate' ), $file ) );
            }else {
                require_once( LPR_CERTIFICATE_PATH . '/incs/fields/' . $file_name );
            }
        }
        if( ! class_exists( $class_name ) ){
            wp_die( sprintf( __( 'Class %s does not exists', 'lpr_certificate' ), $class_name ) );
        }else {
            $instance = new $class_name($options);
        }
        return $instance;
    }
}