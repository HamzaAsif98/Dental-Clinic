<?php
/**
 * Plugin Name: My Test Plugin
 * Plugin URI: http://ccoc.ie/
 * Description: Test Plugin
 * Version: 1.3
 * Author: Roy O'Sullivan
 * Author URI: http://ccoc.ie/
 */

 add_action( 'wp_head', 'test_plugin' );

function test_plugin() {
    global $wpdb;

    echo "
	<style type='text/css'>
	#test-plugin {
        position: absolute;
        left: 30px;
        top: 100px;
        width: 400px;
		padding: 10px;
		margin: 0;
		font-size: 10px;
        z-index: 10;
        border-style: solid;
        background-color: lightblue;
	}
	</style>
	";
    echo "
    <script type=\"text/javascript\">
    function ShowHide() {
        var item = document.getElementById('test-plugin-list');
        var arrow = document.getElementById('test-plugin-arrow');
        if(item != null){
            if (item.style.display == 'none') {
                item.style.display = 'block';
                if(arrow != null){
                    arrow.text= '(Hide)';
                }
            }
            else {
                item.style.display = 'none';
                if(arrow != null){
                    arrow.text= '(Show)';
                }
            }
        }
    }
    </script>
    ";

    $count = $wpdb->get_var("SELECT COUNT(ID) FROM wp_posts WHERE post_type='post'", 0, 0);
	if($count == '')
          echo "<div id='test-plugin'>There are no posts in this wordpress site</div>";
    else
    {
              echo "<div id='test-plugin'>There are $count posts in this wordpress site:";
              echo "<a href='javascript:ShowHide()' id='test-plugin-arrow'>(Show)</a>"; 
              $results = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='post' ORDER BY post_title");
              echo "<div id='test-plugin-list' style='display:none'><ul>";
              foreach($results as $result){
        echo "<li><a href=\"$result->guid\">$result->post_title</a></li>";
              }
              echo "</ul></div></div>";
    }
}