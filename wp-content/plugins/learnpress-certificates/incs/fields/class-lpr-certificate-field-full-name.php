<?php

/**
 * Class LPR_Certificate_Field_Full_Name
 */
class LPR_Certificate_Field_Full_Name extends LPR_Certificate_Field{

    /**
     * Constructor
     *
     * @param array
     */
    function __construct( $options ){
        parent::__construct( $options );
    }

    /**
     * Get options of this field and set std value if passed
     *
     * @param array $field
     * @return array
     */
    function get_option_fields( $field = array() ){
        $fields = LPR_Certificate_Helper::get_default_field_options();
        array_splice(
            $fields,
            1,
            0,
            array(
                array(
                    'name'  => '__x_display_as',
                    'type'  => 'select',
                    'title' => __( 'Display', 'lpr_certificate' ),
                    'std'   => 'username',
                    'options' => array(
                        'user_login'            => __( 'User login', 'lpr_certificate' ),
                        'user_nicename'         => __( 'User nice name', 'lpr_certificate' ),
                        'nickname'              => __( 'Nickname', 'lpr_certificate' ),
                        'first_name'            => __( 'First name', 'lpr_certificate' ),
                        'last_name'             => __( 'Last name', 'lpr_certificate' ),
                        'first_name last_name'  => __( 'First name + Last name', 'lpr_certificate' ),
                        'last_name first_name'  => __( 'Last name + First name', 'lpr_certificate' ),
                    )
                )
            )
        );
        return parent::get_option_fields( $fields );
    }

    function parse_text(){
        $text = "";
        $format = ! empty( $this->_options['__x_display_as'] ) ? $this->_options['__x_display_as'] : '';
        if( ! empty( $this->_data['user'] ) ){
            $user = $this->_data['user'];
            if( ! $format ) {
                $text = $this->_data['user']->user_login;
            }else{
                $searches = array(
                    'user_login',
                    'user_nicename',
                    'nickname',
                    'first_name',
                    'last_name',
                    'first_name last_name',
                    'last_name first_name'
                );
                $replaces = array(
                    $user->user_login,
                    $user->user_nicename,
                    $user->nickname,
                    $user->first_name,
                    $user->last_name,
                    $user->first_name . ' ' . $user->last_name,
                    $user->last_name . ' ' . $user->first_name
                );
                $text = str_replace( $searches, $replaces, $format );
            }
        }
        return $text;
    }
}