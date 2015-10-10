<?php

function build_rows( $edit = false ) {
    $rows      = "\n";
    $indent    = '                ';
    $tab       = '    ';

    foreach ($_POST['input_type'] as $key => $input_type) {
        $rows     .= $indent . sprintf( '<tr class="row-%s">', str_replace( '_', '-', $_POST['name'][$key] ) ) . "\n";
        $rows     .= $indent . $tab . "<th scope=\"row\">\n";
        $required = ( $_POST['required'][$key] == 'yes' ) ? ' required="required"' : '';

        if ( ! in_array( $input_type, array( 'checkbox', 'radio' ) ) ) {
            $rows .= $indent . $tab . $tab . sprintf( '<label for="%s"><?php _e( \'%s\', \'%s\' ); ?></label>', $_POST['name'][$key], $_POST['label'][$key], $_POST['textdomain'] ) . "\n";
        } else {
            $rows .= $indent . $tab . $tab . sprintf( '<?php _e( \'%s\', \'%s\' ); ?>', $_POST['label'][$key], $_POST['textdomain'] ) . "\n";
        }

        $rows .= $indent . $tab . "</th>\n";

        $rows .= $indent . $tab . "<td>\n";

        switch ($input_type) {
            case 'text':
            case 'number':
                $value = '';

                if ( $edit ) {
                    $value = sprintf( '<?php echo esc_attr( $item->%s ); ?>', $_POST['name'][$key] );
                }

                $rows .= $indent . $tab . $tab . sprintf( '<input type="%6$s" name="%1$s" id="%1$s" class="regular-text" placeholder="<?php echo esc_attr( \'%2$s\', \'%3$s\' ); ?>" value="%4$s"%5$s />', $_POST['name'][$key], $_POST['label'][$key], $_POST['textdomain'], $value, $required, $input_type ) . "\n";
                break;

            case 'textarea':
                $value = '';

                if ( $edit ) {
                    $value = sprintf( '<?php echo esc_textarea( $item->%s ); ?>', $_POST['name'][$key] );
                }
                $rows .= $indent . $tab . $tab . sprintf( '<textarea name="%1$s" id="%1$s"placeholder="<?php echo esc_attr( \'%2$s\', \'%3$s\' ); ?>" rows="5" cols="30"%5$s>%4$s</textarea>', $_POST['name'][$key], $_POST['label'][$key], $_POST['textdomain'], $value, $required ) . "\n";
                break;

            case 'select':
                $rows .= $indent . $tab . $tab . sprintf( '<select name="%1$s" id="%1$s"%2$s>', $_POST['name'][$key], $required ) . "\n";

                $options = explode( "\n", $_POST['values'][ $key ] );
                if ( $options ) {
                    foreach ($options as $option) {
                        $option   = explode( ':', $option );
                        $selected = '';

                        if ( $edit ) {
                            $selected = sprintf( ' <?php selected( $item->%s, \'%s\' ); ?>', $_POST['name'][$key], $option[0] );
                        }

                        $rows .= $indent . $tab . $tab . $tab . sprintf( '<option value="%s"%s>%s</option>', $option[0], $selected, trim( $option[1] ) ) . "\n";
                    }
                }

                $rows .= $indent . $tab . $tab . "</select>\n";
                break;

            case 'checkbox':
                $checked = '';

                if ( $edit ) {
                    $checked = sprintf( ' <?php checked( $item->%s, \'on\' ); ?>', $_POST['name'][$key] );
                }

                $rows .= $indent . $tab . $tab . sprintf( '<label for="%1$s"><input type="checkbox" name="%1$s" id="%1$s" value="on"%4$s%5$s /> <?php _e( \'%2$s\', \'%3$s\' ); ?></label>', $_POST['name'][$key], $_POST['values'][$key], $_POST['textdomain'], $checked, $required ) . "\n";
                break;

            default:
                # code...
                break;
        }

        if ( ! empty( $_POST['help'][ $key ] ) ) {
            if ( $input_type == 'textarea' ) {
                $rows .= $indent . $tab . $tab . '<p class="description"><?php _e(\'' . $_POST['help'][$key] . "', '{$_POST['textdomain']}' ); ?></p>\n";
            } else {
                $rows .= $indent . $tab . $tab . '<span class="description"><?php _e(\'' . $_POST['help'][$key] . "', '{$_POST['textdomain']}' ); ?></span>\n";
            }
        }

        $rows .= $indent . $tab . "</td>\n";
        $rows .= $indent . "</tr>\n";
    }

    $rows .= '             ';

    return $rows;
}


