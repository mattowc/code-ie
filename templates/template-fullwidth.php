<?php
/*
Template Name:  Full Width Page
*/
?>
<?php get_header(); 
 the_post(); ?>
<div id='midcol'>
        	<div class="post" style="width: 960px; margin: 0 auto;">
<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<?php if(!tk_is_wpsc_page() && !is_tax()){ ?>
				<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<?php } ?>
			
			<?php if(!is_page() && !tk_is_wpsc_page() && !is_tax() ){ ?>
				<h3><span class="author">By: AUTHOR&nbsp;<?php the_author() ?></span> &nbsp; | &nbsp;<time datetime="<?php the_time('Y-m-d')?>">Date Posted <?php the_time('F jS, Y') ?></time> . <?php if ( comments_open() ) : ?>&nbsp; | &nbsp;<a class="comment" href="<?php the_permalink(); ?>#comments"><?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></a><?php endif; ?></h3>
			<?php } ?>
		
		
	<?php the_content(__('LEARN MORE >', 'ieclothing')); ?><br />
<?php 
if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  the_post_thumbnail('full');
} 
?>
</p>
	
              <div class="seprator"></div>
                <ul class="relatedtag"><?php the_tags('<span>RELATED TAGS: </span><li>','</li>|<li>'); ?></ul><br />
                <span style="float:left;height:20px;color:#00ff00;">SHARE :</span><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : endif; ?>
	
            <?php  if(!tk_is_wpsc_page()) comments_template(); ?>
	</div>
	
	</article>
</div>	
<?php get_footer(); ?>