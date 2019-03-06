 <!-- Footer -->
        


<div class="footerShareThisWrapper">
    <div class="footerShareThis">
        <span  class='st_sharethis_button' displayText='ShareThis'></span>
    </div>
</div>
<ul class="sponsors logo_bottom_t">
<li>
<img src="<?php echo get_template_directory_uri(); ?>/logos/RCC_logo.png" alt="RCC Institute of Technology" />
<a target="_blank" href="http://www.rccit.ca/  " title="Ontario" rel="nofollow">Ontario</a>
</li>
<li><img src="<?php echo get_template_directory_uri(); ?>/logos/Yorkville_logo.png" alt="Yorkville University" />
<a href="http://www.yorkvilleu.ca/about/provincial-approvals/new-brunswick/" title="New Brunswick" >New Brunswick</a>
<a href="http://www.yorkvilleu.ca/about/provincial-approvals/british-columbia/" title="British Columbia">British Columbia</a>
</li>

<li>
<img src="<?php echo get_template_directory_uri(); ?>/logos/TFS_RCC_logo.png" alt="Toronto Film School" />
<a target="_blank" href="http://www.torontofilmschool.ca/" title="Ontario" rel="nofollow">Ontario</a>
<a target="_blank" href="http://online.torontofilmschool.ca/programs/" title="New Brunswick" rel="nofollow">New Brunswick</a>
</li>
</ul>
<div class="footer">
    <ul class="quicklinks">
            <li class="rightBorder">
                <a id="ctl00_ctl00_BottomFooter_lnkPrograms" class="title" href="<?php echo site_url(); ?>/programs/">PROGRAMS</a>
                
                

		<?php  
        $menu_program = array(
			
			'menu_class'      =>'CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'theme_location'  => 'footer-menu-program' 
			
		);
		wp_nav_menu( $menu_program); ?>




            </li>
            <li class="rightBorder leftBorder">
                <a href="<?php echo site_url(); ?>/about/" class="title" title="About">ABOUT</a>
                
	<?php  
        $menu_about = array(
			
			'menu_class'      =>'CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'about-menu' 
			
		);
		wp_nav_menu( $menu_about); ?>


            </li>
            <li class="rightBorder leftBorder">
                <a href="<?php echo site_url(); ?>/admissions/" class="title" title="Admissions">ADMISSIONS</a>
                
	<?php  
        $menu_about = array(
			
			'menu_class'      =>'CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'admissions' 
			
		);
		wp_nav_menu( $menu_about); ?>

<br />
                <a id="ctl00_ctl00_BottomFooter_lnkNewsEvents" class="title" href="<?php echo site_url(); ?>/news-events/">NEWS & EVENTS</a>
                
                
	<?php  
        $menu_about = array(
			
			'menu_class'      =>'CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'news-events' 
			
		);
		wp_nav_menu( $menu_about); ?>


            </li>
            <li class="leftBorder">
                <a href="<?php echo site_url(); ?>/resources/" class="title" title="Resources">RESOURCES</a>
                
	<?php  
        $menu_about = array(
			
			'menu_class'      =>'CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'resources' 
			
		);
		wp_nav_menu( $menu_about); ?>

<br />
                <a href="<?php echo site_url(); ?>/international-students/" class="title" title="International Students">INTERNATIONAL STUDENTS</a><br />
                <a href="<?php echo site_url(); ?>/contact-us/" class="title" title="Contact Us">CONTACT US</a>
            </li>
    </ul>
    <ul class="copyrightPrivacy">
        <li class="copyright">
            &copy; 2003-<?php echo date('Y'); ?> RCC Institute of Technology
			
        </li>
        <li class="privacy">
            <a href="<?php echo site_url(); ?>/privacy-statement/" title="Privacy Statement">Privacy Statement</a><span class="RCCSETCColor">  |  </span>
            <a href="<?php echo site_url(); ?>/copyright-notice/" title="Copyright Notice">Copyright Notice</a><span class="RCCSETCColor">  |  </span>
            <a href="<?php echo site_url(); ?>/sitemap/" title="Sitemap">Sitemap</a>
        </li>
    </ul>
</div>

    
<script type="text/javascript">
//<![CDATA[
var skm_subMenuIDs =  new Array('ctl00_ctl00_headerTopNavigation_menuElem-001-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-001-subMenu-004-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu-000-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu-000-subMenu-002-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu-000-subMenu-010-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu-001-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu-002-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu-003-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-003-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu-000-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu-001-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu-004-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu-008-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-005-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-005-subMenu-004-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-005-subMenu-005-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-006-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem-007-subMenu', 'ctl00_ctl00_headerTopNavigation_menuElem');
//]]>
</script>


