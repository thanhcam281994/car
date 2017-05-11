<?php
add_action('widgets_init', 'uxde_posts_load_widgets_home_2');

function uxde_posts_load_widgets_home_2()
{
	register_widget('UXDE_Posts_Widget_Home_2');
}

/* ==  Widget ==============================*/

class UXDE_Posts_Widget_Home_2 extends WP_Widget {
	

/* ==  Widget Setup ==============================*/

	function UXDE_Posts_Widget_Home_2()
	{
		$widget_ops = array('classname' => 'uxde_posts_widget_home_2', 'description' => __('A widget that displays your most recent posts on homepage ( style 2 ).', 'uxde') );

		$control_ops = array('id_base' => 'uxde_posts_widget_home_2');

		$this->WP_Widget('uxde_posts_widget_home_2', __('ITFS - Homepage - Posts ( Style 2 )', 'uxde'), $widget_ops, $control_ops);
	}
	

/* ==  Display Widget ==============================*/

	function widget($args, $instance){
		extract($args);
	
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		
		echo $before_widget;
	?>

        <div class="subcat">
            <div class="title_active">
                <!-- <i class="fa <?php the_field('category_icon', 'category_'.$categories); ?>"></i>   -->
                <h2><a href="<?php echo get_category_link($categories); ?>" title="<?php echo get_cat_name($categories); ?>"><?php echo $instance['title']; ?></a></h2>
            </div>
        </div>
		
		<?php $recent_posts = new WP_Query(
			array(
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
		)); ?>

		<?php if ($recent_posts->have_posts()) : ?>
        <div class="list-posts list-posts-3">
            <ul>
			<?php 
				$count = 0; 
				while($recent_posts->have_posts()): $recent_posts->the_post(); global $post; 
				$count++; 
			?>
            <li>
                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                	<img src="<?php echo custom_image_size($post->ID,170,100,true); ?>" width="170" height="100">
                	<!-- <img src="<?php echo get_default_image(); ?>" width="170" height="100"> -->
                	<?php the_title(); ?>
                </a>
            </li>			
			
			<?php endwhile; wp_reset_postdata(); ?>
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
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts', 'categories' => 'all', 'posts' => 3);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'uxde') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
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
			<label for="<?php echo $this->get_field_id( 'posts' ); ?>"><?php _e('Number', 'uxde') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>
		
	<?php 
	}
}
?>