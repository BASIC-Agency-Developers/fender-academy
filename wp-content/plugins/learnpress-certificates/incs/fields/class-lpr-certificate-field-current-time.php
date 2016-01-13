<?php
class LPR_Certificate_Field_Current_Time extends LPR_Certificate_Field{
    function __construct( $options ){
        parent::__construct( $options );
    }

    function get_option_fields( $field = array() ){

        $fields = LPR_Certificate_Helper::get_default_field_options();
        array_splice(
            $fields,
            1,
            0,
            array(
                array(
                    'name'  => '__x_format',
                    'type'  => 'text',
                    'title' => __( 'Time format', 'lpr_certificate' ),
                    'std'   => 'h:i'
                )
            )
        );
        return parent::get_option_fields( $fields );
    }

    function parse_text(){
        $format = ! empty( $this->_options['__x_format'] ) ? $this->_options['__x_format'] : 'd.m.Y';
        $text = apply_filters( 'certificate_field_current_time', date( $format, time() ) );
        return $text;
    }
}