<script type="text/javascript">skm_registerMenu('ctl00_ctl00_headerTopNavigation_menuElem',new skm_styleInfo('','','','','','','','','',''),new skm_styleInfo('','','','','','','','','',''),2,false);</script></form>


    <script type="text/javascript">

        var re = new RegExp("\\d{3}"); //regex: Find 3 repetitions of a digit.
        var hoverMenuID;
        var menuIdToHighlightActive;
        var characterCount;
        //$('.SubCMSMenu, .SubCMSMenuItem, .navigation, .SubCMSMenuHighlightedMenuItem').hover(function () {
        jQuery('.SubCMSMenu, .SubCMSMenuItem, .navigation, .SubCMSMenuHighlightedMenuItem').hover(function () {
            //hoverMenuID = re.exec($(this).attr('id'));
            hoverMenuID = re.exec(jQuery(this).attr('id'));
            menuIdToHighlightActive = "ctl00_ctl00_headerTopNavigation_menuElem-" + hoverMenuID;
            //$('#' + menuIdToHighlightActive).addClass('active');
            jQuery('#' + menuIdToHighlightActive).addClass('active');
            //note: 'active' class is removed in 'CMSScript/skmmenu.js'. This is to avoid removing 'active' state immediatly when mouse
            //leaves hover postion (Kentico menu by default has 1000 delay).
        });

        //$(document).ready(function () {
        jQuery(document).ready(function ($) {
            //Issue: Kentico webpart property 'EnableMouseUpDownClass' does not seem to work. Possible bug. 
            //Resolution: remove 'onmousedown' and 'onmouseup' events manually.
            $('.navigation, .SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').removeAttr('onmousedown');
            $('.navigation, .SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').removeAttr('onmouseup');
			

            $('.SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').each(function (index) {

                //Issue: Kentico webpart property does not allow markup in page names
                //Resolution: Break lines manually
                characterCount = $(this).find('a').text().length;
                
                //var stringWithLineBreak = $(this).html().replace("&amp;", "&amp; <br />");
                //$(this).html(stringWithLineBreak);
                
                // set styles based on two line layout:
                //if ($(this).html().match(/<br \/>/) || $(this).html().match(/<br>/) || characterCount > 30) {
                if (characterCount > 30) {
                    $(this).css('background-position', '0 -122px');
                    $(this).css('padding-bottom', '5px');
                    $(this).find('img').css('margin-top', '-10px');
                }
            });

            //  Issue: Kentico does not support first/last for CMSMenu.
            //  Resolution: Manually replace with background that contains no top border line for static, mouse over and mouse out.
            $('.SubCMSMenu').each(function (index) {
                $(this).find('.SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').first().addClass('firstListItem');
                //$(this).find('.SubCMSMenuItem').last().addClass('lastListItem');

                mouseout = $(this).find('.SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').first().attr('onmouseout');
                mouseout = mouseout.replace("SubCMSMenuItem", "SubCMSMenuItem firstListItem");
                $(this).find('.SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').first().attr('onmouseout', mouseout);

                mouseover = $(this).find('.SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').first().attr('onmouseover');
                mouseover = mouseover.replace("SubCMSMenuItemMouseOver", "SubCMSMenuItemMouseOver firstListItem");
                $(this).find('.SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').first().attr('onmouseover', mouseover);
            });


            //Issue: Spritemaps are images, so they do not cover two lines by default. 
            //Resolution: Load a seperate spritemap position for an image that covers both lines.

            $('.SubCMSMenuItem, .SubCMSMenuHighlightedMenuItem').hover(function () {
                characterCount = $(this).find('a').text().length;
                //if ($(this).html().match(/<br \/>/) || $(this).html().match(/<br>/) || characterCount > 30) {
                if (characterCount > 30) {
                    $(this).css('background-position', '0 -185px');
                }
            }, function () {
                characterCount = $(this).find('a').text().length;
                //if ($(this).html().match(/<br \/>/) || $(this).html().match(/<br>/) || characterCount > 30) {
                if (characterCount > 30) {
                    $(this).css('background-position', '0 -122px');
                }
            });

            $('.SubCMSMenuHighlightedMenuItem').each(function () {
                characterCount = $(this).find('a').text().length;
                //if ($(this).html().match(/<br \/>/) || $(this).html().match(/<br>/) || characterCount > 30) {
                if (characterCount > 30) {
                    $(this).css('background-position', '0 -185px');
                }
            });
        });
    </script>
    <!-- Live Chat code -->
    
   

    

   <script>
  (function() {
    var cx = '008071783343381868527:87ww9x-iwvs';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>

    
</body>
</html>