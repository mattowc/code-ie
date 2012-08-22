<?php get_header(); 
        include_once("leftsidebar.php");?>
<div id="midcol">

        	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
	<div class="post">	

                <header>
                        <h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                        <h3><span class="author">By: AUTHOR&nbsp;<?php the_author() ?></span>.&nbsp; | &nbsp;<time datetime="<?php the_time('Y-m-d')?>">Date Posted <?php the_time('F jS, Y') ?></time>  <?php if ( comments_open() ) : ?>&nbsp; | &nbsp;<a class="comment" href="<?php the_permalink(); ?>#comments"><?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></a><?php endif; ?></h3>
                </header>
                 <p><?php the_content(__('MORE', 'ieclothing')); ?> <br />
<?php 
if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  the_post_thumbnail('full');
} 
?>
</p>
		<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><i>LEARN MORE &gt;</i></a>
		<div class="seprator"></div>
<ul class="relatedtag"><?php the_tags('<span>RELATED TAGS: </span><li>','</li>|<li>'); ?></ul><br />
                <span style="float:left;height:20px;color:#00ff00;">SHARE :</span><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : endif; ?>
	</div>
        </article>

<?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.', 'ieclothing'); ?></p>
<?php endif; ?>


<?php if (show_posts_nav()) : ?>
<nav class="paging">
        <?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : ?>
                <div class="prev"><?php next_posts_link('&laquo; Previous Posts') ?></div>
                <div class="next"><?php previous_posts_link('Next Posts &raquo;') ?></div>
        <?php endif; ?>
</nav>
<?php endif; ?>

	</div>
<?php include_once ("rightsidebar.php");
 get_footer(); ?>
