<?php
class LPR_Certificate_Field_Start_Date extends LPR_Certificate_Field{
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
                    'title' => __( 'Date format', 'lpr_certificate' ),
                    'std'   => 'd.m.Y'
                )
            )
        );
        return parent::get_option_fields( $fields );
    }

    function parse_text(){
        $text = "";
        if( ! empty( $this->_data['user'] ) && ! empty( $this->_data['course'] ) ){
            $user = $this->_data['user'];
            $course = $this->_data['course'];
            $user_time = get_user_meta( $user->ID, '_lpr_course_time', true );
            $format = ! empty( $this->_options['__x_format'] ) ? $this->_options['__x_format'] : 'd.m.Y';
            if( $user_time && ! empty( $user_time[ $course->ID ] ) ){
                $text = date( $format, $user_time[ $course->ID ]['start'] );
            }
        }
        return $text;
    }
}