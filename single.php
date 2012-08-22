<?php
/** 
 * Single blog post, cleaned up a bit and modified by Jon
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 * @see codex.wordpress.org
 */
get_header();
?>
<div id="leftcol">
	<?php dynamic_sidebar( 9 ); //Blog left side widget ?>
</div><!-- End leftcol -->


<div id="midcol">
	<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="post">	
				<header>
                	<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                	<h3>
                		<span class="author">By: AUTHOR <?php the_author(); ?></span>.
                		&nbsp;|&nbsp;
                		<time datetime="<?php the_time('Y-m-d')?>">Date Posted <?php the_time('F jS, Y') ?></time>  
                		<?php if ( comments_open() ) : ?>
                			&nbsp;|&nbsp;
                			<a class="comment" href="<?php the_permalink(); ?>#comments"><?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></a>
                		<?php endif; ?>
                	</h3>
            	</header>
            	<p>
            		<?php the_content(__('MORE', 'ieclothing')); ?> <br />
					<?php if ( has_post_thumbnail() ): ?>
						<?php the_post_thumbnail('full');?>
					<?php endif; ?>
				</p>
				<div class="seprator"></div>
				<ul class="relatedtag">
					<?php the_tags('<span>RELATED TAGS: </span><li>','</li>|<li>'); ?>
				</ul>
				<br />
            	<span style="float:left;height:20px;color:#00ff00;">SHARE :</span>
            	<?php dynamic_sidebar( 2 ); //Product page widget ?>
	    		<?php comments_template(); ?>
	    	</div><!-- End post -->
    	</article>
	<?php endwhile; endif; //End the loop ?>
</div><!-- End midcol -->		

<div id="rightcol">
	<?php dynamic_sidebar( 10 ); //Blog right side widget ?>
</div><!-- End rightcol -->

<?php get_footer(); ?>