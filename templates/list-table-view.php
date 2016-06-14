<div class="wrap">
    <h2><?php _e( '%heading%', '%textdomain%' ); ?> <a href="<?php echo admin_url( 'admin.php?page=%PAGENAME%&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', '%textdomain%' ); ?></a></h2>
    <?php if (array_key_exists('error', $_GET)): ?>
        <div class="notice notice-error"><p><?= $_GET['error']; ?></p></div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table = new %class_name%();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>
</div>
