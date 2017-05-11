<?php
/**
 * Created by PhpStorm.
 * User: camvt
 * Date: 11/05/2017
 * Time: 14:07
 */

class custom_nav_menu extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='hover_submenu'></div><ul>\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

function remove_menus(){
    //remove_menu_page( 'upload.php' );                 //Media
    //remove_menu_page( 'edit-comments.php' );          //Comments
    //remove_menu_page( 'themes.php' );                 //Appearance
    //remove_menu_page( 'plugins.php' );                //Plugins
    //remove_menu_page( 'users.php' );                  //Users
    //remove_menu_page( 'tools.php' );                  //Tools
    //remove_menu_page( 'options-general.php' );        //Settings
}

add_action( 'admin_menu', 'remove_menus' );

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/library/admin/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/library/admin/ReduxCore/framework.php' );
}

if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/library/option-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/library/option-config.php' );
}

register_nav_menus( array(
    'primary' => __( 'Main Menu' ),
    'secondary' => __('Secondary Menu'),
    'third' => __('Introduction Menu'),
    'four' => __('Warranty Menu'),
    'footer_menu_column_1' => __('Footer menu column 1'),
    'footer_menu_column_2' => __('Footer menu column 2' ),
    'footer_menu_column_3' => __('Footer menu column 3' ),
    'footer_menu_column_4' => __('Footer menu column 4'),
    'footer_menu_column_5' => __('Footer menu column 5'),
) );
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}
function new_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
    if( in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}
