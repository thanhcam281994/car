<?php

add_action('widgets_init', 'uxde_posts_load_widgets_home_3');



function uxde_posts_load_widgets_home_3()

{

	register_widget('UXDE_Posts_Widget_Home_3');

}



/* ==  Widget ==============================*/



class UXDE_Posts_Widget_Home_3 extends WP_Widget {

	



/* ==  Widget Setup ==============================*/



	function UXDE_Posts_Widget_Home_3()

	{

		$widget_ops = array('classname' => 'uxde_posts_widget_home_3', 'description' => __('A widget that displays your most recent posts on homepage ( style 3 ).', 'uxde') );



		$control_ops = array('id_base' => 'uxde_posts_widget_home_3');



		$this->WP_Widget('uxde_posts_widget_home_3', __('ITFS - Homepage - Posts ( Style 3 )', 'uxde'), $widget_ops, $control_ops);

	}

	



/* ==  Display Widget ==============================*/



	function widget($args, $instance){

		extract($args);

		$posts = $instance['posts'];

		

		echo $before_widget;

	?>

		

		<?php $recent_posts = new WP_Query(

			array(

			'showposts' => $posts,

			// 'cat' => $categories,

			'tax_query' => array(

                array(

                    'taxonomy' => 'post_format',

                    'field'    => 'slug',

                    'terms'    => array('post-format-video'),

                    'operator' => 'NOT IN'

                ),

            ),     

		)); ?>

		<?php if ($recent_posts->have_posts()) : ?>        

        <ul class="right">

			<?php 

				$count = 0; 

				while($recent_posts->have_posts()): $recent_posts->the_post(); global $post; 

				$count++; 

			?>			

            <li>

                <a class="img-featured bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">                	

                	<img src="<?php echo custom_image_size($post->ID,80,60,true); ?>" width="80" height="60" alt="<?php the_title(); ?>">
                	<!-- <img src="<?php echo get_default_image(); ?>" width="80" height="50" alt="<?php the_title(); ?>"> -->

                </a>

                <div class="info-post">

                    <a class="bold" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                    <span class="date timepost" data-time="<?php the_time('F-j-Y') ?>"><?php echo sw_human_time_diff() ?></span>

                </div>

            </li>			

			<?php endwhile; wp_reset_postdata(); ?>

		</ul>		

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

		

		return $instance;

	}



	function form($instance)

	{

		$defaults = array('title' => 'Recent Posts', 'posts' => 7);

		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>

			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'uxde') ?></label>

			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />

		</p>

		

		<p>

			<label for="<?php echo $this->get_field_id( 'posts' ); ?>"><?php _e('Number', 'uxde') ?></label>

			<input type="text" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />

		</p>

		

	<?php 

	}

}

?>