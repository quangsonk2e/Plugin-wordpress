<?php
/*
 * Plugin Name:       10 News top
 * Description:      10 bài viết mới nhất.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

 define('PLUGIN_URI',plugin_dir_url(__FILE__));
 define('PLUGIN_PATH',plugin_dir_path(__FILE__));
 require_once(PLUGIN_PATH.'inc/inc.widget.php');


function create_shortcode_randompost() {
	$random_query = new WP_Query(array(
		'posts_per_page' => 10,
		'orderby' => 'rand'
	));


	ob_start();
	if ( $random_query->have_posts() ) :
		"<ol>";
		while ( $random_query->have_posts() ) :
			$random_query->the_post();?>


				<li><a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a></li>


		<?php endwhile;
		"</ol>";
	endif;
	$list_post = ob_get_contents(); //Lấy toàn bộ nội dung phía trên bỏ vào biến $list_post để return


	ob_end_clean();


	return $list_post;
}
add_shortcode('random_post', 'create_shortcode_randompost');