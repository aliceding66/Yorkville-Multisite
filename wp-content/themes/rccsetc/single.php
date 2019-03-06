<?php get_header(); header("HTTP/1.0 404 Not Found"); ?>
 <!-- BreadCrumbs menu --> 

<div class="CMSBreadCrumbs"><a href="/" title="HOME">HOME</a>&nbsp;&nbsp;/&nbsp;&nbsp;
</div>

     <div class="firstColumn oneColumn">
        <div class="title interior"> 
            <h1>404 - Page Not Found</h1>
        </div>
        <p style="font-size: x-large; color: #419639">Page Not Found.</p>
<p style="font-size: large; ">The requested URL was not found on this server.</p>
<p style="font-size: medium; height: 400px;">The page you are looking for might have been removed, had its name changed or is temporarily unavailable. This is the School of Engineering Technology &amp; Computing's new website - some page addresses have changed. Go to <a href="<?php echo site_url(); ?>/">homepage</a> to navigate to where you would like to go.</p>
        <a href="#" target="_top" class="toTop">
            <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
        </a>
    </div>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>