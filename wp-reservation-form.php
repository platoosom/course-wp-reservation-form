<?php 

/**
 * Plugin Name:     WP Reservation Form
 * Plugin URI:      http://boostpress.com         
 * Description:     Using for reservation fom
 * Version:         0.1            
 * Requires at least: 6.4.1 
 * Requires PHP:    8.0 
 * Author:          Watcharamet Chitsanukup Srinethiroth  
 * Author URI:      http://select2web.com
 */

 class WP_Reservation_Form 
 {
    public function __construct()
    {
        // Register shortcode
        add_action('init', array($this, 'register_shortcode'));

        // Register stylesheet
        add_action('init', array($this, 'register_stylesheet'));

        // Register javascript
        add_action('init', array($this, 'register_js'));

        // AJAX
        add_action('wp_ajax_add_reservation', array($this, 'add_reservation'));
        add_action('wp_ajax_nopriv_add_reservation', array($this, 'add_reservation'));

        // Register custom posttype
        add_action( 'init', array($this, 'register_reservation_posttype'), 0 );

        // Send html email
        add_filter( 'wp_mail_content_type', array($this, 'mail_content_type') );

    }


    public function mail_content_type() {
        return 'text/html';
    }


    // Register Custom Post Type
    public function register_reservation_posttype() 
    {

        $labels = array(
            'name'                  => _x( 'Reservations', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Reservation', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Reservation', 'text_domain' ),
            'name_admin_bar'        => __( 'Reservation', 'text_domain' ),
            'archives'              => __( 'Item Archives', 'text_domain' ),
            'attributes'            => __( 'Item Attributes', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
            'all_items'             => __( 'All Items', 'text_domain' ),
            'add_new_item'          => __( 'Add New Item', 'text_domain' ),
            'add_new'               => __( 'Add New', 'text_domain' ),
            'new_item'              => __( 'New Item', 'text_domain' ),
            'edit_item'             => __( 'Edit Item', 'text_domain' ),
            'upcheckin_item'           => __( 'Upcheckin Item', 'text_domain' ),
            'view_item'             => __( 'View Item', 'text_domain' ),
            'view_items'            => __( 'View Items', 'text_domain' ),
            'search_items'          => __( 'Search Item', 'text_domain' ),
            'not_found'             => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
            'featured_image'        => __( 'Featured Image', 'text_domain' ),
            'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
            'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
            'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
            'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
            'items_list'            => __( 'Items list', 'text_domain' ),
            'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
            'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
        );
        $args = array(
            'label'                 => __( 'Reservation', 'text_domain' ),
            'description'           => __( 'Post Type Description', 'text_domain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'custom-fields' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'reservation', $args );

    }


    public function add_reservation()
    {
        if(wp_verify_nonce($_POST['_wpnonce'], 'add-reservation')){
    
            $params = array(
                'post_title' => sanitize_text_field( $_POST['fullname'] ),
                'post_content' => sanitize_text_field($_POST['note']),
                'post_type' => 'reservation',
                'post_status' => 'publish',
            );
            $ID = wp_insert_post($params);
    
            add_post_meta($ID, 'phone', sanitize_text_field($_POST['phone']));
            add_post_meta($ID, 'email', sanitize_text_field($_POST['email']));
            add_post_meta($ID, 'checkin', sanitize_text_field($_POST['checkin']));
            add_post_meta($ID, 'checkout', sanitize_text_field($_POST['checkout']));
            add_post_meta($ID, 'adults', sanitize_text_field($_POST['adults']));
            add_post_meta($ID, 'children', sanitize_text_field($_POST['children']));
            add_post_meta($ID, 'roomtype', sanitize_text_field($_POST['roomtype']));
            add_post_meta($ID, 'note', sanitize_text_field($_POST['note']));
            
            ob_start();
            ?>

            <p>ลูกค้าจองห้องพัก</p>
            <p>ชื่อ: <?php echo sanitize_text_field( $_POST['fullname'] ); ?></p>
            <p>เบอร์โทร: <?php echo sanitize_text_field( $_POST['phone'] ); ?></p>
            <p>อีเมล์: <?php echo sanitize_text_field( $_POST['email'] ); ?></p>
            <p>วัน: <?php echo sanitize_text_field( $_POST['checkin'] ); ?> - <?php echo sanitize_text_field( $_POST['checkout'] ); ?></p>
            <p>ผู้ใหญ่: <?php echo sanitize_text_field( $_POST['adults'] ); ?></p>
            <p>เด็ก: <?php echo sanitize_text_field( $_POST['children'] ); ?></p>
            <p>ชนิดห้อง: <?php echo sanitize_text_field( $_POST['roomtype'] ); ?></p>
            <p>รายละเอียด: <?php echo sanitize_text_field( $_POST['note'] ); ?></p>
            
            <?php 
            $content = ob_get_clean();

            wp_mail('platoosom@gmail.com, teerawat@gmail.com', 'New Reservation', $content);
    
            wp_send_json_success( 'Data has been saved into database.' );

        }
    }


    public function register_stylesheet()
    {
        wp_enqueue_style('uikit', plugin_dir_url(__FILE__).'uikit-3.17.11/css/uikit.min.css', array(), '3.17.11');
    }


    public function register_js()
    {
        wp_enqueue_script('validation', plugin_dir_url(__FILE__).'js/validation.js', array('jquery'), '0.1');
        wp_localize_script('validation', 'Reservation', array(
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
    }


    public function register_shortcode()
    {
        add_shortcode('reservation-form', array($this, 'reservation_form_content'));
    }


    public function reservation_form_content()
    {
        ob_start();
        ?>
            <form class="uk-grid uk-form-stacked" uk-grid method="post" action="">
                <?php wp_nonce_field('add-reservation');?>
                <div class="uk-margin uk-width-1-1">
                    <label class="uk-form-label" for="fullname">Fullname</label>
                    <div class="uk-form-controls">
                        <input name="fullname" class="uk-input" id="fullname" type="text" placeholder="Fullname">
                    </div>
                </div>

                <div class="uk-margin uk-width-1-1">
                    <label class="uk-form-label" for="email">Email</label>
                    <div class="uk-form-controls">
                        <input name="email" class="uk-input" id="email" type="text" placeholder="Email">
                    </div>
                </div>

                <div class="uk-margin uk-width-1-1">
                    <label class="uk-form-label" for="phone">Phone</label>
                    <div class="uk-form-controls">
                        <input name="phone" class="uk-input" id="phone" type="text" placeholder="Phone">
                    </div>
                </div>

                <div class="uk-margin uk-width-1-2@s">
                    <label class="uk-form-label" for="checkin">Checkin</label>
                    <div class="uk-form-controls">
                        <input name="checkin" class="uk-input" id="checkin" type="date" placeholder="Checkin">
                    </div>
                </div>
                <div class="uk-margin uk-width-1-2@s">
                    <label class="uk-form-label" for="checkout">Checkout</label>
                    <div class="uk-form-controls">
                        <input name="checkout" class="uk-input" id="checkout" type="date" placeholder="Checkout">
                    </div>
                </div>
                
                <div class="uk-margin uk-width-1-2@s">
                    <label class="uk-form-label" for="adults">Adults</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="adults" name="adults"><option value="0">0</option><option value="1">1</option><option selected="" value="2">2</option></select>
                    </div>
                </div>
                <div class="uk-margin uk-width-1-2@s">
                    <label class="uk-form-label" for="children">Children</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="children" name="children"><option selected="" value="0">0</option><option value="1">1</option><option value="2">2</option></select>
                    </div>
                </div>

                <div class="uk-margin uk-width-1-1">
                    <label class="uk-form-label" for="roomtype">Room Type</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="roomtype" name="roomtype">
                            <option selected="" value="">Select Room Type</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Superior">Superior</option>
                            <option value="Family Room">Family Room</option>
                        </select>
                    </div>
                </div>

                <div class="uk-margin uk-width-1-1">
                    <label class="uk-form-label" for="note">Note</label>
                    <div class="uk-form-controls">
                        <textarea  name="note" rows="8" class="uk-textarea" id="note" placeholder="Note"></textarea>
                    </div>
                </div>

                <div class="uk-margin uk-width-1-1">
                    <div class="uk-form-controls">
                        <input type="submit" class="uk-button uk-button-primary" name="submit" value="Submit" />
                    </div>
                </div>
                

            </form>

        <?php 
        $content = ob_get_clean();
        return $content;
    }

 }

 new WP_Reservation_Form();
 
 