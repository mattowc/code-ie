<?php
	// Setup globals
	// @todo: Get these out of template
	global $wp_query;

	// Setup image width and height variables
	// @todo: Investigate if these are still needed here
	$image_width  = get_option( 'single_view_image_width' );
	$image_height = get_option( 'single_view_image_height' );
?>

<div id="single_product_page_container">
	
	<?php
		// Plugin hook for adding things to the top of the products page, like the live search
		do_action( 'wpsc_top_of_products_page' );
	?>
	
	<div class="single_product_display group">
<?php
		/**
		 * Start the product loop here.
		 * This is single products view, so there should be only one
		 */

		while ( wpsc_have_products() ) : wpsc_the_product(); ?>
		
		<header>
		
								<h1 class="prod-title">
								<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>">
							<?php echo wpsc_the_product_title(); ?>
							</a></h1>
						</header>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
		<td>
				<?php if ( wpsc_the_product_thumbnail() ) : ?>
				<div class="imagecol">
					<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" style="cursor: auto;" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(200, 200); ?>"/>
					<?php $array_image = tk_get_gallery_images(wpsc_the_product_id()); ?>
						<?php if(count($array_image) > 1){ ?>
						
							<ul id="mycarousel" class="jcarousel-skin-tango">
							
								<?php foreach($array_image as $imgThumb){ ?>
									<?php if( $imgThumb->guid != $bg_product[0] ){ ?>		
										<li class="image-item-carousel">
												<img src="<?php echo wpsc_product_image( $imgThumb->ID,  75, 75 ); ?>" class="images-gallery-thumbnails" style="cursor: auto;" />
										</li>
									<?php } ?>
								<?php } ?>

							</ul><!-- end thumb-wrap" -->
						
						 <?php } ?>
				
					
					
					<?php else: ?>
							<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" style="cursor: auto;" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="460" height="360" />
					<?php endif; ?>
	
					
				
					
			</div><!--close imagecol-->
