<?php
class LPR_Certificate_Field_Course_Name extends LPR_Certificate_Field{
    function __construct( $options ){
        parent::__construct( $options );
    }

    function get_option_fields( $field = array() ){

        $fields = LPR_Certificate_Helper::get_default_field_options();

        return parent::get_option_fields( $fields );
    }

    function parse_text(){
        $text = "";
        if( ! empty( $this->_data[ 'course'] ) ){
            $text = apply_filters( 'certificate_field_course_name', $this->_data['course']->post_title );
        }
        return $text;
    }
}