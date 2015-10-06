<?php

function %prefix%_render_list_page() {
    $list_table = new %class_name%();
    $list_table->prepare_items();
    ?>
<div class="wrap">
    <h2><?php _e( '%heading%', '%textdomain%' ); ?></h2>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>
</div>
    <?php
}