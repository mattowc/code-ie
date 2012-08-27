<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
 <?php
        if(get_option(TK.'_seo_check') == 'true' ):
            tk_keywords_site();
            tk_description_site();
        endif;
        if((get_option(TK.'_seo_follow', '') == 'true') && is_tag() || is_tax()) tk_head_follow();
    ?>

    <title><?php tk_title_site(); ?></title>
    <?php tk_favicon(); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
    
   
    <?php wp_head(); ?>
   

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-ui.min.js"></script>

<script type="text/JavaScript" src="<?php bloginfo('template_url'); ?>/js/jquery.mousewheel.js"></script>
<script type="text/JavaScript" src="<?php bloginfo('template_url'); ?>/js/cloud-carousel.1.0.5.js"></script>

<script type="text/javascript" language="javascript">
/* <![CDATA[ */
jQuery().ready(function() {
	jQuery("#dropdown-categories > p").click(function () {
		if (jQuery("#dropdown-categories > ul").is(":hidden")) {
			jQuery("#dropdown-categories > ul").slideDown();
			jQuery("#dropdown-categories > p > span").html("-");
      	} else {
      		jQuery("#dropdown-categories > ul").slideUp();
        	jQuery("#dropdown-categories > p > span").html("+");
     	}
	});
	jQuery(".link_full_specification").click(function(){
		if (jQuery("#full_specification").is(":hidden")) {
			jQuery("#full_specification").slideDown();
			jQuery(".link_full_specification").html("<?php _e('Hide Full Specifications'); ?>");
      	} else {
      		jQuery("#full_specification").slideUp();
        	jQuery(".link_full_specification").html("<?php _e('View Full Specifications'); ?>");
     	}
	});
	
	jQuery("#foo2").CloudCarousel( { 
		
		titleBox: jQuery('#da-vinci-title'),
		altBox: jQuery('#da-vinci-alt'),
		buttonLeft: jQuery('#but1'),
		buttonRight: jQuery('#but2'),
		yRadius:40,
		xPos: 285,
		yPos: 50,
		speed:0.10,
		mouseWheel:true,
		autoRotate: 'left',
		autoRotateDelay: 2500,
		bringToFront:true
	});
	});		
/* ]]> */
</script>
</head>
<?php $classbody  = (tk_is_product_page() || tk_is_wpsc_page() && is_home())? 'wpsc-product-page':''; ?>
<?php $body_classes = join( ' ', get_body_class($classbody) ); ?>
<!--[if lt IE 7 ]><body class="ie6 <?php echo $body_classes; ?>"><![endif]-->
<!--[if IE 7 ]><body class="ie7 <?php echo $body_classes; ?>"><![endif]-->
<!--[if IE 8 ]><body class="ie8 <?php echo $body_classes; ?>"><![endif]-->
<!--[if IE 9 ]><body class="ie9 <?php echo $body_classes; ?>"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><body class="<?php echo $body_classes; ?>"><!--<![endif]-->
 <div class="wrapper">
        <div id="header">
            <div id="logo">
			 <div id="leftcol">
				
			
			<?php get_search_form(); ?>
               			 </div>
		        <div id="midlogo" style="text-align:center;"><?php $taglogo  = (is_home() || is_front_page())? 'h1' : 'div'; ?>
		<<?php echo $taglogo; ?> id="logo"><a href="<?php echo home_url('/'); ?>"><?php if(get_option(TK.'_logo') == '') bloginfo('name'); else echo '<img src="'.get_option(TK.'_logo').'"/>'; ?></a></<?php echo $taglogo; ?>></a>
                </div>
				<div id="toprightcol">
				<p class="loginMenu">
				<img src="<?php bloginfo('template_url'); ?>/images/newcart.png" /><?php printf( _n('%d items in Cart', '%d item in Cart', wpsc_cart_item_count(), 'ieclothing'), wpsc_cart_item_count() ); ?>&nbsp;
				<a href="<?php echo get_option('shopping_cart_url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/checout.jpg" /></a>
				</p>
				</div>
                </div>
            
            <div id="nav">
                
					<?php wp_nav_menu( array('menu' => 'Top Menu 1', 'container_class' => 'leftnav','link_after' => '&nbsp;&nbsp;<span>|</span>')); ?>
				<!-- .content -->
				
				<?php wp_nav_menu( array('menu' => 'Top Menu 2','items_wrap' => '<ul><li id="item-id">BULLOGS:</li>%3$s</ul>','container_class' => 'rightnav','link_after' => '&nbsp;&nbsp;<span>|</span>')); ?>
			<!-- #top-nav -->
			</div>
			 <span class="sociallinks"><?php my_share_links(); ?></span>
			 <br />	
			 <?php $pos = strpos($_SERVER['REQUEST_URI'],"checkout"); $pos1 = strpos($_SERVER['REQUEST_URI'],"products-page");
			 if(($pos === false) && ($pos1 == false) && (is_404() == false)) : ?> 		
			  <?php tk_get_feature_product(1, 20); ?>
			  <?php if(have_posts()): ?>
           		 <section class="featuredItems">
                          <div class="image_carousel">
    <div id="foo2">

                                  
                                        <?php while(have_posts()): the_post(); ?>
                                                     <a href="<?php echo wpsc_the_product_permalink(); ?>"  rel='lightbox' title="<?php echo wpsc_the_product_title(); ?>">                                               
                                                    <?php if(wpsc_the_product_thumbnail()) :?>
                                                            <img class="cloudcarousel" src="<?php echo wpsc_the_product_thumbnail(100, 100); ?>" alt="" />
															</a>
                                                    <?php else: ?>
                                                            <img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="" title="" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="100" height="100" /><p>															<?php echo wpsc_the_product_title(); ?></p>
<span><?php echo wpsc_the_product_price(); ?></span></a>
                                                    <?php endif; ?>	
                                                </a>
                                           
                                        <?php endwhile; ?>
										
			<div id="but1" class="carouselLeft" style="position:absolute;bottom:5px;left:290px;"></div>
 			<div id="but2" class="carouselRight" style="position:absolute;bottom:5px;right:320px;"></div>      
 	</div>

    </div>
                    </section>
                    <br />       
                   
                <?php endif; wp_reset_query(); ?>
			</div>
			<?php endif; ?>
		 <div id="content">
		