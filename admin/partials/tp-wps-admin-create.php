<?php
/**
 * Created by PhpStorm.
 * User: pdutie94
 * Date: 16/03/2017
 * Time: 10:46 PM
 */
?>

<?php
$this->plugin_name = 'tp-wps';
$this->version = '1.0.0';
$obj = new Tp_Wps_Admin($this->plugin_name, $this->version = '1.0.0');
global $wpdb;
if (isset($_POST['tpwps-save-settings']))
{
    $table_name = $wpdb->prefix . "tpwps";

    $product_show = $_POST['tpwps_product_show'];
    $auto_play_speed = $_POST['tpwps_autoplay_speed'];
    $slider_title = $_POST['tpwps_title'];
    $cat_id = $_POST['tpwps_woo_cat'];
    $product_per_row = $_POST['tpwps_product_per_show'];
    $order_by = $_POST['tpwps_order_by'];
    $order_type = $_POST['tpwps_order_type'];
    $shortcode = $_POST['tpwps_shortcode'];
    //auto play
    if($_POST['tpwps_autoplay'] != 1)
    {
        $auto_play = 0;
    }
    else
    {
        $auto_play = $_POST['tpwps_autoplay'];
    }
    // Loop
    if($_POST['tpwps_loop'] != 1)
    {
        $loop = 0;
    }
    else
    {
        $loop = $_POST['tpwps_loop'];
    }
    // Show Nav
    if($_POST['tpwps_nav'] != 1)
    {
        $show_nav = 0;
    }
    else
    {
        $show_nav = $_POST['tpwps_nav'];
    }
    // Show Dots
    if($_POST['tpwps_dot'] != 1)
    {
        $show_dot = 0;
    }
    else
    {
        $show_dot = $_POST['tpwps_dot'];
    }
    // Rewind
    if($_POST['tpwps_rewind'] != 1)
    {
        $rewind = 0;
    }
    else
    {
        $rewind = $_POST['tpwps_rewind'];
    }
    // Publish
    if($_POST['tpwps_publish'] != 1)
    {
        $publish = 0;
    }
    else
    {
        $publish = $_POST['tpwps_publish'];
    }
    //Insert data into Database
    $wpdb->insert(
        $table_name,
        array(
            'title' => $slider_title,
            'product_show' => $product_show,
            'auto_play' => $auto_play,
            'auto_play_speed' => $auto_play_speed,
            'loop' => $loop,
            'show_nav' => $show_nav,
            'show_dot' => $show_dot,
            'rewind' => $rewind,
            'cat_id' => $cat_id,
            'product_per_row' => $product_per_row,
            'order_by' => $order_by,
            'order_type' => $order_type,
            'shortcode' => $shortcode,
            'status' => $publish,
            'created_at' => current_time( 'mysql' ),
            'updated_at' => current_time( 'mysql' )
        )
    );
    $message.="Create successful slider.";
}

?>
<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <?php if (isset($message)): ?><div class="updated below-h2" id="message"><p><strong><?php echo $message ?></strong></p></div><?php endif; ?>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="tpwps_create_form" enctype="multipart/form-data" >
        <h2>General Settings</h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">Product to show</th>
                <td>
                    <label for="tpwps_product_show">
                        <input name="tpwps_product_show" type="number" id="tpwps_product_show" class="small-text" value="15">
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">Auto Play</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Auto Play</span></legend>
                        <label for="tpwps_autoplay">
                            <input name="tpwps_autoplay" type="checkbox" id="tpwps_autopay" value="1">
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Auto Play Speed</th>
                <td>
                    <label for="tpwps_autoplay_speed">
                        <input name="tpwps_autoplay_speed" type="number" id="tpwps_autoplay_speed" class="small-text" value="500">
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">Loop</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Loop</span></legend>
                        <label for="tpwps_loop">
                            <input name="tpwps_loop" type="checkbox" id="tpwps_loop" value="1">
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Show Navigation</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Show Navigation</span></legend>
                        <label for="tpwps_nav">
                            <input name="tpwps_nav" type="checkbox" id="tpwps_nav" value="1">
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Show Dots Navigation</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Show Dots Navigation</span></legend>
                        <label for="tpwps_dot">
                            <input name="tpwps_dot" type="checkbox" id="tpwps_dot" value="1">
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Rewind</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Rewind</span></legend>
                        <label for="tpwps_rewind">
                            <input name="tpwps_rewind" type="checkbox" id="tpwps_rewind" value="1">
                            Go backwards when the boundary has reached
                        </label>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>
        <h2>Content Settings</h2>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">Title</th>
                <td>
                    <label for="tpwps_title">
                        <input name="tpwps_title" type="text" id="tpwps_title" value="Product Carousel" placeholder="Product Carousel">
                        <p class="description" id="tpwps_title_description">if the vacant title, the title will not be displayed.</p>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">Choose Product Category</th>
                <td>
                    <select name="tpwps_woo_cat" id="tpwps_woo_cat">
                        <?php echo $obj->get_woo_cats(); ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row">Product per row</th>
                <td>
                    <label for="tpwps_product_per_show">
                        <input name="tpwps_product_per_show" type="number" id="tpwps_product_per_show" class="small-text" value="4">
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">Order By</th>
                <td>
                    <select name="tpwps_order_by" id="tpwps_order_by">
                        <option value="name">Name</option>
                        <option value="price">Price</option>
                        <option value="date">Date</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Order Type</th>
                <td>
                    <select name="tpwps_order_type" id="tpwps_order_type">
                        <option value="asc">ASC</option>
                        <option value="desc">DESC</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">Publish</th>
                <td>
                    <legend class="screen-reader-text"><span>Publish</span></legend>
                    <label for="tpwps_publish">
                        <input name="tpwps_publish" type="checkbox" id="tpwps_publish" value="1" checked>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">Shortcode</th>
                <td>
                    <?php
                    $last_id = $obj->get_last_id();
                    $shortcode_id = $last_id->id + 1;
                    ?>
                    <input type="text" name="tpwps_shortcode" readonly value="[tpwps_slider id=<?php echo $shortcode_id ?>]">
                </td>
            </tr>

            </tbody>
        </table>
        <?php submit_button( 'Save Settings', 'primary', 'tpwps-save-settings' );
        ?>
        <input type="reset" name="tpwps-reset" class="button-secondary" value="Reset Defaults" onclick="return confirm('If you continue with this action, you will reset all options in this page.\nAre you sure?');">
    </form>
</div>