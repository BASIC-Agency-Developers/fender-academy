<?php
global $pagenow;
$cert_data = $this->get_cert_data();
?>
<script type="text/html" id="tmpl-certificate">
    <div id="certificate" class="cert-designer clearfix">
        <button id="select-cert-template" type="button" class="button"><?php _e( 'Select template', 'learn_press' );?></button>
        <div></div>
        <div class="cert-fields">
            <ul class="clearfix">
                <?php if( $cert_fields = $this->certificate_fields() ):?>
                    <?php foreach( $cert_fields as $cert_field ):?>
                        <li data-field="<?php echo $cert_field['name'];?>" data-title="<?php echo esc_attr($cert_field['title']);?>" class="cert-layer-field-add <?php echo $cert_field['name'];?>">
                            <h4><?php echo $cert_field['title'];?></h4>
                        </li>
                    <?php endforeach;?>
                <?php endif;?>
            </ul>
        </div>
        <div class="cert-editor clearfix">
            <img class="cert-bg" src="{{data.url}}" />
            <div class="cert-line vertical"></div>
            <div class="cert-line horizontal"></div>
            <div class="cert-layer-position"></div>
            <div class="cert-object-controls">
                <!--<a href="" class="cert-edit-layer dashicons dashicons-edit" data-action="edit"></a>-->
                <a href="" class="cert-remove-layer dashicons dashicons-trash" data-action="remove"></a>
            </div>
        </div>
        <div></div>
        <div class="cert-layer-options">
            <h3>
                <?php _e( 'Layer Options', 'lpr_certificate' );?>
                <span></span>
                <a href="" class="cert-close-options-panel dashicons dashicons-no-alt"></a>
            </h3>
            <div class="cert-options">

            </div>
            <div class="cert-options-cmd">
                <button type="button" class="button button-primary"><?php _e( 'Update', 'lpr_certificate' );?></button>
            </div>
        </div>
        <input type="hidden" name="cert[id]" value="{{data.id}}" >
    </div>
</script>
<?php if( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) && 'lpr_course' == get_post_type() ){?>
<script type="text/html" id="tmpl-cert-selector">
<div class="cert-selector">
    <div class="cert-list-preview">
        <h3>
            <?php _e( 'Select Certificate Template', 'lpr_certificate' );?>
            <button class="button cert-close-box" type="button"><?php _e( 'Cancel', 'lpr_certificate' );?></button>
            <button class="button button-primary cert-select" type="button"><?php _e( 'Select', 'lpr_certificate' );?></button>
        </h3>
        <div class="cert-list">
            <ul>
                <?php if( $list = LPR_Certificate_Helper::get_cert_preview_list() ):?>
                <?php foreach( $list as $id => $preview ):?>
                <li data-id="<?php echo $id;?>">
                    <div class="preview">
                        <img src="<?php echo $preview;?>">
                    </div>
                </li>
                <?php endforeach;?>
                <?php endif;?>
            </ul>
        </div>
    </div>
    <div class="cert-preview"></div>
    <a href="" class="dashicons dashicons-trash"></a>
    <a href="" class="dashicons dashicons-plus"></a>
</div>
</script>
<?php }?>
<?php if( $used_fonts = LPR_Certificate_Helper::get_google_fonts_from_data( $cert_data ) ):?>
<script type="text/javascript">
    WebFont.load({
        google: {
            families: <?php echo json_encode( $used_fonts );?>
        },
        fontinactive: function(familyName, fvd) {
            console.log("Sorry " + familyName + " font family can't be loaded at the moment. Retry later.");
        },
        active: function(a, b) {
            console.log(a+','+b)
        }
    });
</script>
<?php endif;?>
<?php if( ! empty( $cert_data['preview'] ) ) unset( $cert_data['preview'] );?>
<script type="text/javascript">
    var certificateDesigner = <?php echo json_encode( $cert_data );?>;
</script>