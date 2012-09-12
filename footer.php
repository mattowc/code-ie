 </div>
        <div id="footer">
		<div id="nav"><?php wp_nav_menu( array('menu' => 'Footer Menu','container_class' =>'leftnav', 'link_after' => '&nbsp;&nbsp;<span>|</span>')); ?><span class="sociallinks" style="margin-right:20px;"><?php my_share_links(); ?></span> </div>
				<div style="margin-left:20px">&nbsp;&copy; 2012 IE Clothing. All rights reserved.  Developed by <a href="http://onewebcentric.com" style="color: white; border-bottom: 1px dashed;" target="_blank">One Web Centric</a><span style="float:right;margin-right:30px;margin-top:-45px"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(6) ) : endif; ?>	</span></div>
        </div>
    </div>
<?php wp_footer(); ?>
</body>
</html>