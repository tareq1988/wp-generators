<div class="wrap">
    <h1><?php _e( '%heading%', '%textdomain%' ); ?></h1>%retrieve_row%

    <form action="" method="post">

        <table class="form-table">
            <tbody>%rows%</tbody>
        </table>

        <input type="hidden" name="field_id" value="%field_id%">

        <?php wp_nonce_field( '%nonce%' ); ?>
        <?php submit_button( __( '%submit_new_text%', '%textdomain%' ), 'primary', '%submit_name%' ); ?>

    </form>
</div>