<?php
$aligns = array(
    'left'      => __( 'Left', 'lpr_certificate' ),
    'center'    => __( 'Center', 'lpr_certificate' ),
    'right'     => __( 'Right', 'lpr_certificate' )
);
?>
<select name="<?php echo $field['name'];?>">
    <?php foreach( $aligns as $name => $text ){?>
    <option value="<?php echo $name;?>" <?php selected( ! empty( $field['std'] ) && $field['std'] == $name ? 1 : 0, 1 );?>><?php echo $text;?></option>
    <?php }?>
</select>