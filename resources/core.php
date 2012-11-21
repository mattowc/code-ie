<?php 
   /* -------------------------- *\
   /* function list in this file *\
    * ---------------------------*\
    * 1. ieclothing_themes_admin_head   - write the admin css link
    * 2. addDashboardieclothing         - add to the dashboard ieclothing news
    * 3. dashboardieclothing            - print the rss feed news ieclothing from ieclothing website
    * 4. addCustomFieldAutomatically - add meta field to the post
    * 5. first_run_options           - make page template for the first run and set activation in theme-setup.php
    * 6. new_excerpt_length          - set new length for excerpt
    * 7. updateCartCount             - update count of cart
    * 8. date_posted_on              - print the post date
    * 9. get_next_posts_link_icl     - return the next post link
    * 10.get_previous_posts_link_icl - return the prev post link
    * 11.tk_my_nav_unlister             - return <ul> menu </ul>
    * 12.isHavePreviousPosts         - return if a post have previous
    * 13.isHaveNextPosts             - return if a post have next
    * 14.cutText                     - cut a text into a size
    * 15.myExcerpts                  - make a custom excerpts
    * 16.tk_get_ads                  - get all ads from options table
    * 17.tk_pagination               - build a custom pagination
    * 18.tk_getStickyPost               - get a limited post as sticky post
    * 19.tk_getStickyPostType           - get a limited post for a post type as sticky post
    * 20.tk_getFeatureProduct           - get post feature wpsc product 
    * 21.tk_getSingleStickyAttachment   - get post thumbnail of a post
    * 22.tk_getProductImage             - get the image of wpsc product
    * 23.tk_getRecentPostType           - get the latest published post type
    * 24.tk_getRecentProduct            - get the latest published product
    * 25.tk_getRecentPost               - get the latest published post
    * 26.tk_listCatByPostType           - list all of category of post
    * 27.tk_listCatForProduct           - list all of category of wpsc product
    * 28.tk_getLinkForCatByPostType     - return the link value of category in post
    * 29.tk_getLinkForCatByProduct      - return the link value of category in wpsc product
    * 30.tk_tk_is_content                 - check if it is on content of post or not
    * 31.tk_isOnAccountPage             - check if it is on account page or not
    * 32.tk_isOnProductPage             - check if it is on product page or not
    * 33.tk_isOnShoppingCartPage        - check if it is on shopping cart page or not
    * 34.tk_isOnTransactionPage         - check if it is on transaction page or not
    * 35.tk_isOnUserLogPage             - check if it is on user log page
    * 36.tk_isOnWPSCList                - check if it is on category list page or not
    * 37.tk_isOnWPSCpage                - check if it is on wpsc product page or not
    * 38.tk_getGalleryImageProduct      - return the image gallery of product image
    * 39.tk_getPopularProducts          - return list of popular product
    * 40.tk_loopByLatestComment         - return the list of latest comment
    * 41.tk_showPostViewCount           - return the count of post view
    * 42.tk_setLengthTitle              - set length of a post title
    * 43.tk_the_breadcrumb              - return the breadcrumb 
    * 44.tk_product_price               - return the rss feed for price of product
    * 45.tk_get_random                  - return the random post
    * 46.tk_count_post                  - return the count of a post
    * 47.tk_wp_paginate_comments        - make a comment paging
    * 48.tk_paginate                    - set the maximum value for comment paging
    * 49.tk_paginate_loop               - make an order list of comment paging loop
    * 50.tk_also_bought			- Displaying also bought products
    * 51.tk_related_products            - Get query for related products
    * 52.tk_comments                    - For display comment on single product
    * 53.tk_get_the_term_list           - Retrieve a post's terms as a list with specified format no link.
    * 54.tk_add_facebook_pages          - Add facebook apps library.
    * 55.tk_head_facebook               - Add meta on head for facebook like.
   */  
    

    // include for custom panel admin
    include_once TK_RESOURCE_DIR.'/theme-setup.php';
    include_once TK_POSTTYPE_DIR.'/slider-posttype.php';
    include_once TK_RESOURCE_DIR.'/theme-custommeta.php';
	
    

    // register functions.
   // add_action('admin_head'         , 'tk_themes_admin_head');
   // add_action('wp_dashboard_setup' , 'tk_add_dashboard');

    add_filter( 'wp_nav_menu'       , 'tk_my_nav_unlister' );
    add_filter('excerpt_length'     , 'tk_new_excerpt_length'); // for excerpt length

    // Panel Options Stylesheet
    function tk_themes_admin_head() {
        echo '<style>					
                        .logo-small {
                                background:url("'.TK_IMAGE_URL.'/logo-small.png") no-repeat scroll 0 0 transparent;
                                display:block;
                                height:22px;
                                overflow:hidden;
                                text-indent:-1000px;
                                width:106px;
                        }
        </style>';
    }

    /**
     * Function for creating custom field automatically, for creating post page view counter
     * @author Onnay Okheng
     *
     * @package ieclothing Portfolio
     * @since 1.0
     */
    function tk_add_custom_field_automatically($post_ID) {
        global $wpdb;
        if(!wp_is_post_revision($post_ID)) {
            add_post_meta($post_ID, '_' . TK . '_view-counter', '0', true);
        }
    }
    add_action('publish_post', 'tk_add_custom_field_automatically'); //create auto custom field for post view counter


    /*
     * setting for new excerpt
     *
     * @global <type> $post
     * @global <type> $wpdb
     * @param <type> $length
     * @return <type>
     */
    function tk_new_excerpt_length($length=300) {
        global $post,$wpdb;
        if (is_single ()){
            return 150;
        }
        return $length;
    }


    /**
     * For updating cart count live Query
     */
    function tk_update_cart_count(){

        if ( ($_REQUEST['wpsc_ajax_action'] == 'add_to_cart') && $_REQUEST['ajax'] == TRUE ) {
            $output = sprintf( _n('%d item', '%d items', wpsc_cart_item_count(), 'ieclothing'), wpsc_cart_item_count());
            $totalprice = wpsc_cart_total_widget();
            echo "jQuery('.totalitems').html('$output');jQuery('.totalprice').html(\"$totalprice\");";
            exit;
        }
    }
    add_action( 'wpsc_alternate_cart_html', 'tk_update_cart_count' );


    /**
     * setting date post
     *
     * @global  $post
     * @param <type> $patternDate
     * @return <type>
     */
    function tk_date_posted_on($patternDate='d-M') {
            global $post;
            //$arrayDay = array('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
            return get_the_date($patternDate);
    }


    /**
     * Get next post link
     *
     * @global int $paged
     * @global <type> $wp_query
     * @param <type> $max_page
     * @return <type>
     */
    function tk_get_next_posts_link($max_page = 0 ) {
            global $paged, $wp_query;

            if ( !$max_page )
                    $max_page = $wp_query->max_num_pages;

            if ( !$paged )
                    $paged = 1;

            $nextpage = intval($paged) + 1;

            if ( !is_single() && ( empty($paged) || $nextpage <= $max_page) ) {
                    $attr = apply_filters( 'next_posts_link_attributes', '' );
                    return next_posts( $max_page, false );
            }
    }


    /**
     * Get previous post
     *
     * @global int $paged
     * @return <type>
     */
    function tk_get_previous_posts_link( ) {
            global $paged;

            if ( !is_single() && $paged > 1 ) {
                    $attr = apply_filters( 'previous_posts_link_attributes', '' );
                    return previous_posts( false );
            }
    }



    /**
     * @param <type> $menu
     * @return <type>
     */
    function tk_my_nav_unlister( $menu ){
      if (strripos($menu ,"menu-bottomheader") !== false){
        return preg_replace( array( '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );
      }
      return $menu;
    }



    function tk_is_have_previous_posts(){
        global $paged;
        if ( !is_single() && $paged > 1 ){
            return true;
        }
        return false;
    }



    function tk_is_have_next_posts(){
        global $paged, $wp_query;

        if ( !$max_page )
                $max_page = $wp_query->max_num_pages;

        if ( !$paged )
                $paged = 1;

        $nextpage = intval($paged) + 1;

        if ( !is_single() && ( empty($paged) || $nextpage <= $max_page) ) {
            return true;
        }
        return false;
    }


    /**
     * This is function for cut the content
     *
     * @param <type> $content
     * @param <type> $excerpt_length
     * @return <type>
     */
    function tk_cut_text($content = false, $excerpt_length = 4) {
                $mycontent = strip_shortcodes($content);
                $mycontent = str_replace(']]>', ']]&gt;', $mycontent);
                $mycontent = strip_tags($mycontent);
                $words = explode(' ', $mycontent, $excerpt_length + 1);
                if(count($words) > $excerpt_length) :
                    array_pop($words);
                    $mycontent = implode(' ', $words);
                endif;
                //print_r($words);
                return $mycontent;
    }


    /**
     * This is for get excerpt content
     *
     * @global  $post
     * @param string $content
     * @param integer $excerpt_length
     * @return string
     */
    function tk_my_excerpts($content = false, $excerpt_length=200, $html = true) {

                $mycontent = $content;
                $mycontent = strip_shortcodes($mycontent);
                $mycontent = str_replace(']]>', ']]&gt;', $mycontent);
                $mycontent = strip_tags($mycontent);
                $words = explode(' ', $mycontent, $excerpt_length + 1);
                if(count($words) > $excerpt_length && $html ) :
                    array_pop($words);
                    array_push($words, '...');
                    $mycontent = implode(' ', $words);
                endif;
                if ($html)
                    $mycontent = '<p>' . $mycontent . '</p>';
        // Make sure to return the content
        return $mycontent;
    }


    /**
     * This function for get data ads or promotion
     *
     * @param string $type_ads
     * @return array
     * @author Onnay Okheng
     */
    function tk_get_ads( $type_ads = '125' )
    {
        $cat            = $type_ads;
        $ads_array      = array();
        $ads            = array();
        $rpt            = intval(get_option( TK . '_ads' . $cat . '_rpt' ));
        $i              = 1; // initialize

        if($rpt == '')
            $rpt = 0;


        // looping for call ads option
        while($i <= $rpt){

            $img               = get_option( TK . '_ads' . $cat . '_img_' . $i );

            if($img != ''){
                $ads['title']      = get_option( TK . '_ads' . $cat . '_title_' . $i );
                $ads['link']       = sanitize_url(get_option( TK . '_ads' . $cat . '_link_' . $i ));
                $ads['text']       = get_option( TK . '_ads' . $cat . '_text_' . $i );
                $ads['img']        = $img;

                $ads_array[]                   = $ads;
            }

            $i++;

        }

        return $ads_array;

    }



    /**
    * wpsc_pagination generates and returns the urls for pagination
    * @access public
    *
    * @since 3.8
    * @param $totalpages (INT) Number of pages,
    * @param $per_page (INT) Number of products per page
    * @param $current_page (INT) Current Product page number
    * @param $page_link (STRING) URL of Page
    *
    * @return
    */
    function tk_pagination($totalpages = '', $per_page = '', $current_page = '', $page_link = '') {
        global $wp_query;
        $num_paged_links = 4; //amount of links to show on either side of current page

        $additional_links = '';

        //additional links, items per page and products order
        if( get_option('permalink_structure') != '' ){
                $additional_links_separator = '?';
        }else{
                $additional_links_separator = '&';
        }
        if( !empty( $_GET['items_per_page'] ) ){
                        $additional_links = $additional_links_separator . 'items_per_page=' . $_GET['items_per_page'];
                        $additional_links_separator = '&';
        }
        if( !empty( $_GET['product_order'] ) )
                $additional_links .= $additional_links_separator . 'product_order=' . $_GET['product_order'];

        $additional_links = apply_filters('wpsc_pagination_additional_links', $additional_links);
        //end of additional links

        if(empty($totalpages)){
                        $totalpages = $wp_query->max_num_pages;
        }
        if(empty($per_page))
                $per_page = (int)get_option('wpsc_products_per_page');

        $current_page = absint( get_query_var('paged') );
        if($current_page == 0)
                $current_page = 1;

        if(empty($page_link))
                $page_link = wpsc_a_page_url();

        //if there is no pagination
        if(!get_option('permalink_structure')) {
                $category = '?';
                if(isset($wp_query->query_vars['wpsc_product_category']))
                        $category = '?wpsc_product_category='.$wp_query->query_vars['wpsc_product_category'];
                if(isset($wp_query->query_vars['wpsc_product_category']) && is_string($wp_query->query_vars['wpsc_product_category'])){

                        $page_link = get_option('blogurl').$category.'&amp;paged';
                }else{
                        $page_link = get_option('product_list_url').$category.'&amp;paged';
                }

                $separator = '=';
        }else{
                // This will need changing when we get product categories sorted
                if(isset($wp_query->query_vars['wpsc_product_category']))
                        $page_link = trailingslashit(get_option('product_list_url')).$wp_query->query_vars['wpsc_product_category'].'/';
                else
                        $page_link = trailingslashit(get_option('product_list_url'));

                $separator = 'page/';
        }

        // If there's only one page, return now and don't bother
        if($totalpages == 1)
                return;
        // Pagination Prefix
        $output = __('','ieclothing');

        if(get_option('permalink_structure')){
                // Should we show the FIRST PAGE link?
                if($current_page > 1)
                        $output .= "<a href=\"". esc_url( $page_link . $additional_links ) . "\" class='p-prev' title=\"" . __('First Page', 'ieclothing') . "\">" . __('&laquo; ', 'ieclothing') . "</a>";

                // Should we show the PREVIOUS PAGE link?
                /*if($current_page > 1) {
                        $previous_page = $current_page - 1;
                        if( $previous_page == 1 )
                                $output .= " <a href=\"". esc_url( $page_link . $additional_links ) . "\"  title=\"" . __('Previous Page', 'ieclothing') . "\">" . __('&lt; Previous', 'ieclothing') . "</a>";
                        else
                                $output .= " <a href=\"". esc_url( $page_link .$separator. $previous_page . $additional_links ) . "\" title=\"" . __('Previous Page', 'ieclothing') . "\">" . __('&lt; Previous', 'ieclothing') . "</a>";
                }*/
                $i =$current_page - $num_paged_links;
                $count = 1;
                if($i <= 0) $i =1;
                while($i < $current_page){
                        if($count <= $num_paged_links){
                                if($count == 1)
                                        $output .= " <a href=\"". esc_url( $page_link . $additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'ieclothing'), $i ) . " \">".$i."</a>";
                                else
                                        $output .= " <a href=\"". esc_url( $page_link .$separator. $i . $additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'ieclothing'), $i ) . " \">".$i."</a>";
                        }
                        $i++;
                        $count++;
                }
                // Current Page Number
                if($current_page > 0)
                        $output .= "<span class='current'>$current_page</span>";

                //Links after Current Page
                $i = $current_page + $num_paged_links;
                $count = 1;

                if($current_page < $totalpages){
                        while(($i) > $current_page){

                                if($count < $num_paged_links && ($count+$current_page) <= $totalpages){
                                                $output .= " <a href=\"". esc_url( $page_link .$separator. ($count+$current_page) .$additional_links ) . "\" title=\"" . sprintf( __('Page %s', 'ieclothing'), ($count+$current_page) ) . "\">".($count+$current_page)."</a>";
                                $i++;
                                }else{
                                break;
                                }
                                $count ++;
                        }
                }
                if($current_page < $totalpages) {
                        $output .= "<a href=\"". esc_url( $page_link  .$separator. $totalpages . $additional_links ) . "\" class='p-next' title=\"" . __('Last Page', 'ieclothing') . "\">" . __(' &raquo;', 'ieclothing') . "</a>";
                }

        } else {
                // Should we show the FIRST PAGE link?
                if($current_page > 1)
                        $output .= "<a href=\"". remove_query_arg('paged' ) . "\" class='p-prev' title=\"" . __('First Page', 'ieclothing') . "\">" . __('&laquo; First', 'ieclothing') . "</a>";

                $i =$current_page - $num_paged_links;
                $count = 1;
                if($i <= 0) $i =1;
                while($i < $current_page){
                        if($count <= $num_paged_links){
                                if($i == 1)
                                        $output .= " <a href=\"". remove_query_arg('paged' ) . "\" title=\"" . sprintf( __('Page %s', 'ieclothing'), $i ) . " \">".$i."</a>";
                                else
                                        $output .= " <a href=\"". add_query_arg('paged', $i ) . "\" title=\"" . sprintf( __('Page %s', 'ieclothing'), $i ) . " \">".$i."</a>";
                        }
                        $i++;
                        $count++;
                }
                // Current Page Number
                if($current_page > 0)
                        $output .= "<span class='current'>$current_page</span>";

                //Links after Current Page
                $i = $current_page + $num_paged_links;
                $count = 1;

                if($current_page < $totalpages){
                        while(($i) > $current_page){

                                if($count < $num_paged_links && ($count+$current_page) <= $totalpages){
                                                $output .= " <a href=\"". add_query_arg( 'paged', ($count+$current_page) ) . "\" title=\"" . sprintf( __('Page %s', 'ieclothing'), ($count+$current_page) ) . "\">".($count+$current_page)."</a>";
                                $i++;
                                }else{
                                break;
                                }
                                $count ++;
                        }
                }

                if($current_page < $totalpages) {
                        $output .= "<a href=\"". add_query_arg( 'paged', $totalpages ) . "\" class='p-next' title=\"" . __('Last Page', 'ieclothing') . "\">" . __('Last &raquo;', 'ieclothing') . "</a>";
                }
        }
        echo $output;
    }


    /**************************************************************************
     *  all of this code redefine from iclUtility.php
     **************************************************************************/

    /**
     * this function will get standart feature
     *
     * @param <type> $page
     * @param <type> $limit
     * @param <type> $rand
     * @return <type>
     */
    function tk_getStickyPost($page=1, $limit=5, $rand=false){
        $sticky = get_option( 'sticky_posts' );
        return query_posts( array(
                'post__in' 	=> $sticky,
                'posts_per_page'=> $limit,
                'paged'         => $page)
        );
    }


    /**
     * get sticky post type
     *
     * @param string $postType
     * @param string $sticktOption
     * @param integer $page
     * @param integer $limit
     * @param boolean $rand
     * @return object
     */
    function tk_get_sticky_posttype($postType='wpsc-product', $sticktOption='sticky_products', $page=1, $limit=5, $rand=false){

        $sticky_array = get_option($sticktOption);
        if (!is_array($sticky_array)){
                $dataArray['posts_per_page'] = $limit;
                query_posts($dataArray);
                return false;
        }

        $dataArray = array(
                    'post__in' 		=> $sticky_array,
                    'post_type' 	=> $postType,
                    'posts_per_page' 	=> $limit,
                    'paged' 		=> $page
                 );
        if ($rand){
           $dataArray['orderby'] = 'rand';
        }

        return query_posts($dataArray);

    }

    /* this function will get product feature */

    /**
     * get feature product
     *
     * @param integer $page
     * @param integer $limit
     * @param boolean $rand
     * @return object
     */
    function tk_get_feature_product($page=1, $limit=5, $rand=false){

        return tk_get_sticky_posttype('wpsc-product', 'sticky_products', $page, $limit, $rand);

    }

    /**
     * this function will get the post thumbnail
     *
     * @param integer $postId
     * @param string $metaImageName
     * @param integer $width
     * @param integer $height
     * @return HTML/false
     */
    function tk_get_single_sticky_attachment( $postId, $metaImageName='featured-product-thumbnails', $width=540, $height=260 ) {

            $attached_images = (array)get_posts( array(
                            'post_type' 	=> 'attachment',
                            'numberposts' 	=> 1,
                            'post_status' 	=> null,
                            'post_parent' 	=> $postId,
                            'orderby' 		=> 'menu_order',
                            'order' 		=> 'ASC'
            ) );

            if ( has_post_thumbnail( $postId ) ) {
                            add_image_size( $metaImageName, $width, $height, TRUE );
                            $image = get_the_post_thumbnail( $product_id, $metaImageName );
                            return $image;
            } elseif ( !empty( $attached_images ) ) {
                            $attached_image = $attached_images[0];
                            $image_link = wpsc_product_image( $attached_image->ID, $width, $height );
                            return '<img src="' . $image_link . '" alt="" />';
            }

            return false;

    }

    /**
     * Get Product image
     *
     * @param integer $productId
     * @param integer $witdh
     * @param integer $height
     * @return HTML/False
     */
    function tk_get_product_image($productId, $witdh = 100, $height = 100){

		return tk_get_single_sticky_attachment($productId, 'featured-product-thumbnails', $witdh, $height);

    }

    /**
     * Get recent by post type
     *
     * @param string $postType
     * @param integer $page
     * @param integer $limit
     * @return object
     */
    function tk_get_recent_posttype($postType='wpsc-product', $page=1, $limit=5){

        $dataArray = array(
                        'post_type' 		=> $postType,
                        'posts_per_page' 	=> $limit,
                        'paged' 		=> $page,
                        'orderby' 		=> 'DESC'
                 );
        return query_posts($dataArray);

        if (!have_posts ()){
                $dataArray = array(
                        'post_type' 		=> 'post',
                        'posts_per_page' 	=> $limit,
                        'paged' 		=> $page,
                        'orderby' 		=> 'DESC'
                );

                return query_posts($dataArray);
        }
    }

    /**
     * Get recent product
     *
     * @param integer $page
     * @param integer $limit
     * @return object
     */
    function tk_get_recent_product($page=1, $limit=5){

            return tk_get_recent_posttype('wpsc-product', $page ,$limit);

    }

    /**
     * Get recent post
     *
     * @param integer $page
     * @param integer $limit
     * @return object
     */
    function tk_get_recent_post($page=1, $limit=5){

        return tk_get_recent_posttype('post', $page, $limit);

    }

    /**
     * listing all the categories under categories id and post type
     *
     * @param integer $category_id
     * @param string $post_type
     */
    function tk_list_cat_by_posttype($category_id, $post_type = 'post'){

        $category_list = get_terms($post_type, 'hide_empty=0&parent=' . $category_id);

    }

    /**
     * listing all the categories under categories id and post type wpsc_product_category
     *
     * @param string $category_id
     * @return <type>
     */
    function tk_list_cat_for_product($category_id ){
        return tk_list_cat_by_posttype($category_id, 'wpsc_product_category');
    }

    function tk_get_link_cat_by_posttype($category_id, $post_type = 'post'){
        return get_term_link((int)$category_id, $post_type);
    }

    function tk_get_link_cat_by_product($category_id){
        return tk_get_link_cat_by_posttype($category_id, 'wpsc_product_category');
    }

    function tk_is_content($text=''){
        global $post;

        if ( preg_match( "/\[".$text."\]/", $post->post_content) ) {
            return true;
        }
        return false;
    }

    /**
     * Check if on userlog page
     * @return object
     */
    function tk_is_account_page(){
        return tk_is_content('userlog');
    }

    /**
     * Check if on products page
     * @return object
     */
    function tk_is_product_page(){
        return tk_is_content('productspage');
    }

    /**
     * Check if on shopping cart page
     * @return object
     */
    function tk_is_shopping_page(){
        return tk_is_content('shoppingcart');
    }

    /**
     * Check if on transaction results page
     * @return object
     */
    function tk_is_transaction_page(){
        return tk_is_content('transactionresults');
    }

    /**
     * Check if on Product Category page
     * @return object
     */
    function tk_is_wpsc_list(){
        global $wpsc_query;
        if (isset($wpsc_query->query_vars['wpsc_product_category'])){
                return true;
        }
        return false;
    }
    
    /**
     * Check is on single product or not.
     *
     * @global  $wp_query
     * @return TRUE/FALSE
     */
    function tk_is_single_product(){
        global $wp_query;

        if(@$wp_query->query_vars['post_type'] == 'wpsc-product'){
                return true;
        }

        return false;
    }

    /**
     * Check if on wpsc page
     * @return object
     */
    function tk_is_wpsc_page(){
        global $wp_query;

        if(@$wp_query->query_vars['post_type'] == 'wpsc-product'){
                return true;
        }

        return  (tk_is_wpsc_list() || tk_is_account_page() || tk_is_product_page() ||
                tk_is_shopping_page() || tk_is_transaction_page());

    }

    /**
     * Function for showing gallery images of products on single product.
     * @author Onnay Okheng
     *
     * @global $wpdb $wpdb
     * @global $post $post
     * @param integer $id
     * @return array
     */
    function tk_get_gallery_images($id){
        /** global $wpdb, $post;
        $args = array(
            'post_type'     => 'attachment',
            'numberposts'   => -1,
            'post_status'   => null,
            'post_parent'   => $id,
            'orderby'       => 'menu_order',
            'order'         => 'ASC'
            );

        $array_image        = (array)get_posts($args);

        return $array_image;
         * 
         */
        
        return get_children( 'post_type=attachment&post_mime_type=image&post_parent='.$id );
    }


    /**
     * function for get data of popular product
     * @author Onnay Okheng
     *
     * @global $wpdb $wpdb
     * @global $post $post
     * @global $wpsc $wpsc
     * @global query $wp_query
     * @param integer $limit
     * @param boolean $ifnone
     * @return object
     */
    function tk_get_popular_products($limit = 8, $ifnone = false){
        global $wpdb, $post, $wpsc, $wp_query;

        $popular    = $wpdb->get_results( "SELECT `cart`.`prodid`
                     FROM `" . WPSC_TABLE_CART_CONTENTS . "` AS `cart`
                     INNER JOIN `" . WPSC_TABLE_PURCHASE_LOGS . "` AS `logs`
                     ON `cart`.`purchaseid` = `logs`.`id`
                     WHERE `logs`.`processed` >= 2
                     GROUP BY `cart`.`prodid`
                     ORDER BY SUM(`cart`.`quantity`) DESC ", ARRAY_A ); //get products with top income.
        
        foreach ($popular as $pop){
            $array_pop[]    = $pop['prodid'];
        }

        $args = array(
            'post_type'     => 'wpsc-product',
            'numberposts'   => $limit,
            'post_status'   => null,
            'post__in'      => $array_pop,
            'order'         => 'ASC'
        );
        $result_popular     = new WP_Query( $args );

        if (!$result_popular->have_posts() && $ifnone ){
            $args = array(
                'post_type'     => 'wpsc-product',
                'numberposts'   => $limit,
                'order'         => 'rand'
            );

            $result_popular     = new WP_Query( $args );
        }

        return $result_popular;
    }


    /**
     * Function to order the post by latest comment, I used it in Post Widget
     * @author Onnay Okheng
     *
     * @global $wpdb $wpdb
     * @param integer $limit
     * @param string $post_type
     * @return object
     */
    function tk_get_posts_by_comment($limit = 5, $post_type = 'post') {
        global $wpdb;

        $sql = "SELECT DISTINCT ID
                FROM $wpdb->comments
                LEFT OUTER JOIN $wpdb->posts ON ( $wpdb->comments.comment_post_ID = $wpdb->posts.ID )
                WHERE comment_approved =  '1'
                AND comment_type =  ''
                AND $wpdb->posts.post_password =  ''
                AND $wpdb->posts.post_type =  '" . $post_type . "'
                ORDER BY comment_date_gmt DESC
                LIMIT " . $limit;

        $result     = $wpdb->get_results($sql);

        return $result;
    }

    /**
     * Show post view counter
     *
     * @param integer $post_id
     * @return integer
     */
    function tk_post_view_count($post_id) {
        $total_count = 0;
        $counter = get_post_meta($post_id, '_'. TK. '_view-counter');

        foreach ($counter as $counter) {
            $totalCount = $counter[0];
        }

        if($totalCount === 0) {
            $count = 0;
        } elseif($totalCount == 1) {
            $count = 1;
            } else {
                $count = $totalCount;
            }
        return $count;
    }

    /**
     * for setting length title of post
     * @author Onnay Okheng
     *
     * @param string $title
     * @param integer $limit
     * @return string
     */
    function tk_set_length_title($title, $limit = 20) {
        if (strlen($title) > $limit ) {
            $title    = ucfirst(substr($title, 0, $limit)) . '&hellip;';
        } else {
            $title    = ucfirst($title);
        }
        return $title;
    }


    /**
     * Printing website breadcrumb
     * @author Onnay Okheng
     *
     * @global  $wp_query
     * @global $post $post
     * @global $author $author
     * @param string $delimiter
     * @param string $currentclass
     */
    function tk_the_breadcrumb($delimiter = '', $currentclass='class="on"' ) {
		global $wp_query;

		if (is_home()) {
			echo '<a ' . $currentclass . ' href="' . WP_SITES_URL . ' " title="Home">'.__('Home').'</a>';
		}

			if ( is_category() ) :
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					$cat_obj    = $wp_query->get_queried_object();
					$thisCat    = $cat_obj->term_id;
					$thisCat    = get_category($thisCat);
					$parentCat  = get_category($thisCat->parent);
					echo ' ' . $delimiter . ' ';
					if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
					echo '<b>Archive by category &#39;';
					single_cat_title();
					echo '&#39;</b>';

			elseif ( is_day() ) :
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					echo ' ' . $delimiter . ' ';
					echo '<a ' . $currentclass . ' href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
					echo '<a ' . $currentclass . ' href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
					echo get_the_time('d');

			elseif ( is_month() ) :
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					echo ' ' . $delimiter . ' ';
					echo ' <a ' . $currentclass . ' href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
					echo '<b>'. get_the_time('F') .'</b>';

			elseif ( is_year() ) :
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					echo ' ' . $delimiter . ' ';
					echo '<b>'.get_the_time('Y').'</b>';

			elseif ( is_single() ) :
				global $post;
				$hasilku = get_post_type($post->ID);
				if ('post' == get_post_type($post->ID)) {
					$cat = get_the_category();
					$cat = $cat[0];
					echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					echo ' ' . $delimiter . ' ';
					$hasil = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
					if (!is_object($hasil)) {
						echo $hasil;
					}

					echo '<b>' . get_the_title() . '</b>';
				} else {
					$option = array(
						'crumb-separator' => ' '.$delimiter.' ',
						'before-breadcrumbs' => '',
						'after-breadcrumbs' => ' '.$delimiter.' ',
					);
					echo wpsc_output_breadcrumbs($option);
					echo '' . get_the_title() . '';
				}
			elseif ( is_page() && !$post->post_parent ) :
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					echo ' ' . $delimiter . ' ';

					echo '' . get_the_title() . '';

			elseif ( is_page() && $post->post_parent ) :

					echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					$parent_id  = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
							$page = get_page($parent_id);
							$breadcrumbs[] = '<a ' . ' href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
							$parent_id  = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					echo ' ' . $delimiter . ' ';
					foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
					the_title();

			elseif(tk_is_wpsc_list()):
					$option = array(
						'crumb-separator' => ' '.$delimiter.' ',
						'before-breadcrumbs' => '',
						'after-breadcrumbs' => ' '.$delimiter.' ',
					);
					echo wpsc_output_breadcrumbs($option);
					echo '' . get_the_title() . '';

			elseif ( is_search() ) :
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					echo ' ' . $delimiter . ' ';
					echo '<b>Search results for &#39;' . get_search_query() . '&#39;</b>';

			elseif ( is_tag() ) :
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					echo ' ' . $delimiter . ' ';
					echo '<b>Posts tagged &#39;';
					single_tag_title();
					echo '&#39;</b>';

			elseif ( is_author() ) :
					global $author;
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					$userdata = get_userdata($author);
					echo ' ' . $delimiter . ' ';
					echo '<b>Articles posted <i>by:</i> ' . $userdata->display_name .'</b>';

			elseif ( is_404() ) :
					global $author;
			echo '<a href="' . WP_SITES_URL . ' " title="Home">'.get_option('blogname').'</a>';
					$userdata = get_userdata($author);
					echo ' ' . $delimiter . ' ';
					echo '404 Error</b>';
			endif;

			if ( get_query_var('paged') ) {
					echo ' ' . $delimiter . ' ';
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
					echo __('Page') . ' ' . get_query_var('paged');
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

    }


    /**
     * Function for get the price
     * TODO determine why this function is here
     * @author Onnay Okheng
     *
     * @global $wpsc $wpsc_query
     * @global $wpdb $wpdb
     * @global $wpsc $wpsc_variations
     * @param integer $id
     * @param boolean $forRSS
     * @return string
     */
    function tk_product_price($id, $forRSS = false) {
        global $wpsc_query, $wpdb, $wpsc_variations;

        if ( is_object($wpsc_variations) && count( $wpsc_variations->first_variations ) > 0 ) {
                //select the variation ID with lovest price
                $product_id = $wpdb->get_var('SELECT `posts`.`id` FROM ' . $wpdb->posts . ' `posts` JOIN ' . $wpdb->postmeta . ' `postmeta` ON `posts`.`id` = `postmeta`.`post_id` WHERE `posts`.`post_parent` = ' . $id . ' AND `posts`.`post_type` = "wpsc-product" AND `posts`.`post_status` = "inherit" AND `postmeta`.`meta_key`="_wpsc_price" ORDER BY (`postmeta`.`meta_value`)+0 ASC LIMIT 1');
                $from = ' from ';
        } else {
                $product_id = $id;
                $from = '';
        }
        $from = apply_filters('wpsc_product_variation_text',$from);
        $price = get_product_meta( $product_id, 'price', true );
        if($forRSS)
                $output = $from.wpsc_currency_display( $price, array( 'display_as_html' => false ) );
        else
                $output = $from.wpsc_currency_display( $price );
        return $output;
    }

    /**
     * This function for get random post with taxonomy
     *
     * @param string $post_type
     * @param integer $number_post
     * @param string $orderby
     * @return object
     */
    function tk_get_random($post_type = 'post', $number_post = 5, $orderby = 'rand'){
        $args       = array( 'post_type' => $post_type, 'numberposts' => $number_post, 'orderby' => $orderby );
        $rand_posts = get_posts( $args );

        return $rand_posts;
    }


    /**
     * Function for displaying count of post type.
     *
     * @param string $type
     */
    function tk_count_post($type = 'post' ){
        echo wp_count_posts($type)->publish;
    }


    /*  this function is for comment paginating
     *  by Bilhasry Ramadhony
     */
    function tk_wp_paginate_comments($num = 5, $type = 'comments', $range = 5) {
	return tk_paginate($num, $type, $range);
    }

    function tk_paginate($num = 5, $type = 'comments', $range = 5) {
        $max =0;

        if ($type === 'comments'):
            if((intval($num) % intval($range))!=0)
                $max=intval($num)/ intval($range) + 1;
            else
                $max=intval($num)/ intval($range);

            tk_paginate_loop($max,0,$range);
        endif;
    }

    /**
     * Helper function for pagination which builds the page links.
     */
    function tk_paginate_loop($max = 5, $page = 1, $range = 5) {
        $output = "";
        for ($i = 1; $i <= $max; $i++) {
            $link   = get_comments_pagenum_link($i);
            $output .= '<li><a href="'.$link.'" title="'.$i.'">'.$i.'</a></li>';
        }
        echo $output;
    }

    /**
     * Displaying also bought product.
     *
     * @global $wpdb $wpdb
     * @param integer $product_id
     * @param integer $also_bought_limit
     * @return string
     */
    function tk_also_bought( $product_id, $also_bought_limit = 9 ) {
            /*
             * Displays products that were bought aling with the product defined by $product_id
             * most of it scarcely needs describing
             */
            global $wpdb;

            if ( get_option( 'wpsc_also_bought' ) == 0 ) {
                    //returns nothing if this is off
                    return '';
            }

            $output = '';
            $also_bought = $wpdb->get_results( "SELECT `" . $wpdb->posts . "`.* FROM `" . WPSC_TABLE_ALSO_BOUGHT . "`, `" . $wpdb->posts . "` WHERE `selected_product`='" . $product_id . "' AND `" . WPSC_TABLE_ALSO_BOUGHT . "`.`associated_product` = `" . $wpdb->posts . "`.`id` AND `" . $wpdb->posts . "`.`post_status` IN('publish','protected') ORDER BY `" . WPSC_TABLE_ALSO_BOUGHT . "`.`quantity` DESC LIMIT $also_bought_limit", ARRAY_A );
            if ( count( $also_bought ) > 0 ) {
                    $output .= '<div class="wpsc_also_bought_wrap">';
                    $output .= "<h2 class='wpsc_also_bought_title' >" . __( 'People who bought this item also bought', 'ieclothing' ) . "</h2>";
                    $output .= '<div class="wpsc_also_bought_container">';
                    $output .= "<div class='wpsc_also_bought'>";
                    foreach ( (array)$also_bought as $also_bought_data ) { 
                            $output .= "<div class='wpsc_also_bought_item' style='width:100px;'>";
                            if ( get_option( 'show_thumbnails' ) == 1 ) {
                                    if ( has_post_thumbnail($also_bought_data['ID']) ) {
                                            $output .= "<a href='" . get_permalink($also_bought_data['ID']) . "' class='preview_link'  rel='" . str_replace( " ", "_", get_the_title($also_bought_data['ID']) ) . "'>";                                            
                                            $output .= get_the_post_thumbnail($also_bought_data['ID'], 'product');
                                            $output .= "</a>";
                                    } else {
                                            if ( get_option( 'product_image_width' ) != '' ) {
                                                    $output .= "<img src='" . WPSC_CORE_IMAGES_URL . "/no-image-uploaded.gif' title='" . get_the_title($also_bought_data['ID']) . "' alt='" . $also_bought_data['name'] . "' width='$image_display_height' height='$image_display_height' id='product_image_" . $also_bought_data['ID'] . "' class='product_image' />";
                                            } else {
                                                    $output .= "<img src='" . WPSC_CORE_IMAGES_URL . "/no-image-uploaded.gif' title='" . get_the_title($also_bought_data['ID']) . "' alt='" . htmlentities( stripslashes( get_the_title($also_bought_data['ID']) ), ENT_QUOTES, 'UTF-8' ) . "' id='product_image_" . $also_bought_data['ID'] . "' class='product_image' />";
                                            }
                                    }
                            }

                            $output .= "<a class='wpsc_product_name' href='" . get_permalink($also_bought_data['ID']) . "'>" . get_the_title($also_bought_data['ID']) . "</a>";
                            $price = get_product_meta($also_bought_data['ID'], 'price', true);
                            $special_price = get_product_meta($also_bought_data['ID'], 'special_price', true);
                            if(!empty($special_price)){
                                    $output .= '<span style="text-decoration: line-through;">' . wpsc_currency_display( $price ) . '</span>';
                                    $output .= wpsc_currency_display( $special_price );
                            } else {
                                    $output .= wpsc_currency_display( $price );
                            }
                            $output .= "</div>";
                    }
                    $output .= "</div>";
                    $output .= "</div>";
                    $output .= "</div>";
            }
            return $output;
    }

    /**
     * Get query for related products
     *
     * @param integer $postid
     * @param string $posttype
     * @param string $taxonomy
     * @param integer $showpost
     * @param boolean $other
     * @return WP_Query
     */
    function tk_related_products( $postid, $posttype = 'post' , $taxonomy = 'category', $showpost = 4, $other = true ){

        $product_cat = wp_get_object_terms($postid, $taxonomy);
        foreach ($product_cat as $cat_item) {
            $cat_array_name_list[] = $cat_item->slug;
        }

        $query = array (
            'showposts' => $showpost,
            'orderby'   => 'rand',
            'post_type' => $posttype,
            'tax_query' => array(
                    array(
                            'taxonomy'  => $taxonomy,
                            'field'     => 'slug',
                            'terms'     => $cat_array_name_list
                    )
            ),
            'post__not_in' => array ($postid),
        );
        $related_product = new WP_Query($query);

        if(!$related_product->have_posts() && $other){

             $query = array (
                'showposts' => $showpost,
                'orderby'   => 'rand',
                'post_type' => $posttype,
                'post__not_in' => array ($postid),
            );
            $related_product = new WP_Query($query);
        }

        return $related_product;
            
    }

    /**
     * For display comment on single product
     *
     * @param integer $prodid
     */
    function tk_comments($prodid){

            /* this script has modified from the plugin
             * @author Onnay Okheng
             */

            $output = '';
            $meta_product   = get_post_meta( $prodid, '_wpsc_product_metadata', true );
            $enable_comment = $meta_product['enable_comments'];

            if ( get_option( 'wpsc_enable_comments' ) == 1 && $enable_comment == 1 ) {
                    $output = "<script>
                                    var idcomments_acct = '" . esc_js( get_option( 'wpsc_intense_debate_account_id' ) ) . "';
                                    var idcomments_post_id = 'product_" . $prodid . "';
                                    var idcomments_post_url = encodeURIComponent('" . wpsc_product_url( $prodid, null, false ) . "');
                                    </script>
                                    <span id=\"IDCommentsPostTitle\" style=\"display:none\"></span>
                                    <script type='text/javascript' src='https://www.intensedebate.com/js/genericCommentWrapperV2.js'></script>
                                    ";
                    echo $output;
            } elseif ($enable_comment == 1) {
                    comments_template( '', true );
            }else {
                _e('Comment is closed', 'ieclothing');
            }
    }

    /**
     * Retrieve a post's terms as a list with specified format no link.
     *
     *
     * @param int $id Post ID.
     * @param string $taxonomy Taxonomy name.
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string
     */
    function tk_get_the_term_list( $id = 0, $taxonomy, $before = '', $sep = '', $after = '', $unlink = true ) {
            $terms = get_the_terms( $id, $taxonomy );

            if ( is_wp_error( $terms ) )
                    return $terms;

            if ( empty( $terms ) )
                    return false;

            if ($unlink){
                    foreach ( $terms as $term ) {
                            $term_links[] =  $term->name;
                    }
            } else {
                    foreach ( $terms as $term ) {
                            $link = get_term_link( $term, $taxonomy );
                            if ( is_wp_error( $link ) )
                                    return $link;
                            $term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';
                    }
            }

            $term_links = apply_filters( "term_links-$taxonomy", $term_links );

            return $before . join( $sep, $term_links ) . $after;
    }
    
    /**
     * For integration with facebook apps.
     * Auto include on wp_head.
     */
    function tk_add_facebook_pages(){
        if(get_option('tk_fb_appid') != '' && get_option('tk_fb_secret') != ''){
            define('TK_FB_DIR',   TK_INCLUDES_DIR        . '/facebook');

            require_once TK_FB_DIR . '/src/facebook.php';

            // Create our Application instance.
            $facebook = new Facebook(array(
                      'appId'   => get_option('tk_fb_appid'),
                      'secret'  => get_option('tk_fb_secret'),
                      'cookie'  => true,
            ));
        }
    }
    add_action('wp_head', 'tk_add_facebook_pages');
    
    
################################################################################
// Add meta for facebook
################################################################################
    
    add_action('wp_head', 'tk_head_facebook');
    function tk_head_facebook(){
        
        if (tk_is_single_product()){
            global $post;
            $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
            
            echo "\n".'<meta property="og:url" content="'.get_permalink($post->ID) .'" />';
            echo "\n".'<meta property="og:description" content="'.$post->post_content.'" />';
            echo "\n".'<meta property="og:image" content="'.$image_url[0].'" />'." \n";
        }
    }

?>
