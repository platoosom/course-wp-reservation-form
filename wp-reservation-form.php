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
    }


    public function register_shortcode()
    {
        add_shortcode('reservation-form', array($this, 'reservation_form_content'));
    }


    public function reservation_form_content()
    {
        ob_start();
        ?>
            <form class="uk-form-stacked" method="post" action="">

                <div class="uk-margin">
                    <label class="uk-form-label" for="fullname">Fullname</label>
                    <div class="uk-form-controls">
                        <input name="fullname" class="uk-input" id="fullname" type="text" placeholder="Fullname">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="phone">Phone</label>
                    <div class="uk-form-controls">
                        <input name="phone" class="uk-input" id="phone" type="text" placeholder="Phone">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="date">Date</label>
                    <div class="uk-form-controls">
                        <input name="date" class="uk-input" id="date" type="date" placeholder="Date">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="detail">Detail</label>
                    <div class="uk-form-controls">
                        <textarea  name="detail" class="uk-textarea" id="detail" placeholder="Detail"></textarea>
                    </div>
                </div>
            </form>

        <?php 
        $content = ob_get_clean();
        return $content;
    }

 }

 new WP_Reservation_Form();
 
 