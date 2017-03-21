<?php
/**
 * Created by PhpStorm.
 * User: pdutie94
 * Date: 16/03/2017
 * Time: 11:38 PM
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
require_once(ABSPATH . '/wp-admin/includes/template.php');
class Tp_Wps_Table extends WP_List_Table {
    public function __construct()
    {
        parent::__construct( [
            'singular' => __( 'Slider', 'tp-wps' ), //singular name of the listed records
            'plural'   => __( 'Sliders', 'tp-wps' ), //plural name of the listed records
            'ajax'     => true //should this table support ajax?
        ] );
    }

    public static function get_sliders($per_page = 5, $page_number = 1)
    {
        global $wpdb;
        $sql = "SELECT * FROM {$wpdb->prefix}tpwps";
        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }
        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        return $result;
    }

    public static function delete_slider($id)
    {
        global $wpdb;
        $wpdb->delete(
            "{$wpdb->prefix}tpwps",
            [ 'id' => $id ],
            [ '%d' ]
        );
    }

    public static function record_count()
    {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}tpwps";

        return $wpdb->get_var( $sql );
    }

    public function no_items() {
        _e( 'No sliders avaliable.', 'tp-wps' );
    }

    function column_name( $item ) {

        // create a nonce
        $delete_nonce = wp_create_nonce( 'tp-wps_delete_slider' );

        $title = '<strong>' . $item['name'] . '</strong>';

        $actions = [
            'delete' => sprintf( '<a href="?page=%s&action=%s&slider=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        ];

        return $title . $this->row_actions( $actions );
    }


    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'title':
                return $item[ $column_name ];
            case 'shortcode':
                return $item[ $column_name ];
            case 'status':
                if(1 == $item[ $column_name ])
                {
                    return sprintf( '<img src="%s">',TP_OPTION_PLUGIN_URL . 'assets/icons/publish.png');
                }
                else
                {
                    return sprintf( '<img src="%s">',TP_OPTION_PLUGIN_URL . 'assets/icons/unpublish.png');
                }
            case 'id':
                return $item[ $column_name ];				
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = [
            'cb'      => '<input type="checkbox" />',
            'title'    => __( 'Slider Title', 'tp-wps' ),
            'shortcode' => __( 'Shortcode', 'tp-wps' ),
            'status' => __( 'Publish', 'tp-wps' ),
            'id'    => __( 'ID', 'tp-wps' )
        ];

        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'title' => array( 'title', true ),
            'id' => array( 'id', false ),
            'status' => array( 'status', false )
        );

        return $sortable_columns;
    }

    function column_title($item) {
        $delete_nonce = wp_create_nonce( 'tp-wps_delete_slider' );
        $actions = array(
            'edit'      => sprintf('<a href="?page=tp-wps-edit&action=%s&id=%s">Edit</a>','edit',$item['id']),
            'delete' => sprintf( '<a href="?page=%s&action=%s&slider=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        );

        return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            'bulk-delete' => 'Delete'
        ];

        return $actions;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {
        $this->_column_headers = array(
            $this->get_columns(),		// columns
            array(),			// hidden
            $this->get_sortable_columns(),	// sortable
        );

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( 'sliders_per_page', 5 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( [
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ] );


        $this->items = self::get_sliders( $per_page, $current_page );
    }

    public function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, 'tp-wps_delete_slider' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::delete_slider( absint( $_GET['slider'] ) );

                wp_redirect( esc_url( add_query_arg() ) );
                exit;
            }

        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
            || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
        ) {

            $delete_ids = esc_sql( $_POST['bulk-delete'] );

            // loop over the array of record IDs and delete them
            $deleted = 0;
            foreach ( $delete_ids as $id ) {
                self::delete_slider( $id );
                $deleted++;
            }
            //$sendback = add_query_arg( array('deleted' => $deleted, 'ids' => join(',', $delete_ids) ), $sendback );

            wp_redirect( add_query_arg(array('deleted' => $deleted) )  );
            exit;
        }
    }

}