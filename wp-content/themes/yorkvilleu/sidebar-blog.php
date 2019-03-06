<div class="twoColumn secondColumn blog">
            <div class="toolbarTitle">
<h2 class="title">Student Stories</h2>
<div class="content">
                
<p>&nbsp;</p>

            </div>
</div>




            <div class="toolbarTags">
<h2 class="title">TAGS</h2>
<div class="content">
                 
<div class="TagCloud">
    
</div>
            </div>
</div>
<img class="toolbar divider" src="<?php echo get_template_directory_uri(); ?>/images/blogToolbarDivider.png">


            <div class="toolbarGeneral">
<h2 class="title">RECENT POSTS</h2>
<div class="content">
                
<ul>
<?php
	$args = array( 'category' => '14', 'numberposts' => '5' );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a><br><br> </li> ';
	}
?>
</ul><br><br>


            </div></div>
<img class="toolbar divider" src="<?php echo get_template_directory_uri(); ?>/images/blogToolbarDivider.png">

            <div class="toolbarGeneral">
<h2 class="title">POST ARCHIVE</h2>
<div class="content">
               
<ul><?php wp_get_archives('cat=14&type=monthly&&limit=4'); ?></ul><br>

            </div></div>
<img class="toolbar divider" src="<?php echo get_template_directory_uri(); ?>/images/blogToolbarDivider.png">

             <div class="toolbarRss">
<div class="content">
                
<a id="ctl00_ctl00_mainContent_columnOneContent_wpcrptSyndication_RSSFeed_lnkFeedImg" class="FeedLink" href="<?php echo site_url(); ?>/news/blog/feed/"><img id="ctl00_ctl00_mainContent_columnOneContent_wpcrptSyndication_RSSFeed_imgFeed" class="FeedIcon" src="<?php echo get_template_directory_uri(); ?>/images/16.png" alt="Blog posts" style="border-width:0px;"></a><a id="ctl00_ctl00_mainContent_columnOneContent_wpcrptSyndication_RSSFeed_lnkFeedText" class="FeedLink" href="<?php echo site_url(); ?>/news/blog/feed/"><span id="ctl00_ctl00_mainContent_columnOneContent_wpcrptSyndication_RSSFeed_ltlFeed" class="FeedCaption">RSS Feed</span></a>

            </div></div>

            </div>