if ( function_exists( 'register_sidebar' ) ) {
    register_sidebar( array(
        'name'          => __( 'Contact' ),
        'id'            => 'contact',
        'description'   => __( 'Contact' ),
        'before_title'  => '',
        'after_title'   => '',
        'before_widget' => '',
        'after_widget'  => '',
    ) );
}
if ( function_exists( 'register_sidebar' ) ) {
    register_sidebar( array(
        'name'          => __( 'Footer column 1' ),
        'id'            => 'footer-column-1',
        'description'   => __( 'Footer column 1' ),
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</h3>',
        'before_widget' => '',
        'after_widget'  => '',
    ) );
}
if ( function_exists( 'register_sidebar' ) ) {
    register_sidebar( array(
        'name'          => __( 'Footer column 2' ),
        'id'            => 'footer-column-2',
        'description'   => __( 'Footer column 2' ),
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</h3>',
        'before_widget' => '',
        'after_widget'  => '',
    ) );
}
if ( function_exists( 'register_sidebar' ) ) {
    register_sidebar( array(
        'name'          => __( 'Footer column 3' ),
        'id'            => 'footer-column-3',
        'description'   => __( 'Footer column 3' ),
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</h3>',
        'before_widget' => '',
        'after_widget'  => '',
    ) );
}
if ( function_exists( 'register_sidebar' ) ) {
    register_sidebar( array(
        'name'          => __( 'Footer column 4' ),
        'id'            => 'footer-column-4',
        'description'   => __( 'Footer column 4' ),
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</h3>',
        'before_widget' => '',
        'after_widget'  => '',
    ) );
}
if ( function_exists( 'register_sidebar' ) ) {
    register_sidebar( array(
        'name'          => __( 'Footer column 5' ),
        'id'            => 'footer-column-5',
        'description'   => __( 'Footer column 5' ),
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</h3>',
        'before_widget' => '',
        'after_widget'  => '',
    ) );
}
function title($limit) {
    $title = explode(' ', get_the_title(), $limit);
    if (count($title)>=$limit) {
        array_pop($title);
        $title = implode(" ",$title).'...';
    } else {
        $title = implode(" ",$title);
    }
    $title = preg_replace('`\[[^\]]*\]`','',$title);
    return $title;
}
function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}
function content($limit) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    } else {
        $content = implode(" ",$content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}
function SearchFilter($query) {
    if ($query->is_search) {
        if(isset($_GET['post_type'])) {
            $type = $_GET['post_type'];
            if($type == 'check-imei') {
                $query->set('post_type',array('check-imei'));
            }
        } else {
            $query->set('post_type', array('post', 'product'));
        }

    }

    return $query;
}

//add_filter('pre_get_posts','SearchFilter');
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/*
* Creating a function to create our CPT
*/
function custom_post_type() {
    // Set UI labels for Custom Post Type Jobs
    $labels = array(
        'name'                => _x( 'Tuyển dụng', 'Post Type General Name' ),
        'singular_name'       => _x( 'thong-tin-tuyen-dung', 'Post Type Singular Name' ),
        'menu_name'           => __( 'Tuyển dụng' ),
        'parent_item_colon'   => __( 'Parent Job' ),
        'all_items'           => __( 'Tất cả bài viết' ),
        'view_item'           => __( 'Xem bài viết' ),
        'add_new_item'        => __( 'Viết bài mới' ),
        'add_new'             => __( 'Thêm mới' ),
        'edit_item'           => __( 'Cập nhật' ),
        'update_item'         => __( 'Cập nhật' ),
        'search_items'        => __( 'Tìm kiếm' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );
    // Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'Tuyển dụng' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        'taxonomies'          => array( 'genres', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    // Registering your Custom Post Type Job
    register_post_type( 'thong-tin-tuyen-dung', $args );
    register_taxonomy('job',array('thong-tin-tuyen-dung'), array(
        'hierarchical' => true,
        'labels' => array(
            'name'                       => _x( 'Danh mục tuyển dụng', 'Taxonomy General Name' ),
            'singular_name'              => _x( 'Danh mục tuyển dụng', 'Taxonomy Singular Name' ),
            'menu_name'                  => __( 'Danh mục tuyển dụng' ),
            'all_items'                  => __( 'Tất cả danh mục' ),
            'parent_item'                => __( 'Danh mục cha' ),
            'parent_item_colon'          => __( 'Danh mục cha:' ),
            'new_item_name'              => __( 'Thêm Danh mục tuyển dụng' ),
            'add_new_item'               => __( 'Thêm Danh mục tuyển dụng' ),
            'edit_item'                  => __( 'Sửa Danh mục tuyển dụng' ),
            'update_item'                => __( 'Cập nhật Danh mục tuyển dụng' ),
            'separate_items_with_commas' => __( 'Phân cách danh mục bằng dấu phẩy' ),
            'search_items'               => __( 'Tìm kiếm danh mục' ),
            'add_or_remove_items'        => __( 'Thêm hoặc xóa Danh mục tuyển dụng' ),
            'choose_from_most_used'      => __( 'Chọn từ các danh mục hay dùng nhất' ),
            'not_found'                  => __( 'Không tìm thấy' ),
        ),
        'show_ui' => true,
        'query_var' => true,
        'show_in_nav_menus' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'tuyen-dung', 'with_front' => true),
    ));


    ///////////////////////////////
    // Set UI labels for Custom Post Type Warranty
    $labels = array(
        'name'                => _x( 'Bảo hành', 'Post Type General Name' ),
        'singular_name'       => _x( 'thong-tin-bao-hanh', 'Post Type Singular Name' ),
        'menu_name'           => __( 'Bảo hành' ),
        'parent_item_colon'   => __( 'Parent Warranty' ),
        'all_items'           => __( 'Tất cả bài viết' ),
        'view_item'           => __( 'Xem bài viết' ),
        'add_new_item'        => __( 'Viết bài mới' ),
        'add_new'             => __( 'Thêm mới' ),
        'edit_item'           => __( 'Cập nhật' ),
        'update_item'         => __( 'Cập nhật' ),
        'search_items'        => __( 'Tìm kiếm' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );
    // Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'Bảo hành' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        'taxonomies'          => array( 'genres', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // Registering your Custom Post Type Warranty
    register_post_type( 'thong-tin-bao-hanh', $args );
    register_taxonomy('bao-hanh',array('thong-tin-bao-hanh'), array(
        'hierarchical' => true,
        'labels' => array(
            'name'                       => _x( 'Danh mục bảo hành', 'Taxonomy General Name' ),
            'singular_name'              => _x( 'Danh mục bảo hành', 'Taxonomy Singular Name' ),
            'menu_name'                  => __( 'Danh mục bảo hành' ),
            'all_items'                  => __( 'Tất cả danh mục' ),
            'parent_item'                => __( 'Danh mục cha' ),
            'parent_item_colon'          => __( 'Danh mục cha:' ),
            'new_item_name'              => __( 'Thêm Danh mục bảo hành' ),
            'add_new_item'               => __( 'Thêm Danh mục bảo hành' ),
            'edit_item'                  => __( 'Sửa Danh mục bảo hành' ),
            'update_item'                => __( 'Cập nhật Danh mục bảo hành' ),
            'separate_items_with_commas' => __( 'Phân cách danh mục bằng dấu phẩy' ),
            'search_items'               => __( 'Tìm kiếm danh mục' ),
            'add_or_remove_items'        => __( 'Thêm hoặc xóa Danh mục bảo hành' ),
            'choose_from_most_used'      => __( 'Chọn từ các danh mục hay dùng nhất' ),
            'not_found'                  => __( 'Không tìm thấy' ),
        ),
        'show_ui' => true,
        'query_var' => true,
        'show_in_nav_menus' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'bao-hanh', 'with_front' => true),
    ));

    // Set UI labels for Custom Post Type Slideshow
    $label_slideshows = array(
        'name'                => _x( 'Slideshow', 'Post Type General Name' ),
        'singular_name'       => _x( 'slideshow', 'Post Type Singular Name' ),
        'menu_name'           => __( 'Slideshow' ),
        'parent_item_colon'   => __( 'Parent Slideshow' ),
        'all_items'           => __( 'Tất cả' ),
        'view_item'           => __( 'Slideshow' ),
        'add_new_item'        => __( 'Thêm mới' ),
        'add_new'             => __( 'Thêm mới' ),
        'edit_item'           => __( 'Cập nhật' ),
        'update_item'         => __( 'Cập nhật' ),
        'search_items'        => __( 'Tìm kiếm' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );
    // Set other options for Custom Post Type
    $arg_slideshows = array(
        'label'               => __( 'Slideshow' ),
        'labels'              => $label_slideshows,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        'taxonomies'          => array( 'genres', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    // Registering your Custom Post Type Slideshow
    register_post_type( 'slideshow', $arg_slideshows );

    // Register post type for contact
    $label_contact = array(
        'name'                => _x( 'Địa chỉ liên hệ', 'Post Type General Name' ),
        'singular_name'       => _x( 'Địa chỉ liên hệ', 'Post Type Singular Name' ),
        'menu_name'           => __( 'Địa chỉ liên hệ' ),
        'parent_item_colon'   => __( 'Parent Contact' ),
        'all_items'           => __( 'Tất cả' ),
        'view_item'           => __( 'Địa chỉ liên hệ' ),
        'add_new_item'        => __( 'Thêm mới' ),
        'add_new'             => __( 'Thêm mới' ),
        'edit_item'           => __( 'Cập nhật' ),
        'update_item'         => __( 'Cập nhật' ),
        'search_items'        => __( 'Tìm kiếm' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );

    $arg_contact = array(
        'label'               => __( 'Địa chỉ liên hệ' ),
        'labels'              => $label_contact,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        'taxonomies'          => array( 'genres', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // Registering your Custom Post Type Contact Address
    register_post_type( 'dia-chi', $arg_contact );

    // Register post type for imei
    $label_imei = array(
        'name'                => _x( 'Tra cứu IMEI', 'Post Type General Name' ),
        'singular_name'       => _x( 'Tra cứu IMEI', 'Post Type Singular Name' ),
        'menu_name'           => __( 'Tra cứu IMEI' ),
        'parent_item_colon'   => __( 'Parent IMEI' ),
        'all_items'           => __( 'Tất cả' ),
        'view_item'           => __( 'Tra cứu IMEI' ),
        'add_new_item'        => __( 'Thêm mới' ),
        'add_new'             => __( 'Thêm mới' ),
        'edit_item'           => __( 'Cập nhật' ),
        'update_item'         => __( 'Cập nhật' ),
        'search_items'        => __( 'Tìm kiếm' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );

    $arg_imei = array(
        'label'               => __( 'Tra cứu IMEI' ),
        'labels'              => $label_imei,
        'supports'            => array( 'title'),
        'taxonomies'          => array( 'genres', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // Registering your Custom Post Type Check imei
    register_post_type( 'check-imei', $arg_imei );

    // Register post type for agency
    $label_agency = array(
        'name'                => _x( 'Đại lý', 'Post Type General Name' ),
        'singular_name'       => _x( 'Đại lý', 'Post Type Singular Name' ),
        'menu_name'           => __( 'Đại lý' ),
        'parent_item_colon'   => __( 'Parent Agency' ),
        'all_items'           => __( 'Tất cả' ),
        'view_item'           => __( 'Đại lý' ),
        'add_new_item'        => __( 'Thêm mới' ),
        'add_new'             => __( 'Thêm mới' ),
        'edit_item'           => __( 'Cập nhật' ),
        'update_item'         => __( 'Cập nhật' ),
        'search_items'        => __( 'Tìm kiếm' ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );

    $arg_agency = array(
        'label'               => __( 'Đại lý' ),
        'labels'              => $label_agency,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );

    // Registering your Custom Post Type Agency
    register_post_type( 'dai-ly', $arg_agency );
    register_taxonomy('dong-san-pham',array('dai-ly'), array(
        'hierarchical' => true,
        'labels' => array(
            'name'                       => _x( 'Danh mục đại lý', 'Taxonomy General Name' ),
            'singular_name'              => _x( 'Danh mục đại lý', 'Taxonomy Singular Name' ),
            'menu_name'                  => __( 'Danh mục đại lý' ),
            'all_items'                  => __( 'Tất cả danh mục' ),
            'parent_item'                => __( 'Danh mục cha' ),
            'parent_item_colon'          => __( 'Danh mục cha:' ),
            'new_item_name'              => __( 'Thêm danh mục đại lý' ),
            'add_new_item'               => __( 'Thêm danh mục đại lý' ),
            'edit_item'                  => __( 'Sửa danh mục đại lý' ),
            'update_item'                => __( 'Cập nhật danh mục đại lý' ),
            'separate_items_with_commas' => __( 'Phân cách danh mục bằng dấu phẩy' ),
            'search_items'               => __( 'Tìm kiếm danh mục' ),
            'add_or_remove_items'        => __( 'Thêm hoặc xóa danh mục đại lý' ),
            'choose_from_most_used'      => __( 'Chọn từ các danh mục hay dùng nhất' ),
            'not_found'                  => __( 'Không tìm thấy' ),
        ),
        'show_ui' => true,
        'query_var' => true,
        'show_in_nav_menus' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'dong-san-pham', 'with_front' => true),
    ));

    register_taxonomy('nha-san-xuat',array('dai-ly'), array(
        'hierarchical' => true,
        'labels' => array(
            'name'                       => _x( 'Danh mục nhà sản xuất', 'Taxonomy General Name' ),
            'singular_name'              => _x( 'Danh mục nhà sản xuất', 'Taxonomy Singular Name' ),
            'menu_name'                  => __( 'Danh mục nhà sản xuất' ),
            'all_items'                  => __( 'Tất cả danh mục' ),
            'parent_item'                => __( 'Danh mục cha' ),
            'parent_item_colon'          => __( 'Danh mục cha:' ),
            'new_item_name'              => __( 'Thêm Danh mục nhà sản xuất' ),
            'add_new_item'               => __( 'Thêm Danh mục nhà sản xuất' ),
            'edit_item'                  => __( 'Sửa Danh mục nhà sản xuất' ),
            'update_item'                => __( 'Cập nhật Danh mục nhà sản xuất' ),
            'separate_items_with_commas' => __( 'Phân cách danh mục bằng dấu phẩy' ),
            'search_items'               => __( 'Tìm kiếm danh mục' ),
            'add_or_remove_items'        => __( 'Thêm hoặc xóa Danh mục nhà sản xuất' ),
            'choose_from_most_used'      => __( 'Chọn từ các danh mục hay dùng nhất' ),
            'not_found'                  => __( 'Không tìm thấy' ),
        ),
        'show_ui' => true,
        'query_var' => true,
        'show_in_nav_menus' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'nha-san-xuat', 'with_front' => true),
    ));

    register_taxonomy('thanh-pho',array('dai-ly'), array(
        'hierarchical' => true,
        'labels' => array(
            'name'                       => _x( 'Danh mục thành phố', 'Taxonomy General Name' ),
            'singular_name'              => _x( 'Danh mục thành phố', 'Taxonomy Singular Name' ),
            'menu_name'                  => __( 'Danh mục thành phố' ),
            'all_items'                  => __( 'Tất cả danh mục' ),
            'parent_item'                => __( 'Danh mục cha' ),
            'parent_item_colon'          => __( 'Danh mục cha:' ),
            'new_item_name'              => __( 'Thêm Danh mục thành phố' ),
            'add_new_item'               => __( 'Thêm Danh mục thành phố' ),
            'edit_item'                  => __( 'Sửa Danh mục thành phố' ),
            'update_item'                => __( 'Cập nhật Danh mục thành phố' ),
            'separate_items_with_commas' => __( 'Phân cách danh mục bằng dấu phẩy' ),
            'search_items'               => __( 'Tìm kiếm danh mục' ),
            'add_or_remove_items'        => __( 'Thêm hoặc xóa Danh mục thành phố' ),
            'choose_from_most_used'      => __( 'Chọn từ các danh mục hay dùng nhất' ),
            'not_found'                  => __( 'Không tìm thấy' ),
        ),
        'show_ui' => true,
        'query_var' => true,
        'show_in_nav_menus' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'thanh-pho', 'with_front' => true),
    ));
}
/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type', 0 );

/* Register CSS Styles */
function register_css_styles() {
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.0.0', 'screen, print');
    wp_enqueue_style('mfn-base', get_template_directory_uri() . '/css/base.css', array(), '16.6', 'all');
    wp_enqueue_style('mfn-layout', get_template_directory_uri() . '/css/layout.css', array(), '16.6', 'all');
    wp_enqueue_style('mfn-shortcodes', get_template_directory_uri() . '/css/shortcodes.css', array(), '16.6', 'all');
    wp_enqueue_style('mfn-animations', get_template_directory_uri() . '/assets/animations/animations.min.css', array(), '16.6', 'all');
    wp_enqueue_style('mfn-jquery-ui', get_template_directory_uri() . '/assets/ui/jquery.ui.all.css', array(), '16.6', 'all');
    wp_enqueue_style('mfn-prettyPhoto', get_template_directory_uri() . '/assets/prettyPhoto/prettyPhoto.css', array(), '16.6', 'all');
    wp_enqueue_style('mfn-jplayer', get_template_directory_uri() . '/assets/jplayer/css/jplayer.blue.monday.css', array(), '16.6', 'all');
    wp_enqueue_style('mfn-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '16.6', 'all');
    wp_enqueue_style('Open+Sans', 'http://fonts.googleapis.com/css?family=Open+Sans%3A1%2C300%2C400%2C400italic%2C700%2C700italic%2C900&#038', array(), '4.7.4', 'all');
    wp_enqueue_style('mfn-woo', get_template_directory_uri() . '/css/woocommerce.css', array(), '16.6', 'all');
}


add_action('wp_enqueue_scripts', 'register_css_styles');

