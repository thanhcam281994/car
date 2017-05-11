<?php
add_action('widgets_init', 'uxde_posts_load_widgets');

function uxde_posts_load_widgets()
{
    register_widget('UXDE_Posts_Widget');
}

add_action( 'widgets_init', 'dt_unregister_posts' );
function dt_unregister_posts() 
{
    unregister_widget( 'WP_Widget_Recent_Posts' );
}

/* ==  Widget ==============================*/

class UXDE_Posts_Widget extends WP_Widget {
    

/* ==  Widget Setup ==============================*/

    function UXDE_Posts_Widget()
    {
        $widget_ops = array('classname' => 'box-list-recent item-cate recent-post', 'description' => __('A widget that displays your most recent posts.', 'uxde') );

        $control_ops = array('id_base' => 'itfs_widget');
 
        $this->WP_Widget('itfs_widget', __('ITFS - Recent Posts Video', 'uxde'), $widget_ops, $control_ops);
    }
    

/* ==  Display Widget ==============================*/

    function widget($args, $instance)
    {
        extract($args);
        
        $title = $instance['title'];    
        $posts = $instance['posts'];
        $post_type = $instance['post_type'];
        
        echo $before_widget;
        ?>

        <?php
        if($title) {
            //echo $before_title.$title.$after_title;
        }
        ?>
        <div class="subcat-2"><span><a href="" title="">            
             <?php echo $title; ?></a></span>
        </div>
        <?php 
        $recent_posts = new WP_Query(array(
            'showposts' => $posts,                 
            'post_type'=>$post_type,
        )); 
        if ($recent_posts->have_posts()) : ?>
            <div class="list-posts">
                <ul>
                    <?php $count = 0;
                    while($recent_posts->have_posts()): $recent_posts->the_post(); global $post;  $count++;
                        if($post_type == 'video'):
                            $file = get_field('video_url');
                            $url  = get_field('video_file');
                            $code = get_field('video_code');
                            if(!empty($file)){ 
                                $video_url = $file;
                            }elseif (!empty($url)) {
                                $video_url = $url;
                            }else{
                                $video_url = $code;
                            }
                            if($count == 1) : ?>
                            <li class="first">
                                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_title(); ?>
                                    <img src="<?php echo parse_youtube_url($video_url,'hqthumb'); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
                                </a>
                                <p><?php echo brew_truncate_text(get_the_excerpt(), 110, '...'); ?></p>
                            </li>
                            <?php else : ?>
                            <li>
                                <div class="cover" style="background-image: url(<?php echo parse_youtube_url($video_url,'hqthumb'); ?>)">
                                    <a href="<?php the_permalink(); ?>">
                                    </a>
                                </div>
                                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>                    
                            </li>  
                            <?php 
                            endif;                                               
                        else:
                            if($count == 1) : ?>
                            <li class="first">
                                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_title(); ?>
                                    <img src="<?php echo get_field('link_hinhdaidien'); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
                                </a>
                                <p><?php echo brew_truncate_text(get_the_excerpt(), 110, '...'); ?></p>
                            </li>
                            <?php else : ?>
                            <li>
                                <div class="cover" style="background-image: url(<?php echo get_field('link_hinhdaidien'); ?>)">
                                    <a href="<?php the_permalink(); ?>">
                                    </a>
                                </div>
                                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>                    
                            </li>  
                    <?php    
                            endif;
                        endif;
                    endwhile; wp_reset_postdata(); ?>
                </ul>
            </div>
        <?php endif; ?>    

        <!-- END WIDGET -->
        <?php
        echo $after_widget;
    }
    
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        
        $instance['title'] = $new_instance['title'];
        $instance['posts'] = $new_instance['posts'];
        $instance['post_type'] = $new_instance['post_type'];
        
        return $instance;
    }

    function form($instance)
    {
        $defaults = array('title' => 'Recent Posts', 'categories' => 'all', 'posts' => 4);
        $instance = wp_parse_args((array) $instance, $defaults); ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'uxde') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <?php var_dump($instance['post_type']); ?>
        <p>
            <label>
                <input type="radio" name="<?php echo $this->get_field_name('post_type'); ?>" value="video" <?php if($instance['post_type']=='video') echo "checked"; ?> />
                <span>Clip bóng đá</span>
            </label>
            <label>
                <input type="radio" name="<?php echo $this->get_field_name('post_type'); ?>" value="highlights" <?php if($instance['post_type']=='highlights') echo "checked"; ?> />
                <span>Hightlight</span>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Number of posts:', 'uxde') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
        </p>
        
    <?php 
    }
}
