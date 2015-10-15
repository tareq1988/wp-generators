<div class="wrap">
    <h2><?php _e( '%heading%', '%textdomain%' ); ?></h2>%retrieve_row%

    <form action="" method="post">
        %rows%

        <input type="hidden" name="field_id" value="%field_id%">

        <?php wp_nonce_field( '%nonce%' ); ?>
        <?php submit_button( __( '%submit_new_text%', '%textdomain%' ), 'primary', '%submit_name%' ); ?>

    </form>
</div>