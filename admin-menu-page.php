<?php include 'header.php'; ?>

<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="page-header">
                <h1>Generate Menu Page</h1>
            </div>

            <?php if ( isset( $_POST['submit'] ) ) {
                $class_menu = file_get_contents( 'templates/class-menu.php' );
                $search_array = array(
                    '%class_name%',
                    '%menu_title%',
                    '%capability%',
                    '%page_slug%',
                    '%file_prefix%',
                    '%textdomain%',
                );

                $replace_array = array(
                    $_POST['class_name'],
                    $_POST['menu_title'],
                    $_POST['capability'],
                    $_POST['page_slug'],
                    $_POST['file_prefix'],
                    $_POST['textdomain'],
                );

                $class_menu = str_replace( $search_array, $replace_array, $class_menu );
                ?>
                <p><strong><?php printf( 'class-%s.php', str_replace( '_', '-', strtolower( $_POST['class_name'] ) ) ); ?></strong></p>
                <pre style="overflow-y: scroll;width:100%;"><?php echo htmlentities( $class_menu ); ?></pre>
            <?php } ?>

            <form class="form-horizontal" method="post">
                <fieldset>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="class">Class Name</label>
                        <div class="col-md-4">
                            <input id="class" name="class_name" type="text" placeholder="Test_Admin_Menu" class="form-control input-md" value="<?php echo isset( $_POST['class_name' ] ) ? $_POST['class_name'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="menu_title">Menu Title</label>
                        <div class="col-md-4">
                            <input id="menu_title" name="menu_title" type="text" placeholder="Admin Menu Title" class="form-control input-md" value="<?php echo isset( $_POST['menu_title' ] ) ? $_POST['menu_title'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="capability">Capability</label>
                        <div class="col-md-4">
                            <input id="capability" name="capability" type="text" placeholder="manage_options" class="form-control input-md" value="<?php echo isset( $_POST['capability' ] ) ? $_POST['capability'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="page_slug">Page Slug</label>
                        <div class="col-md-4">
                            <input id="page_slug" name="page_slug" type="text" placeholder="settings-page-slug" class="form-control input-md" value="<?php echo isset( $_POST['page_slug' ] ) ? $_POST['page_slug'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="file_prefix">File Name Prefix</label>
                        <div class="col-md-4">
                            <input id="file_prefix" name="file_prefix" type="text" placeholder="transaction" class="form-control input-md" value="<?php echo isset( $_POST['file_prefix' ] ) ? $_POST['file_prefix'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textdomain">Textdomain</label>
                        <div class="col-md-4">
                            <input id="textdomain" name="textdomain" type="text" placeholder="wedevs" class="form-control input-md" value="<?php echo isset( $_POST['textdomain' ] ) ? $_POST['textdomain'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="submit"></label>
                        <div class="col-md-4">
                            <button id="submit" name="submit" class="btn btn-primary">Generate Table</button>
                        </div>
                    </div>

                </fieldset>
            </form>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>