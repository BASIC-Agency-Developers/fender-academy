<?php
class LPR_Certificate_Field_Custom extends LPR_Certificate_Field{
    function __construct( $options ){
        parent::__construct( $options );
    }

    function get_option_fields( $field = array() ){

        $fields = array(
            array(
                'name'  => 'text',
                'type'  => 'text',
                'title' => __( 'Custom text', 'lpr_certificate' ),
                'std'   => '',
                'class' => 'regular-text'
            ),
        );
        $fields = array_merge( $fields, LPR_Certificate_Helper::get_default_field_options() );
        return parent::get_option_fields( $fields );
    }
}