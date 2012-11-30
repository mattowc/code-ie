<?php 

/**
 * FOR FOLLOWER AND SUBSCRIBER WIDGET
 * ------------------------------------------------------------------------
 */
class ieclothing_ProductCategory_Widget extends WP_Widget {
    /** constructor */
    function ieclothing_ProductCategory_Widget() {
        $widget_ops = array( 'classname' => 'productCategory_widget', 'description' => __('Display your products of category in vertical', 'ieclothing') );
        $this->WP_Widget( 'productCategory_widget', __('IE Clothing Product Category', 'ieclothing'), $widget_ops);
    }

    function widget($args, $instance) {
        global $wpdb;

        extract( $args );
		$title  = apply_filters('widget_title', $instance['title']);
		$categories = $instance['categories'];
?>
       <div class="headingblock"><?php echo $title; ?></div>
		
       

<?php 	
	
$args = array(
'post_type' => 'wpsc-product',
'post_status' => 'publish',
'orderby'     => 'post_date',
'order'       => 'DESC',
'tax_query' => array(
    array(
        'taxonomy' => 'wpsc_product_category',
        'field' => 'id',
        'terms' => $categories
    )
)
);
$related_products = new WP_Query( $args );
// loop over query
if ($related_products->have_posts()) :
while ( $related_products->have_posts() ) : $related_products->the_post();
?>
<div id="imageblock">
 <a href="<?php echo wpsc_the_product_permalink(); ?>" title="<?php echo wpsc_the_product_title(); ?>">  <?php if(wpsc_the_product_thumbnail()) :?>
                                                            <img src="<?php echo wpsc_the_product_thumbnail(150, 150); ?>" alt="<?php echo wpsc_the_product_title(); ?>" />
															<p>
															<?php echo wpsc_the_product_title(); ?></p>
															<span><?php echo wpsc_the_product_price(); ?></span>
                                                    <?php else: ?>
                                                            <img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="100" height="100" />
															<p>
															<?php echo wpsc_the_product_title(); ?></p>
															<span><?php echo wpsc_the_product_price(); ?></span>
                                                    <?php endif; ?>	
            </div>
    </a>
<?php
endwhile;

endif;
// Reset Post Data
wp_reset_postdata();

		echo $after_widget;

    }

    function update($new_instance, $old_instance) {

		$instance           = $old_instance;
        $instance['title']  = strip_tags($new_instance['title']);
		$instance['categories']  = strip_tags($new_instance['categories']);

        return $instance;
    }

    function form($instance) {
        $title = esc_attr(@$instance['title']);
		$categories = $instance['categories'];
		
?>

      <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'ieclothing' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<?php _e('Show Categories','ieclothing'); ?>:<br />
			<select id="<?php echo $this->get_field_id( 'categories' ); ?>" name="<?php echo $this->get_field_name( 'categories' ); ?>" class="widefat" style="width:100%;">
			<option>Select Category</option>
			<?php wpsc_list_categories('category_widget_admin_category_list', array("id"=>$this->get_field_id('categories'),"name"=>$this->get_field_name('categories'),"instance"=>$instance),0); ?>
			</select>
		</p>

<?php

    }
}

/**
 * Registering all widget function
 */
function ieclothing_register_widget() {
    register_widget('ieclothing_ProductCategory_Widget');
}

add_action('widgets_init', 'ieclothing_register_widget');

function category_widget_admin_category_list( $category, $level, $fieldconfig) {
	// Only let the user choose top-level categories
	if ( $level )
		return; ?>
		<option <?php if ( $category->term_id == $fieldconfig['instance']['categories'] ) echo 'selected="selected"'; ?> value="<?php echo $category->term_id; ?>"><?php echo htmlentities($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
	
<?php 
}

?>
