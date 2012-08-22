<?php
/* 
 Template Name: IcreatE Feature
 */

get_header();

/**
 * Get's one post, that is featured, for the category iCreate for interviews.  
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 * @see page.php By Shirish
 */
$args = array(
        'post_type' => 'owc_interviews',
        'interview_category' => 'i-create'
    );

$get_posts = new WP_Query( $args );
$title = '';

//Loop through the posts, but stop when we have found the post we want
while( $get_posts->have_posts() )
{
    $get_posts->the_post();

    $featured = get_post_meta( $post->ID, 'interview_featured', true );

    if( $featured == 'true' ) 
    {
        $demo = 'hecka';
        ?>
        <h1 style="font-size: 24px; text-align: center"><?php the_title(); ?></h1>

        <div id="leftcol">
            <?php 
            $images_left  = explode(', ', get_post_meta( get_the_ID(), 'interview_images_left', true ));
            $links_left   = explode(', ', get_post_meta( get_the_ID(), 'interview_images_left_url', true));

            for($i = 0; $i< count($images_left); $i++): ?>
                <span class="widget widget_sp_image">
                    <a href="<?php echo '' . $links_left[$i]; ?>"><img src="<?php echo $images_left[$i]; ?>" style="max-width: 200px; margin-top: 5px;" /></a><br />
                </span>
            <?php endfor; ?>
        </div>  
        <div id="midcol">
            <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
                <div class="post">  
                    <?php the_content(__('LEARN MORE &gt;', 'ieclothing')); ?><br />
                    <?php 
                    if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                        the_post_thumbnail('full');
                    } 
                    ?>
                </div>
            </article>

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
            for($i = 0; $i< count($images_right); $i++): ?>
                <span class="widget widget_sp_image">
                    <a href="<?php echo '' . $links_right[$i]; ?>"><img src="<?php echo $images_right[$i]; ?>" style="max-width: 200px; margin-top: 5px;" /></a><br />
                </span>
            <?php endfor; ?>
        </div>
        <?php $owc_shortcode = get_post_meta(get_the_ID(), 'interview_slider_info', true); ?>
        <?php if( $owc_shortcode != '' ): ?>
            <div style="width: 80%; height: 900px; display:inline-block; margin: 0 auto; margin-top: 10px;">
                <div style="width: 900px; height: 300px;position: absolute; margin-left: 50px">
                    <?php echo do_shortcode( $owc_shortcode ); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php $owc_artist = get_post_meta(get_the_ID(), 'interview_artist_info', true); ?>
        <?php if( $owc_artist != '' ): ?>
            <div style="width: 90%; display: inline-block; padding-right: 20px; padding-left: 20px;">
                <?php echo do_shortcode( $owc_artist ); ?>
            </div>
        <?php endif; ?>
        <div>
            <a href="http://173.254.48.32/~ieclothi/interview_category/i-create/" style="font-size: 14px; font-family: Georgia, Times New Roman, Times, serif; font-weight: normal; color: white; text-transform: uppercase;">View all interviews from IcreatE</a>
        </div>
<?php 
    } //End if statement
} //End while statement
?>
<?php 
get_footer(); 
wp_reset_postdata();
?>