<?php 
/* Do not delete these lines */
_deprecated_file( sprintf( __( 'Theme without %1$s' ), basename(__FILE__) ), '3.0', null, sprintf( __('Please include a %1$s template in your theme.'), basename(__FILE__) ) );
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
		
if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?><p class="nocomments">This post is password protected. Enter the password to view comments.<p><?php
			return;
		}
	}
?>

<?php /* COMMENTS */ ?>
<?php if ('open' == $post->comment_status || $comments) : ?>
<div id="comments">
<?php if ($comments) : ?>
	<h2><a href="#respond"><?php comments_number('No Comments', '1 Comment', '% Comments' );?></a></h2>
	<?php $oddcomment = ''; ?>
	
	<?php foreach ($comments as $comment) : ?>
		
	<?php /* Check if author of blog */
	if (get_comment_author_email() == get_the_author_email()) {
	$oddcomment .= ' author';
	} ?>
	
	<div class="comment-wrap<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>" style="display: inline-block; margin-bottom: 15px; width: 100%;">
		<div class="comment-left" style="float: left; margin-right: 15px;">
			<a href="<?php comment_author_url(); ?>" title="Visit <?php comment_author(); ?>'s website" rel="external nofollow">
			<?php $size = "56"; $email = get_comment_author_email(); $default = get_bloginfo('template_url').'/images/gravatar.jpg'; ?>
			<?php echo get_avatar( $comment, $size ); ?>
			
			</a>
		</div>
		<div class="comment-right">
			<cite><b><?php comment_author_link() ?></b>
			<small><a href="#comment-<?php comment_ID() ?>" title="Permanent link to this comment"><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></a>
			<?php edit_comment_link('Edit',' &middot; ',''); ?></small></cite>
			<?php if ($comment->comment_approved == '0') : ?>
			<p style="color:#C64021;"><b><?php _e('This comment is awaiting moderation.'); ?></b></p>
			<?php else : ?>
			<?php comment_text() ?>
			<?php endif; ?>
		</div>
	</div>
	
	<?php /* Changes every other comment to a different class */	
	if ($oddcomment != '') $oddcomment = '';
	else $oddcomment = ' alt'; ?>
	
	<?php endforeach; /* end for each comment */ ?>
	
<?php else : /* this is displayed if there are no comments so far */ ?>
	<?php if ('open' == $post->comment_status) : ?>
	<!-- If no comments on this post
	<h3>There are no comments on this post</h3> -->
	<?php else : // comments are closed ?>
	<!-- If comments are closed
	<h3>Comments are closed.</h3> -->
	<?php endif; ?>
<?php endif; ?>

<?php /* PINGBACKS AND TRACKBACKS */ ?>
<?php global $trackbacks; ?>
<?php if ($trackbacks) : ?>
	<?php $comments = $trackbacks; ?>
	<h3 id="trackbacks"><?php echo sizeof($trackbacks); ?> <?php _e('Trackbacks and Pingbacks'); ?></h3>
	<ul>
		<?php foreach ($comments as $comment) : ?>
		<li>
			<cite><b><?php comment_author_link() ?></b> &middot; 
			<small><a href="#comment-<?php comment_ID() ?>" title="Permanent link to this comment">
			<?php comment_date('F jS, Y') ?></a>
			<?php edit_comment_link('Edit',' &middot; ',''); ?></small></cite>
			<?php comment_text() ?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; /* end if there are trackbacks */ ?>

<?php /* COMMENT FORM */ ?>
<?php if ('open' == $post->comment_status) : ?>
	<h3 id="respond"><?php _e('Write a Comment'); ?></h3>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p><?php _e('You must be'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in'); ?></a> <?php _e('to post a comment.'); ?></p>
<?php else : ?>
	<form id="comment_form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
		<fieldset>
			<?php if ( $user_ID ) : ?>
			<p>
				<?php _e('Logged in as'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> &middot; 
				<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php _e('Logout'); ?></a>
			</p>
			<div class="clear"></div>
			<?php else : ?>
			<table cellpadding"0" cellspacing="0" border="0">
			<tr><td style="width: 200px; padding: 10px;">
			<label for="author"><?php if ($req) echo "* "; ?><?php _e('Your Name'); ?>:</label>
			</td><td style="width: 200px; padding: 10px;"><input class="text" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
			</td><tr><td style="width: 200px; padding: 10px;">
			<label for="email"><?php if ($req) echo "* "; ?><?php _e('Email'); ?>:</label>
			</td><td style="width: 200px; padding: 10px;"><input class="text" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
			</td><tr><td style="width: 200px; padding: 10px;">			
			<label for="url"><?php _e('Website'); ?>:</label>
			</td><td style="width: 200px; padding: 10px;"><input class="text" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
			
			<?php endif; ?>
			</td><tr><td style="width: 200px; padding: 10px;">
			<!--<p>You can use these tags: <?php echo allowed_tags(); ?></p>-->
			<label for="comment"><?php _e('Message'); ?>:</label>
			</td><td style="width: 200px; padding: 10px;">
			<textarea class="text" name="comment" id="comment" cols="30" rows="5" tabindex="4"></textarea>
			</td></tr>
			<tr>
				<td style="width: 200px; padding: 10px;"></td>
				<td style="width: 200px; padding: 10px;"><input class="button" name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /></td>
			</tr>
			</table><br />
			<p>
				
			</p>
			<div class="clear"></div>
			<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			<?php do_action('comment_form', $post->ID); ?>
		</fieldset>
	</form>
<?php endif; // end if registration required and not logged in ?>

<?php endif; // end if there are comments ?>
</div>
<?php endif; // end if comments are open for this post ?>