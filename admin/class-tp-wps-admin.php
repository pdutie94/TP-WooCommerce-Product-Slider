<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/pdutie94
 * @since      1.0.0
 *
 * @package    Tp_Wps
 * @subpackage Tp_Wps/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tp_Wps
 * @subpackage Tp_Wps/admin
 * @author     TienPham <pdutie94@gmail.com>
 */
require_once(plugin_dir_path(__DIR__ ) . 'includes/class-tp-wps-table.php');
class Tp_Wps_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


	}

	public function add_plugin_admin_menu() {
        add_menu_page( 'Sliders List', 'TP WooCommerce Product Slider', 'manage_options', $this->plugin_name, array($this, 'tp_wps_page_handler'), '', 64);
        add_submenu_page($this->plugin_name, 'Create New Slider', 'New Slider', 'manage_options', $this->plugin_name.'-create', array($this, 'display_plugin_create_page'));
	}
    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }
    public function display_plugin_list_page() {
        include_once( 'partials/tp-wps-admin-display.php' );
    }

    public function display_plugin_create_page() {
        include_once( 'partials/tp-wps-admin-create.php' );
    }

    function tp_wps_page_handler()
    {
        global $wpdb;

        $table = new Tp_Wps_Table();
        $table->prepare_items();

        $message = '';

        if ('delete' === $table->current_action()) {
            echo $table->current_action();
            exit();
            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'tp-wps'), count($_REQUEST['id'])) . '</p></div>';
        }
        ?>
        <div class="wrap">

            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2>
                <?php _e('Sliders List', 'tp-wps')?>
                <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=tp-wps-create');?>"><?php _e('Add new', 'tp-wps')?></a>
            </h2>
            <?php echo $message; ?>

            <form id="sliers-table" method="POST">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
				<?php $table->search_box('Search', 'search_id'); ?>
                <?php $table->display() ?>
            </form>

        </div>
        <?php
    }

    public function bulk_action_admin_notice() {

        if ( ! empty( $_GET['deleted'] ) ) {
            $sliders_count = intval( $_GET['deleted'] );
            if($sliders_count == 1) {
                $message = sprintf( __( 'Slider deleted.', 'tp-wps'));
            } else {
                $message = sprintf( __('%s sliders deleted.','tp-wps'), $sliders_count );
            }
            echo "<div class='notice notice-success is-dismissible'><p><strong>{$message}</strong></p></div>";
        }
    }

    public function get_last_id()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "tpwps";
        $query = 'SELECT id FROM '.$table_name.' ORDER BY id DESC LIMIT 0,1';
        $last_id = $wpdb->get_row($query);
        return $last_id;
    }

    public function get_woo_cats($parent_id = 0,$char = '',$c_id = null)
    {
        $taxonomy     = 'product_cat';
        $orderby      = 'name';
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no
        $title        = '';
        $empty        = 0;

        $args = array(
            'taxonomy'     => $taxonomy,
            'parent' => $parent_id,
            'child_of'      => $parent_id,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty
        );

        $all_categories = get_categories( $args );

        foreach ($all_categories as $cat) {
            $selected = '';
            if($cat->category_parent == $parent_id) {
                $category_id = $cat->term_id;
                if ($category_id == $c_id){
                    $selected = 'selected';
                }
                ?>
                <option value="<?php echo $category_id ?>" <?php echo $selected ?>><?php echo $char ?> #<?php echo $category_id .' '.$cat->name?></option>
                <?php self::get_woo_cats($category_id, $char.' —',$c_id);
            }
        }
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tp_Wps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tp_Wps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tp-wps-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tp_Wps_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tp_Wps_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tp-wps-admin.js', array( 'jquery' ), $this->version, false );

	}

}
