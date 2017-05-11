<?php
/*
 * BXH WIDGET
 */
add_action('widgets_init','BXH_load_widgets');

function BXH_load_widgets(){
		register_widget("UX_BXH_Widget");
}

class UX_BXH_Widget extends WP_widget{

	function UX_BXH_Widget(){
		$widget_ops = array('classname' => 'uxde_BXH_widget', 'description' => 'Hiển thị bảng xếp hạng các giải đấu', 'uxde');

		$control_ops = array('id_base' => 'uxde_BXH_widget');

		$this->WP_Widget('uxde_BXH_widget', 'ITFS - BXH Widget', 'uxde', $widget_ops, $control_ops);
		
	}
	
	function widget($args,$instance){
		extract($args);		
        $title = $instance['title'];
        $categories = $instance['categories'];
        $posts = $instance['posts'];
		
		echo $before_widget; ?>
		 <!-- Begin: PAGE_CONTENT -->
    <div id="football_table_box" class="box_right football_popup_box" style="overflow:hidden;">
	    <div class="p_bxh">
	        <img src="<?php echo get_template_directory_uri(); ?>/library/images/bxh.jpg" width="159" height="25"/>
	        <div style="margin-top:7px;">
	            <select id="sl_league_table" style="width:auto;">
	                
	                <option value="engpremierleague">Premier League</option>
	                
	                <option value="spainlaliga">LA Liga</option>
	                
	                <option value="italyseriea">Serie A</option>
	                
	                <option value="germanybundesliga">Bundes Liga</option>
	                
	                <option value="franceleague1">Ligue 1</option>
	                
	                <option value="vietnamsuperleague">Việt Nam Super League</option>
	                
	                <option value="wc2014">World Cup 2014</option>
	                
	            </select>
	        </div>
	        <div class="pad5"></div>
	        <div class="viewport lich" style="height:285px; overflow: hidden; position: relative;">
	            <div class="overview" style="height: auto;padding-top: 15px;padding-bottom: 15px; list-style: none; position: absolute; left: 0; top: 0; padding: 0;">
	                <span id="football_table_list" style="width:100%;">
	                <!--Content-->
	                </span>
	            </div>
	        </div>
	        <div class="scrollbar" style="height:267px; margin-top: 0; visibility: hidden;"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	    </div>
	</div>
	    <!-- END PAGE_CONTENT -->
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.tinyscrollbar.min.js"></script>
		<script type="text/javascript">
			var lbApiFootballTable = new function () {
		        var e = function () {
		                var e = function () {
		                        var e = jQuery("#sl_league_table").val();
		                        jQuery.getJSON("http://laban.vn/api/ajax/football/getRank?id=" + e, {}, function (e) {
		                            if (e == null || e == "") {
		                                return
		                            }
		                            jQuery("#football_table_list").html(e.html);
		                            jQuery("#football_table_box").tinyscrollbar();
		                            jQuery(".football_popup_box").hover(function () {
		                                var e = jQuery(this).find(".scrollbar");
		                                if (!e.hasClass("disable")) e.css("visibility", "visible")
		                            });
		                            jQuery(".football_popup_box").mouseleave(function () {
		                                var e = jQuery(this).find(".scrollbar");
		                                if (!e.hasClass("disable")) e.css("visibility", "hidden")
		                            })
		                        })
		                    };
		                jQuery("#sl_league_table").change(e);
		                e()
		            };
		        var t = function () {
		                e()
		            };
		        this.init = t
		    }
		</script>
		<style>

		
.box_left {
  width:662px;
  height:282px;
  border:#393 solid 1px;
  border-top:#393 solid 2px;
  padding-bottom:10px;
}

.box_left select {
  width:130px;
}

.box_right select {
  width:100px;
}

.popup_content select {
  margin:0;
}

.p_left {
  float:left;
  width:318px;
  padding-left:10px;
}

.p_left .scrollbar,
.p_right .scrollbar {
  margin-top:0;
  width:10px;
}


.p_right {
  float:right;
  width:332px;
  *height:235px;
  border-left:#393 solid 1px;
}

.giai img {
  float:left;
  padding-right:7px;
}

.giai h3 {
  float:left;
}

.text_left {
  text-align:left;
  width:35%;
}

.text_right {
  text-align:right;
  width:35%;
}

.time_f {
  color:#209ebb;
  font-weight:700;
  text-align:center;
  width:10%;
}

.num {
  color:#209ebb;
  font-weight:700;
  text-align:center;
  width:40px;
}
#football_table_list .table{width: 260px !important;}
.guess {
  text-align:center;
}

.grey_row {
  background-color:#f3f3f3;
}

.kqbd {
  padding:0 0 0 15px;
}

.bxhbd {
  padding:12px 0 15px 15px;
}

.tt {
  font-weight:700;
}

.doibong {
  width:60%;
}

.box_right {
  width:100%;
  height:380px;
  border:#dcdcdc solid 1px;
  padding-bottom:10px;
  position: relative;
}

.box_right .lich {
  width:100%;
}

.p_bxh {
  width:100%;
  padding-top:10px;  
}
		</style>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
		    lbApiFootballTable.init();
		});
		</script>
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
		$defaults = array('title' => 'BXH', 'categories' => 'all', 'posts' => 5);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		
		<?php
	}
}
?>