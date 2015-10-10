<?php
if ( isset( $_POST['submit'] ) ) {

    $list_table_codes     = file_get_contents( 'templates/list-table.php' );
    $list_table_functions = file_get_contents( 'templates/list-table-functions.php' );
    $list_table_view      = file_get_contents( 'templates/list-table-view.php' );

    $column_names         = '';
    $column_defaults      = '';
    $first_column         = $_POST['table_key'][0];

    foreach ($_POST['table_key'] as $key => $value) {
        $column_names    .= "            '$value'      => __( '" . $_POST['table_value'][ $key ] . "', '" . $_POST['textdomain'] ."' ),\n";
        $column_defaults .= "            case '$value':\n";
        $column_defaults .= "                return \$item->$value;\n\n";
    }

    $search_array = array(
        '%class_name%',
        '%heading%',
        '%singular_name%',
        '%plural_name%',
        '%no_items%',
        '%per_page%',
        '%mysql_table_name%',
        '%textdomain%',
        '%column_names%',
        '%column_defaults%',
        '%prefix%',
        '%first_column%',
        '%PAGENAME%',
    );

    $replace_array = array(
        $_POST['class_name'],
        $_POST['heading'],
        $_POST['singular_name'],
        $_POST['plural_name'],
        $_POST['no_items'],
        $_POST['per_page'],
        $_POST['mysql_table_name'],
        $_POST['textdomain'],
        $column_names,
        $column_defaults,
        $_POST['prefix'],
        $first_column,
        $_POST['page_name'],
    );

    $list_table_codes     = str_replace( $search_array, $replace_array, $list_table_codes );
    $list_table_functions = str_replace( $search_array, $replace_array, $list_table_functions );
    $list_table_view      = str_replace( $search_array, $replace_array, $list_table_view );
    // var_dump( $list_table_codes );
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="page-header">
                <h1>Generate WP List Table</h1>
            </div>

            <?php if ( isset( $_POST['submit'] ) ) { ?>
            <p><strong><?php printf( 'class-%s-list-table.php', $_POST['singular_name'] ); ?></strong></p>
            <pre class="prettyprint" style="overflow-y: scroll;width:100%;"><?php echo htmlentities( $list_table_codes ); ?></pre>

            <p><strong><?php printf( '%s-functions.php', $_POST['singular_name'] ); ?></strong></p>
            <pre class="prettyprint" style="overflow-y: scroll;width:100%;"><?php echo htmlentities( $list_table_functions ); ?></pre>

            <p><strong><?php printf( '%s-list.php', $_POST['singular_name'] ); ?></strong></p>
            <pre class="prettyprint" style="overflow-y: scroll;width:100%;"><?php echo htmlentities( $list_table_view ); ?></pre>
            <?php } ?>

            <form class="form-horizontal" method="post">
                <fieldset>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="class">Class Name</label>
                        <div class="col-md-5">
                            <input id="class" name="class_name" type="text" placeholder="WeDevs_Transaction_List_Table" class="form-control input-md" required value="<?php echo isset( $_POST['class_name' ] ) ? $_POST['class_name'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="heading">Heading Title</label>
                        <div class="col-md-5">
                            <input id="heading" name="heading" type="text" placeholder="Page heading name: Transactions" class="form-control input-md" value="<?php echo isset( $_POST['heading' ] ) ? $_POST['heading'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singular_name">Singular Name</label>
                        <div class="col-md-5">
                            <input id="singular_name" name="singular_name" type="text" placeholder="book" class="form-control input-md" value="<?php echo isset( $_POST['singular_name' ] ) ? $_POST['singular_name'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="plural_name">Plural Name</label>
                        <div class="col-md-5">
                            <input id="plural_name" name="plural_name" type="text" placeholder="books" class="form-control input-md" value="<?php echo isset( $_POST['plural_name' ] ) ? $_POST['plural_name'] : ''; ?>">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="no_items">No Items Text</label>
                        <div class="col-md-5">
                            <input id="no_items" name="no_items" type="text" placeholder="No books found" class="form-control input-md" value="<?php echo isset( $_POST['no_items' ] ) ? $_POST['no_items'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="per_page">Items Per Page</label>
                        <div class="col-md-5">
                            <input id="per_page" name="per_page" type="text" placeholder="20" class="form-control input-md"  value="<?php echo isset( $_POST['per_page' ] ) ? $_POST['per_page'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="mysql_table_name">MySQL Table Name</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon">wp_</span>
                                <input id="mysql_table_name" name="mysql_table_name" type="text" placeholder="comments" class="form-control input-md" value="<?php echo isset( $_POST['mysql_table_name' ] ) ? $_POST['mysql_table_name'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="prefix">Function Prefix</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input id="prefix" name="prefix" type="text" placeholder="wd" class="form-control input-md" value="<?php echo isset( $_POST['prefix' ] ) ? $_POST['prefix'] : ''; ?>">
                                <span class="input-group-addon">_function_name</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textdomain">Textdomain</label>
                        <div class="col-md-5">
                            <input id="textdomain" name="textdomain" type="text" placeholder="wedevs" class="form-control input-md"  value="<?php echo isset( $_POST['textdomain' ] ) ? $_POST['textdomain'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="col-md-4 control-label" for="page_name">Page Slug</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">admin.php?page=</span>
                            <input id="page_name" name="page_name" type="text" placeholder="test-page" class="form-control input-md"  value="<?php echo isset( $_POST['page_name' ] ) ? $_POST['page_name'] : ''; ?>">
                        </div>
                    </div>
                </div>

                    <h3>Table Columns</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input id="textdomain" name="table_key[]" type="text" placeholder="book_title" class="form-control input-md" required>
                                </td>
                                <td>
                                    <input id="textdomain" name="table_value[]" type="text" placeholder="Book Title" class="form-control input-md" required>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-success add-row">+</a>
                                    <a href="#" class="btn btn-sm btn-danger remove-row">-</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

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
