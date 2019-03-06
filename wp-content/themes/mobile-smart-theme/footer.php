</div>

<div class="loga_dolu">
	<div class="loga_conteiner">
	
<ul class="sponsors logo_bottom_t">
<li><img src="<?php echo get_template_directory_uri(); ?>/logos/Yorkville_logo.png" alt="Yorkville University" />
<a href="http://www.yorkvilleu.ca/about/provincial-approvals/new-brunswick/" title="New Brunswick" >New Brunswick</a>
<a href="http://www.yorkvilleu.ca/about/provincial-approvals/british-columbia/" title="British Columbia">British Columbia</a>
</li>
<li>
<img src="<?php echo get_template_directory_uri(); ?>/logos/RCC_logo.png" alt="RCC Institute of Technology" />
<a target="_blank" href="http://www.rccit.ca/  " title="Ontario" rel="nofollow">Ontario</a>
</li>
<li>
<img src="<?php echo get_template_directory_uri(); ?>/logos/TFS_RCC_logo.png" alt="Toronto Film School" />
<a target="_blank" href="http://www.torontofilmschool.ca/" title="Ontario" rel="nofollow">Ontario</a>
</li>
<li>
<img src="<?php echo get_template_directory_uri(); ?>/logos/TFS_YU_logo.png" alt="Toronto Film School at Yorkville University" />
<a target="_blank" href="http://online.torontofilmschool.ca/programs/" title="New Brunswick" rel="nofollow">New Brunswick</a>
</li>
</ul>

		<div style="clear: both"></div>
	</div>
</div>
<div style="clear: both"></div>
<div class="footer">
	<div class="footer-in">
	<div class="footer-left">
         <a href="<?php echo site_url(); ?>/?mobile_switch=desktop" class="go-to-full"  style="padding-bottom: 0;padding-top: 5px">Go to full site </a> <a href="http://m.yorkvilleu.ca/privacy-statement/" title="Privacy Statement"  class="go-to-full" style="padding-bottom: 5px;padding-top: 0">Privacy Statement</a>
        <div class="copyright">
            &copy; 2003-<?php echo date('Y'); ?> RCC Institute of Technology | Yorkville Education Company ULC operates as Yorkville University
        </div>
	</div>  
    <div class="footer-social">
    		<a href="http://www.youtube.com/user/YorkvilleUniversity" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png" alt="Youtube"></a>
            <a href="https://www.facebook.com/YorkvilleUniversity" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="Facebook"></a>
            <a href="https://twitter.com/#!/YorkvilleU" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt="Twitter"></a>
            <a href="http://linkd.in/1yNxnr7" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ln.png" alt="LinkedIn"></a>
            <a rel="publisher" href="https://plus.google.com/103371777696708605338/posts" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/googleplus.png" alt="Google Plus"></a>
     </div>
     </div>
     <div style="clear:both"></div>
</div>
<script>
$('ul.courseDescriptions h3.top').click(function(){
	$(this).next().toggle('show');
	$(this).toggleClass('bottom');
});
</script>
<?php wp_footer(); ?>
</body>
</html>
