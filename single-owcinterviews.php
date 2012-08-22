<?php
/**
 * Shows a single interview
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 * @since 0.5
 * @see wp-content/plugins/owc-butler/interviews.php
 */
?>
<?php get_header();?>

<h1 style="font-size: 24px; text-align: center"><?php the_title(); ?></h1>
<div id="leftcol">
    <?php 
    $images_left  = explode(', ', get_post_meta( get_the_ID(), 'interview_images_left', true ));
    $links_left   = explode(', ', get_post_meta( get_the_ID(), 'interview_images_left_url', true));
    ?>
    <?php for($i = 0; $i< count($images_left); $i++): ?>
        <span class="widget widget_sp_image">
           <a href="<?php echo '' . $links_left[$i]; ?>"><img src="<?php echo $images_left[$i]; ?>" style="max-width: 200px; margin-top: 5px;" /></a><br />
        </span>
    <?php endfor; ?>
</div>  
<div id="midcol">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
           <div class="post">   
                <?php the_content(__('LEARN MORE &gt;', 'ieclothing')); ?><br />
                <?php if ( has_post_thumbnail() ): ?>
                    the_post_thumbnail('full');
                <?php endif; ?>
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
<div id="rightcol">
    <?php 
    $images_right  = explode(', ', get_post_meta( get_the_ID(), 'interview_images_right', true ));
    $links_right   = explode(', ', get_post_meta( get_the_ID(), 'interview_images_right_url', true));
    ?>
    <?php for($i = 0; $i< count($images_right); $i++): ?>
        <span class="widget widget_sp_image">
            <a href="<?php echo '' . $links_right[$i]; ?>"><img src="<?php echo $images_right[$i]; ?>" style="max-width: 200px; margin-top: 5px;" /></a><br />
        </span>
    <?php endfor; ?>
</div>


<?php while( have_posts() ) : the_post() ?>
    <div style="width: 960px; display: inline-block; padding-right: 20px; padding-left: 20px;">
        <?php $owc_artist = get_post_meta(get_the_ID(), 'interview_artist_info', true); ?>
        <?php echo do_shortcode( $owc_artist ); ?>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>