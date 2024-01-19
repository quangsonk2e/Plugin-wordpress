<?php
/*
 * Plugin Name: Slider image
 * Plugin URI: https://quangson.com
 * Description: Làm thư viện ảnh, album ảnh
 * Author: Quang Sơn
 * Author URI: https://quangson.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.0.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 */
define('Slider_URI',plugin_dir_url(__FILE__));
 define('Slider_PATH',plugin_dir_path(__FILE__));

//  add_action('admin_menu','pdev_create_menu');

//  function pdev_create_menu(){
//     add_menu_page('Page title Sider Image','Sider Image 1111','manage_options','slider-image111','add_menu_test','dashicons-smiley',100);
//     add_menu_page( 'PDEV Settings Page', 'PDEV Settings','manage_options', 'pdev-options', 'pdev_settings_page','dashicons-smiley', 99 );
//     update_option('test',array(
//         'color' => 'red',
//         'fontsize' => '120%',
//         'border' => '2px solid red'
//         ));
//  }

function add_your_custom_posttype_metaboxes() {
    //you have to set the above function as the the metabox callback in your CPT register
    add_meta_box(
        'upload_image',
        'Upload Image 11111',
        'upload_image',
        'post',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'add_your_custom_posttype_metaboxes');
function upload_image( $post_object ) {
    global $post;

    //Get WordPress' media upload URL
    $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
    
    // See if there's a media id already saved as post meta
    $your_img_id = get_post_meta( $post->ID, '_your_img_id', true );
    
    // Get the image src
    $your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );
    
    // For convenience, see if the array is valid
    $you_have_img = is_array( $your_img_src );
    ?>
    
    <!-- Your image container, which can be manipulated with js -->
    <div class="custom-img-container">
        <?php if ( $you_have_img ) : ?>
            <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;" />
        <?php endif; ?>
    </div>
    
    <!-- Your add & remove image links -->
    <p class="hide-if-no-js">
        <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
           href="<?php echo $upload_link ?>" id="upload-custom-img">
            <?php _e('Set custom image') ?>
        </a>
        <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
          href="#">
            <?php _e('Remove this image') ?>
        </a>
    </p>    
    <!-- A hidden input to set and post the chosen image id -->
    <input class="custom-img-id" name="custom-img-id" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>" />
<?php
}
function upload_image_savedata( $post_id, $post ) {
    if( !current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
    if( !isset( $_POST['upload_image_fields'] ) || !wp_verify_nonce( $_POST['upload_image_fields'], basename(__FILE__) ) ) {
        return $post_id;
    }
    $uploaded_image_meta['uploaded_img']        = esc_textarea( $_POST['uploaded_img'] );
    
    foreach( $uploaded_image_meta as $key => $value ) :
        if( 'revision' === $post->post_type ) {
            return;
        }
        if( get_post_meta( $post_id, $key, false ) ) {
            update_post_meta( $post_id, $key, $value );
        } else {
            add_post_meta( $post_id, $key, $value);
        }
        if( !$value ) {
            delete_post_meta( $post_id, $key );
        }
    endforeach;
    return $post_id;
}
add_action( 'save_post', 'upload_image_savedata', 1, 2 );


function your_custom_posttype_admin_scripts() {
    global $post_type;
    if( 'post' == $post_type ) {
        wp_enqueue_media();
        //you should probably define your plugin version somewhere so you can use it instead of manually changing the 1.0 below every time you update
        wp_enqueue_script( 'cpt-admin-script', plugins_url( 'js/your-js-file.js', __DIR__ ), array( 'jquery' ), '1.0', true );
    }
}
add_action( 'admin_enqueue_scripts', 'your_custom_posttype_admin_scripts' );



function create_gallery_post_type() { 
    register_post_type( 'gallery', 
        array( 
            'labels' => array( 
                'name' => __( 'Galleries1111' ), 
                'singular_name' => __( 'them Gallery' ) 
            ), 
            'public' => true, 
            'has_archive' => true, 
            'supports' => array( 'title', 'editor' ), 
            // 'rewrite' => array( 'slug' => 'gallery' ) 
        ) 
    ); 
} 
add_action( 'init', 'create_gallery_post_type' ); 


function create_videoslide_post_type() { 
    register_post_type( 'addvideo', 
        array( 
            'labels' => array( 
                'name' => __( 'thêm Video' ), 
                'singular_name' => __( 'them Video' ) 
            ), 
            'public' => true, 
            'has_archive' => true, 
            'supports' => array( 'title', 'editor' ), 
            'rewrite' => array( 'slug' => 'addvideo' ) 
        ) 
    ); 
} 
add_action( 'init', 'create_videoslide_post_type' );

function create_gallery_taxonomy() { 
    register_taxonomy( 
        'gallery_category', 
        'gallery', 
        array( 
            'label' => __( 'Gallery Categories' ), 
            'rewrite' => array( 'slug' => 'gallery-category' ), 
            'hierarchical' => true 
        ) 
    ); 
 } 
 add_action( 'init', 'create_gallery_taxonomy' ); 
 