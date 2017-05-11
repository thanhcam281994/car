<?php
add_action('widgets_init', 'uxde_posts_load_widgets_home_4');

function uxde_posts_load_widgets_home_4()
{
	register_widget('UXDE_Posts_Widget_home_4');
}

/* ==  Widget ==============================*/

class UXDE_Posts_Widget_home_4 extends WP_Widget {
	

/* ==  Widget Setup ==============================*/

	function UXDE_Posts_Widget_home_4()
	{
		$widget_ops = array('classname' => 'uxde_posts_widget_home_4', 'description' => __('A widget that displays your most recent posts on homepage ( style 4 ).', 'uxde') );

		$control_ops = array('id_base' => 'uxde_posts_widget_home_4');

		$this->WP_Widget('uxde_posts_widget_home_4', __('ITFS - Homepage - Posts ( Style 4 )', 'uxde'), $widget_ops, $control_ops);
	}
	

/* ==  Display Widget ==============================*/

	function widget($args, $instance){
		extract($args);
		$posts = $instance['posts'];
		$categories = $instance['categories'];
		
		echo $before_widget;
	?>
		
		<?php $recent_posts = new WP_Query(
			array(
			'showposts' => $posts,
			'ignore_sticky_posts' => false,
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
        <ul class="left">
			<?php 
				$count = 0; 
				while($recent_posts->have_posts()): $recent_posts->the_post(); global $post; 
				$count++; 
			?>			  
           	<?php if($count == 1) : ?>          
            <li>
                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                	<!-- <img src="<?php echo get_default_image(); ?>" width="460" height="300" alt="<?php the_title(); ?>"> -->
                	<img src="<?php echo custom_image_size($post->ID,460,300,true); ?>" width="460" height="300" alt="<?php the_title(); ?>">
                	<?php the_title(); ?>
                </a>
                <p><?php echo brew_truncate_text(get_the_excerpt(), 330, '...'); ?></p>
            </li>
        	<?php else : ?>
            <li>
                <a class="bold" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">                	
                	<img src="<?php echo custom_image_size($post->ID,150,90,true); ?>" width="150" height="90" alt="<?php the_title(); ?>">
                	<!-- <img src="<?php echo get_default_image(); ?>" width="150" height="90" alt="<?php the_title(); ?>"> -->
                	<?php the_title(); ?>
                </a>
            </li> 
            <?php endif; ?>           
			<?php endwhile; wp_reset_postdata();?>
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
		$instance['categories'] = $new_instance['categories'];	
		$instance['posts'] = $new_instance['posts'];
		
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