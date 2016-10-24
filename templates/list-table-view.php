<div class="wrap">
    <h2><?php _e( '%heading%', '%textdomain%' ); ?> <a href="<?php echo admin_url( 'admin.php?page=%PAGENAME%&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', '%textdomain%' ); ?></a></h2>

    <?php 
    if( isset( $_GET['action'] ) && $_GET['action'] == "delete" ) 
    {   
        if ( %prefix%_delete_%singular_name%( $id ) ) 
        {
            ?>
           <div class="notice notice-success"><p>Succesfully deleted!</p></div>
           <?php
        }
        else
        {
            ?>
           <div class="notice notice-error"><p>Some error!</p></div>
           <?php
        }
    }
    ?>

    <?php if (array_key_exists('error', $_GET)): ?>
        <div class="notice notice-error"><p><?php echo $_GET['error']; ?></p></div>
    <?php endif; ?>
    <?php if (array_key_exists('success', $_GET)): ?>
        <div class="notice notice-success"><p><?php echo $_GET['success']; ?></p></div>
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
