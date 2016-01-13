<?php
$aligns = array(
    'top'      => __( 'Top', 'lpr_certificate' ),
    'middle'    => __( 'Middle', 'lpr_certificate' ),
    'bottom'     => __( 'Bottom', 'lpr_certificate' )
);
?>
<select name="<?php echo $field['name'];?>">
    <?php foreach( $aligns as $name => $text ){?>
    <option value="<?php echo $name;?>" <?php selected( ! empty( $field['std'] ) && $field['std'] == $name ? 1 : 0, 1 );?>><?php echo $text;?></option>
    <?php }?>
</select>