</td>
		<td>
					<div class="productcol">	
	<div id="description-tabs">
						
							<div id="description">
								<?php do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post); ?>
								<div class="product_description">
									<?php echo wpsc_the_product_description(); ?>
								</div><!--close product_description -->
							</div>
							<div id="additional">
								<?php do_action( 'wpsc_product_addons', wpsc_the_product_id() ); ?>		
								<?php if ( wpsc_the_product_additional_description() ) : ?>
									<div class="single_additional_description">
										<p><?php echo wpsc_the_product_additional_description(); ?></p>
									</div><!--close single_additional_description-->
								<?php endif; ?>		
								<?php do_action( 'wpsc_product_addon_after_descr', wpsc_the_product_id() ); ?>
							</div>
							
						</div>
						
						
						<?php if(wpsc_show_stock_availability()): ?>
							<?php if(wpsc_product_has_stock()) : ?>
								<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><?php _e('Product in stock', 'tokokoo'); ?></div>
							<?php else: ?>
								<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><?php _e('Product not in stock', 'tokokoo'); ?></div>
							<?php endif; ?>
						<?php endif; ?>
						
						
						
						<?php
							if ( (get_option( 'hide_addtocart_button' ) == 0 ) && ( get_option( 'addtocart_or_buynow' ) == '1' ) )
								echo wpsc_buy_now_button( wpsc_the_product_id() );
					
							echo wpsc_product_rater();
						?>
						
						
						<?php
						/**
						 * Custom meta HTML and loop
						 */
						?>
                        <?php if (wpsc_have_custom_meta()) : ?>
						<div class="custom_meta">
							<?php while ( wpsc_have_custom_meta() ) : wpsc_the_custom_meta(); ?>
								<strong><?php echo wpsc_custom_meta_name(); ?>: </strong><?php echo wpsc_custom_meta_value(); ?><br />
							<?php endwhile; ?>
						</div><!--close custom_meta-->
                        <?php endif; ?>
						<?php
						/**
						 * Form data
						 */
						?>
						
						<form class="product_form" enctype="multipart/form-data" action="<?php echo get_option('shopping_cart_url'); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>">
							<?php if ( wpsc_product_has_personal_text() ) : ?>
								<fieldset class="custom_text">
									<span>
										<legend><?php _e( 'Personalize Your Product', 'tokokoo' ); ?></legend>
										<p><?php _e( 'Complete this form to include a personalized message with your purchase.', 'tokokoo' ); ?></p>
										<textarea cols='55' rows='5' name="custom_text"></textarea>
									</span>
								</fieldset>
							<?php endif; ?>
						
							<?php if ( wpsc_product_has_supplied_file() ) : ?>

								<fieldset class="custom_file">
									<span>
										<legend><?php _e( 'Upload a File', 'tokokoo' ); ?></legend>
										<p><?php _e( 'Select a file from your computer to include with this purchase.', 'tokokoo' ); ?></p>
										<input type="file" name="custom_file" />
									</span>
								</fieldset>
							<?php endif; ?>	
							<div class="wpsc_product_price">
							<div class="wpsc_product_price_inside">
								<span class="wpsc_product_price_left">
									<?php if(wpsc_product_is_donation()) : ?>
										<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><strong><?php _e('Donation', 'tokokoo'); ?>:</strong> </label>
										<input type="text" id="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />
									<?php else : ?>
										<?php if(wpsc_product_on_special()) : ?>
											<p class="pricedisplay <?php echo wpsc_the_product_id(); ?>"><strong><?php _e('Old Price', 'tokokoo'); ?>:</strong> <span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_product_normal_price(); ?></span></p>
										<?php endif; ?>
										<p class="pricedisplay <?php echo wpsc_the_product_id(); ?>"><h1><?php _e('Price', 'tokokoo'); ?>: <span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay"><?php echo wpsc_the_product_price(); ?></span></h1></p>
										<?php if(wpsc_product_on_special()) : ?>
											<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?>"><strong><?php _e('You save', 'tokokoo'); ?>:</strong> <span class="yousave" id="yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('html' => false)); ?>! (<?php echo wpsc_you_save(); ?>%)</span></p>
										<?php endif; ?>
										 <!-- multi currency code -->
										<?php if(wpsc_product_has_multicurrency()) : ?>
											<?php echo wpsc_display_product_multicurrency(); ?>
										<?php endif; ?>
										<?php if(wpsc_show_pnp()) : ?>
											<p class="pricedisplay"><strong><?php _e('Shipping', 'tokokoo'); ?>:</strong><span class="pp_price"><?php echo wpsc_product_postage_and_packaging(); ?></span></p>
										<?php endif; ?>							
									<?php endif; ?>
							</span> <!-- end .wpsc_product_price_left -->
							
							<span class="wpsc_product_price_right">
								<?php if(wpsc_has_multi_adding()): ?>
									<span class="quantity"><legend><?php _e('Quantity', 'tokokoo'); ?></legend>
									<div class="wpsc_quantity_update">
									<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
									<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
									<input type="hidden" name="wpsc_update_quantity" value="true" />
									</div><!--close wpsc_quantity_update-->                                
									</span>
									<?php endif ;?>
						<?php /** the variation group HTML and loop */?>
                        <?php if (wpsc_have_variation_groups()) { ?>
                        <fieldset><span><legend><?php _e('', 'tokokoo'); ?></legend>
						<div class="wpsc_variation_forms">
                        	<table>
							<?php while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
								<tr><td class="col1"><h1><?php echo wpsc_the_vargrp_name(); ?>:</h1></td>
								<?php /** the variation HTML and loop */?>
								<td class="col2"><select  style="margin-top:10px;" class="wpsc_select_variation" name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>">
								<?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
									<option value="<?php echo wpsc_the_variation_id(); ?>" <?php echo wpsc_the_variation_out_of_stock(); ?>><?php echo wpsc_the_variation_name(); ?></option>
								<?php endwhile; ?>
								</select></td></tr> 
							<?php endwhile; ?>
                            </table>
						</div><!--close wpsc_variation_forms-->
                        </span></fieldset><br />
						<?php } ?>
						<?php /** the variation group HTML and loop ends here */?>

						<?php
						/**
						 * Quantity options - MUST be enabled in Admin Settings
						 */
						?>
						
						
								
								<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
								<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />
									
								<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
									<?php if(wpsc_product_has_stock()) : ?>
										<div class="wpsc_buy_button_container">
											<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
											<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
											<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'tokokoo' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')">
											<?php else: ?>
											<input type="submit" value="" name="Buy" class="wpsc_buy_button" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
												<?php endif; ?>
											<div class="wpsc_loading_animation">
												<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
												<?php _e('Updating cart...', 'tokokoo'); ?>
											</div><!--close wpsc_loading_animation-->
										</div><!--close wpsc_buy_button_container-->
									<?php else : ?>
										<p class="soldout"><?php _e('This product has sold out.', 'tokokoo'); ?></p>
									<?php endif ; ?>
								<?php endif ; ?>
								</span>
							</div>
						</div><!--close wpsc_product_price-->
						
						
						<!-- Share Button -->
						<fieldset>
							<span class="share">
							
								<?php
								if(wpsc_show_fb_like()): ?>
								<div class="FB_like">
									<iframe src="//www.facebook.com/plugins/like.php?app_id=212031522195712&amp;href=<?php echo wpsc_the_product_permalink(); ?>&amp;send=false&amp;layout=box_count&amp;width=50&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=70" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:70px;" allowTransparency="true"></iframe>
								</div><!--close FB_like-->
								
								<div class="tweet">
									<a href="https://twitter.com/share?url=<?php echo wpsc_the_product_permalink(); ?>" class="twitter-share-button" data-count="vertical">Tweet</a>
									<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
								</div>
								
								<div class="plusone">
									<g:plusone size="tall" href="<?php echo wpsc_the_product_permalink(); ?>"></g:plusone>
								</div>
								<?php endif; ?>
								
								<!--sharethis-->
								<?php if ( get_option( 'wpsc_share_this' ) == 1 ): ?>
									<div class="st_sharethis" displayText="ShareThis"></div>
								<?php endif; ?>
								<!--end sharethis-->
						
							</span>
						</fieldset>
						
						<?php if(tk_also_bought( wpsc_the_product_id(), 4 ) != ''): ?>
						<fieldset>
							<span class="also_bought">
								<?php echo tk_also_bought( wpsc_the_product_id(), 4 ); ?>
							</span>
						</fieldset>
						<?php endif; ?>
						
						<!-- End Share Button -->
						
							<?php if( wpsc_product_is_customisable() ) : ?>
								<input type="hidden" value="true" name="is_customisable"/>
							<?php endif; ?>
					
						</form><!--close product_form-->
				
					</div><!--close productcol-->	</tr></table>
			<?php
							// get items related products.
							$related_product   = tk_related_products(wpsc_the_product_id(), 'wpsc-product', 'wpsc_product_category', 5);                                    
							if($related_product->have_posts()):
						?>
							
					<div id="related-product">
					
						<h1 class="related-product-title"><?php _e('Related Products', 'tokokoo'); ?></h1>
		<ul class="relationproducts productrow">
						
							<?php while($related_product->have_posts()) : $related_product->the_post(); ?>
								<li style="width: 140px; height: 225px; padding-right: 15px">
									<a href="<?php echo wpsc_the_product_permalink(); ?>">
									<?php if(wpsc_the_product_thumbnail()) : ?>
										<img class="related_product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(100, 100); ?>" style="max-width: 160px; max-height: 160px"/>
									<?php else: ?>
										<img class="no-image related_product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="100" height="100" />
									<?php endif; ?>
									</a><br />
									<span class="product-title"><a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a></span>
									<br /><span id='product_price_<?php echo wpsc_the_product_id(); ?>' class="currentprice pricedisplay"><?php echo wpsc_the_product_price(); ?></span>
									
								</li>
							<?php endwhile; ?>
						</ul>
						
					</div>
				<?php endif; ?>
					<form onsubmit="submitform(this);return false;" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_extra_<?php echo wpsc_the_product_id(); ?>">
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="prodid"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="item"/>
					</form>
		</div><!--close single_product_display-->
<?php wp_reset_postdata(); ?>
					
				
<?php endwhile;

    do_action( 'wpsc_theme_footer' ); ?> 	

</div><!--close single_product_page_container-->
