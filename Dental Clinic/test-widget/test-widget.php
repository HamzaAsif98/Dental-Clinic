<?php
/**
 * Plugin Name: My Test Widget
 * Plugin URI: http://ccoc.ie/
 * Description: Test Widget
 * Version: 1.0
 * Author: Roy O'Sullivan
 * Author URI: http://ccoc.ie/
 */

 //Reference: http://code.tutsplus.com/tutorials/coding-and-registering-your-wordpress-widget--cms-22404

 class My_Test_Widget extends WP_Widget {
     
    function __construct() {
        parent::__construct(
        // base ID of the widget
        'my_test_widget',
        // name of the widget
        __('Test Widget', 'test'),
        // widget options
        array (
            'description' => __( 'A test widget to show a specified amount of posts', 'test' )
        )  
        );
    }
     
    function form( $instance ) {
        $defaults = array(
        'items' => '5'
        );
        if(isset($instance[ 'items' ])){
            $items = $instance[ 'items' ];
        }
        else{
            $items = 5;
        }
        // markup for form ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'items' ); ?>">Number of Items:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>" value="<?php echo esc_attr( $items ); ?>">
        </p>
        <?php
    }
     
    function update( $new_instance, $old_instance ) {     
        $instance = $old_instance;
        $instance[ 'items' ] = strip_tags( $new_instance[ 'items' ] );
        return $instance;
    }
     
    function widget( $args, $instance ) {
        global $wpdb;
        $count = $instance[ 'items' ];
        if($count == '')
            $count = 5;
        $results = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='post' ORDER BY post_title LIMIT $count");
        echo "<b>Posts Widget:</b><ul>";
	    foreach($results as $result){
            echo "<li><a href=\"$result->guid\">$result->post_title</a></li>";
	    }
	    echo "</ul>";
    }
     
}

function register_my_test_widget() {
    register_widget( 'My_Test_Widget' );
}

add_action( 'widgets_init', 'register_my_test_widget' );
