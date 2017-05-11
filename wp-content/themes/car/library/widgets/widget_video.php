<?php

/*

 * VIDEO WIDGET

 */

add_action('widgets_init','video_load_widgets');



function video_load_widgets(){

		register_widget("UX_Video_Widget");

}



class UX_Video_Widget extends WP_widget{



	function UX_Video_Widget(){

		$widget_ops = array('classname' => 'uxde_video_widget', 'description' => 'A widget that display your video.', 'uxde');



		$control_ops = array('id_base' => 'uxde_video_widget');



		$this->WP_Widget('uxde_video_widget', 'ITFS - Video Widget', 'uxde', $widget_ops, $control_ops);

		

	}

	

	function widget($args,$instance){

		extract($args);		

        $title = $instance['title'];

        $categories = $instance['categories'];

        $posts = $instance['posts'];

		

		echo $before_widget;



		if ( $title )

			echo $before_title.$title.$after_title;

		?>

       <!--  <div class="subcat-2"><span><a href="<?php echo get_category_link($categories); ?>" title="<?php echo get_cat_name($categories); ?>">            

            <i class="fa <?php the_field('category_icon', 'category_'.$categories); ?>"></i> <?php echo get_cat_name($categories); ?></a></span>

        </div> -->



        <?php $recent_videos = new WP_Query(array(

                'showposts' => $posts, 

                'cat' => $categories,  

                'tax_query' => array(

	                array(

	                    'taxonomy' => 'post_format',

	                    'field'    => 'slug',

	                    'terms'    => array('post-format-video'),

	                    'operator' => 'NOT IN'

	                ),

	            ),            

            )); 

        ?>        



        <?php if ($recent_videos->have_posts()) : ?>

        <div class="list-posts">

            <ul>

		        <?php $count = 0; ?>                    

		        <?php while($recent_videos->have_posts()): $recent_videos->the_post(); global $post; ?>

		        <?php $count++; ?>

	               <li>

	                    <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">	                        

	                    	<img src="<?php echo custom_image_size($post->ID,232,170,true); ?>" alt="<?php the_title(); ?>" width="232" height="170" >
	                    	<!-- <img src="<?php echo get_default_image(); ?>" alt="<?php the_title(); ?>" > -->

	                        <?php the_title(); ?>

	                    </a>

	                </li>                                                   

	        	<?php endwhile; ?>

            </ul>

        </div>

        <?php endif; ?> 



		<?php 		

		echo $after_widget;

	}

	

	function update($new_instance, $old_instance){

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

        $instance['categories'] = $new_instance['categories'];

        $instance['posts'] = $new_instance['posts'];		

		return $instance;

	}

	

	function form($instance){

		$defaults = array('title' => 'Video', 'categories' => 'all', 'posts' => 5);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		

		<p>

		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'uxde') ?></label>

		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />

		</p>



        <p>

            <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Filter by Category:', 'uxde') ?></label> 

            <select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories">

                <option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>

                <?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>

                <?php foreach($categories as $category) { ?>

                <option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>

                <?php } ?>

            </select>

        </p>

        

        <p>

            <label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e('Number of posts:', 'uxde') ?></label>

            <input type="text" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />

        </p>		

		<?php

	}

}

?>