include 'header.php'; ?>

<div class="container">
    <div class="row">

        <div class="col-md-12">

            <div class="page-header">
                <h1>Generate Form Table</h1>
            </div>

            <?php if ( isset( $_POST['submit'] ) ) {
                $form_code            = file_get_contents( 'templates/form.php' );
                $form_handler         = file_get_contents( 'templates/form-handler.php' );
                $form_functions       = file_get_contents( 'templates/form-functions.php' );

                $new_rows             = build_rows();
                $edit_rows            = build_rows( true );
                $tab                  = '    ';

                $form_fields          = '';
                $required_form_fields = '';
                $form_fields_array    = "array(\n";
                $add_date_field       = '';
                $form_default_array   = '';
                $retrieve_row         = "\n\n" . $tab . sprintf( '<?php $item = %s_get_%s( $id ); ?>', $_POST['prefix'], $_POST['singular_name'] );
                $wp_errors            = $tab . "// some basic validation\n";

                if ( $_POST['date_field'] == 'on' ) {
                    $add_date_field = '$args[\'date\'] = current_time( \'mysql\' );';
                }

                foreach ($_POST['input_type'] as $key => $input_type) {
                    switch ($input_type) {
                        case 'number':
                            $form_fields .= $tab . $tab . sprintf( '$%1$s = isset( $_POST[\'%1$s\'] ) ? intval( $_POST[\'%1$s\'] ) : 0;', $_POST['name'][$key] ) . "\n";
                            break;

                        case 'textarea':
                            $form_fields .= $tab . $tab . sprintf( '$%1$s = isset( $_POST[\'%1$s\'] ) ? wp_kses_post( $_POST[\'%1$s\'] ) : \'\';', $_POST['name'][$key] ) . "\n";
                            break;

                        default:
                            $form_fields .= $tab . $tab . sprintf( '$%1$s = isset( $_POST[\'%1$s\'] ) ? sanitize_text_field( $_POST[\'%1$s\'] ) : \'\';', $_POST['name'][$key] ) . "\n";
                            break;
                    }

                    if ( $_POST['required'][ $key ] == 'yes' ) {
                        $required_form_fields .= $tab . $tab . sprintf( 'if ( ! $%s ) {', $_POST['name'][ $key ] ) . "\n";
                        $required_form_fields .= $tab . $tab . $tab . sprintf( '$errors[] = __( \'Error: %s is required\', \'%s\' );', $_POST['label'][ $key ], $_POST['textdomain'] ) . "\n";
                        $required_form_fields .= $tab . $tab . "}\n\n";

                        $wp_errors .= $tab . sprintf( 'if ( empty( $args[\'%s\'] ) ) {', $_POST['name'][$key] ) . "\n";
                        $wp_errors .= $tab . $tab . sprintf( 'return new WP_Error( \'no-%s\', __( \'No %s provided.\', \'%s\' ) );', $_POST['name'][$key], $_POST['label'][$key], $_POST['textdomain'] ) . "\n";
                        $wp_errors .= $tab . "}\n";
                    }

                    $form_fields_array .= $tab . $tab . $tab . sprintf( '\'%1$s\' => $%1$s,', $_POST['name'][ $key ] ) . "\n";
                    $form_default_array .= $tab . $tab . sprintf( '\'%1$s\' => \'\',', $_POST['name'][ $key ] ) . "\n";
                }

                $form_fields_array .= $tab . $tab . ");";

                // var_dump($form_fields);
                // var_dump($required_form_fields);
                // var_dump($form_fields_array);

                $search_array = array(
                    '%heading%',
                    '%textdomain%',
                    '%nonce%',
                    '%submit_name%',
                    '%page_slug%',
                    '%singular_name%',
                    '%mysql_table%',
                    '%add_date_field%',
                    '%form_default_array%',
                    '%wp_errors%',
                    '%prefix%',
                );

                $replace_array = array(
                    $_POST['heading'],
                    $_POST['textdomain'],
                    $_POST['nonce'],
                    $_POST['submit_name'],
                    $_POST['page_slug'],
                    $_POST['singular_name'],
                    $_POST['mysql_table'],
                    $add_date_field,
                    $form_default_array,
                    $wp_errors,
                    $_POST['prefix'],
                );

                $new_code  = $edit_code = str_replace( $search_array, $replace_array, $form_code );
                $new_code  = str_replace( array( '%rows%', '%submit_new_text%', '%retrieve_row%' ), array( $new_rows, $_POST['submit_new_text'], '' ), $new_code );
                $edit_code = str_replace( array( '%rows%', '%submit_new_text%', '%retrieve_row%' ), array( $edit_rows, $_POST['submit_edit_text'], $retrieve_row ), $edit_code );

                $form_handler = str_replace( $search_array, $replace_array, $form_handler );
                $form_handler = str_replace( array( '%form_fields%', '%required_form_fields%', '%form_fields_array%' ), array( $form_fields, $required_form_fields, $form_fields_array ), $form_handler );

                $form_functions = str_replace( $search_array, $replace_array, $form_functions );
                ?>
                <p><strong>add-item.php</strong></p>
                <pre class="prettyprint"><?php echo htmlentities( $new_code ); ?></pre>

                <p><strong>edit-item.php</strong></p>
                <pre class="prettyprint"><?php echo htmlentities( $edit_code ); ?></pre>

                <p><strong>class-form-handler.php</strong></p>
                <pre class="prettyprint"><?php echo htmlentities( $form_handler ); ?></pre>

                <p><strong>functions-<?php echo $_POST['singular_name']; ?>.php</strong></p>
                <pre class="prettyprint"><?php echo htmlentities( $form_functions ); ?></pre>
            <?php } ?>

            <form class="form-horizontal" method="post">

                <div class="form-group">
                    <label class="col-md-4 control-label" for="heading">Heading Name</label>
                    <div class="col-md-4">
                        <input id="heading" name="heading" type="text" placeholder="Add New Item" class="form-control input-md" value="<?php echo isset( $_POST['heading' ] ) ? $_POST['heading'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="textdomain">Textdomain</label>
                    <div class="col-md-4">
                        <input id="textdomain" name="textdomain" type="text" placeholder="wedevs" class="form-control input-md"  value="<?php echo isset( $_POST['textdomain' ] ) ? $_POST['textdomain'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="nonce">Nonce Key</label>
                    <div class="col-md-4">
                        <input id="nonce" name="nonce" type="text" placeholder="" class="form-control input-md"  value="<?php echo isset( $_POST['nonce' ] ) ? $_POST['nonce'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit_new_text">New Submit Button Text</label>
                    <div class="col-md-4">
                        <input id="submit_new_text" name="submit_new_text" type="text" placeholder="Add New Transaction" class="form-control input-md"  value="<?php echo isset( $_POST['submit_new_text' ] ) ? $_POST['submit_new_text'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit_edit_text">New Submit Button Text</label>
                    <div class="col-md-4">
                        <input id="submit_edit_text" name="submit_edit_text" type="text" placeholder="Update Transaction" class="form-control input-md"  value="<?php echo isset( $_POST['submit_edit_text' ] ) ? $_POST['submit_edit_text'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit_name">Submit Name</label>
                    <div class="col-md-4">
                        <input id="submit_name" name="submit_name" type="text" placeholder="submit_transaction" class="form-control input-md"  value="<?php echo isset( $_POST['submit_name' ] ) ? $_POST['submit_name'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="page_slug">Page Slug</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">admin.php?page=</span>
                            <input id="page_slug" name="page_slug" type="text" placeholder="test-page" class="form-control input-md"  value="<?php echo isset( $_POST['page_slug' ] ) ? $_POST['page_slug'] : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="singular_name">Singular Name</label>
                    <div class="col-md-4">
                        <input id="singular_name" name="singular_name" type="text" placeholder="book" class="form-control input-md" value="<?php echo isset( $_POST['singular_name' ] ) ? $_POST['singular_name'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="mysql_table">MySQL Table Name</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">wp_</span>
                            <input id="mysql_table" name="mysql_table" type="text" placeholder="comments" class="form-control input-md" value="<?php echo isset( $_POST['mysql_table' ] ) ? $_POST['mysql_table'] : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="prefix">Function Prefix</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input id="prefix" name="prefix" type="text" placeholder="wd" class="form-control input-md" value="<?php echo isset( $_POST['prefix' ] ) ? $_POST['prefix'] : ''; ?>">
                            <span class="input-group-addon">_function_name</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="date_field">Date Field</label>
                    <div class="col-md-4">
                        <label class="checkbox-inline" for="date_field-1">
                            <input type="hidden" name="date_field" value="off">
                            <input type="checkbox" name="date_field" id="date_field-1" value="on" <?php echo isset( $_POST['date_field'] ) && $_POST['date_field'] == 'on' ? 'checked': ''; ?>> Add date field on insert statement
                        </label>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Input Type</th>
                            <th>Input Name</th>
                            <th>Label</th>
                            <th>Placeholder</th>
                            <th>Values</th>
                            <th>Help</th>
                            <th>Required</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ( isset( $_POST['submit'] ) ) {
                            foreach ($_POST['input_type'] as $key => $input_type) {
                                ?>
                                <tr>
                                    <td>
                                        <select name="input_type[<?php echo $key; ?>]" class="form-control input-md">
                                            <option value="text" <?php echo $input_type == 'text' ? 'selected' : ''; ?>>Text</option>
                                            <option value="number" <?php echo $input_type == 'number' ? 'selected' : ''; ?>>Number</option>
                                            <option value="textarea" <?php echo $input_type == 'textarea' ? 'selected' : ''; ?>>Text Area</option>
                                            <option value="select" <?php echo $input_type == 'select' ? 'selected' : ''; ?>>Select Dropdown</option>
                                            <option value="checkbox" <?php echo $input_type == 'checkbox' ? 'selected' : ''; ?>>Checkbox</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input id="textdomain" name="name[<?php echo $key; ?>]" type="text" placeholder="Input Name" class="form-control input-md" value="<?php echo isset( $_POST['name' ][ $key ] ) ? $_POST['name'][ $key ] : ''; ?>">
                                    </td>
                                    <td>
                                        <input id="textdomain" name="label[<?php echo $key; ?>]" type="text" placeholder="Field Label" class="form-control input-md" value="<?php echo isset( $_POST['label' ][ $key ] ) ? $_POST['label'][ $key ] : ''; ?>">
                                    </td>
                                    <td>
                                        <input id="textdomain" name="table_value[<?php echo $key; ?>]" type="text" placeholder="Book Title" class="form-control input-md" value="<?php echo isset( $_POST['table_value' ][ $key ] ) ? $_POST['table_value'][ $key ] : ''; ?>">
                                    </td>
                                    <td>
                                        <textarea name="values[<?php echo $key; ?>]" id="values" cols="20" rows="3" class="form-control input-md" placeholder="key:value pair, one per line"><?php echo isset( $_POST['values' ][ $key ] ) ? $_POST['values'][ $key ] : ''; ?></textarea>
                                    </td>
                                    <td>
                                        <input id="textdomain" name="help[<?php echo $key; ?>]" type="text" placeholder="Help Text" class="form-control input-md"value="<?php echo isset( $_POST['help' ][ $key ] ) ? $_POST['help'][ $key ] : ''; ?>">
                                    </td>
                                    <td>
                                        <label for="required"><input name="required[<?php echo $key; ?>]" type="radio" <?php echo $_POST['required'][ $key ] == 'yes' ? 'checked' : ''; ?> value="yes"> Yes</label> &nbsp;
                                        <label for="required"><input name="required[<?php echo $key; ?>]" type="radio" <?php echo $_POST['required'][ $key ] == 'no' ? 'checked' : ''; ?> value="no"> No</label>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success form-add-row">+</a>
                                        <a href="#" class="btn btn-sm btn-danger remove-row">-</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td>
                                    <select name="input_type[1]" class="form-control input-md">
                                        <option value="text">Text</option>
                                        <option value="number">Number</option>
                                        <option value="textarea">Text Area</option>
                                        <option value="select">Select Dropdown</option>
                                        <option value="checkbox">Checkbox</option>
                                    </select>
                                </td>
                                <td>
                                    <input id="textdomain" name="name[1]" type="text" placeholder="Input Name" class="form-control input-md">
                                </td>
                                <td>
                                    <input id="textdomain" name="label[1]" type="text" placeholder="Field Label" class="form-control input-md">
                                </td>
                                <td>
                                    <input id="textdomain" name="table_value[1]" type="text" placeholder="Book Title" class="form-control input-md">
                                </td>
                                <td>
                                    <textarea name="values[1]" id="values" cols="20" rows="3" class="form-control input-md" placeholder="key:value pair, one per line"></textarea>
                                </td>
                                <td>
                                    <input id="textdomain" name="help[1]" type="text" placeholder="Help Text" class="form-control input-md">
                                </td>
                                <td>
                                    <label for="required"><input name="required[1]" type="radio" value="yes"> Yes</label> &nbsp;
                                    <label for="required"><input name="required[1]" type="radio" checked value="No"> No</label>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-success form-add-row">+</a>
                                    <a href="#" class="btn btn-sm btn-danger remove-row">-</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit"></label>
                    <div class="col-md-4">
                        <button id="submit" name="submit" class="btn btn-primary">Generate Code</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>