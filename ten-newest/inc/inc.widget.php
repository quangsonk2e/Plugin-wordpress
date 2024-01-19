<?php
class Random_Post extends WP_Widget {
    function __construct() {
        parent::__construct(
            'random_post',
            '10 bài viết ngẫu nhiên',
            array( 'description'  =>  'Widget 10 bài viết ngẫu nhiên' )
        );
    }


    function form( $instance ) {


        $default = array(
            'title' => 'Tiêu đề widget',
            'post_number' => 10
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $post_number = esc_attr($instance['post_number']);


        echo '<p>Nhập tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Số lượng bài viết hiển thị <input type="number" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" placeholder="'.$post_number.'" max="30" /></p>';


    }


    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_number'] = strip_tags($new_instance['post_number']);
        return $instance;
    }


    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] );
        $post_number = $instance['post_number'];


        echo $before_widget;
        echo $before_title.$title.$after_title;
        $random_query = new WP_Query('posts_per_page='.$post_number.'&orderby=rand');


        if ($random_query->have_posts()):
            echo "<ol>";
            while( $random_query->have_posts() ) :
                $random_query->the_post(); ?>


                <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>


            <?php endwhile;
            echo "</ol>";
        endif;
        echo $after_widget;


    }


}


add_action( 'widgets_init', function(){
    register_widget('Random_Post');
} );
