<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// Get MEC Style Options
$styling = $this->main->get_styling();

// colorskin
$color = '';

if(isset($styling['color']) && $styling['color']) $color = $styling['color'];
elseif(isset($styling['mec_colorskin'])) $color = $styling['mec_colorskin'];

// Typography
$mec_h_fontfamily_arr = $mec_p_fontfamily_arr = $fonts_url = '';

if(isset($styling['mec_h_fontfamily']) && $styling['mec_h_fontfamily'])
{
	$mec_h_fontfamily_arr = $styling['mec_h_fontfamily'];
	$mec_h_fontfamily_arr = str_replace("[", "", $mec_h_fontfamily_arr);
	$mec_h_fontfamily_arr = str_replace("]", "", $mec_h_fontfamily_arr);
	$mec_h_fontfamily_arr = explode(",", $mec_h_fontfamily_arr);
}

if(isset($styling['mec_p_fontfamily']) && $styling['mec_p_fontfamily'])
{
	$mec_p_fontfamily_arr = $styling['mec_p_fontfamily'];
	$mec_p_fontfamily_arr = str_replace("[", "", $mec_p_fontfamily_arr);
	$mec_p_fontfamily_arr = str_replace("]", "", $mec_p_fontfamily_arr);
	$mec_p_fontfamily_arr = explode(",", $mec_p_fontfamily_arr);
}

if((is_array($mec_h_fontfamily_arr) && $mec_h_fontfamily_arr) || (is_array($mec_p_fontfamily_arr) && $mec_p_fontfamily_arr))
{
	//Google font
	$font_families  = array();
	$subsets    	= 'latin,latin-ext';
	$variant_h		= '';
	$variant_p		= '';
	$mec_h_fontfamily_array = '';
	if ( is_array($mec_h_fontfamily_arr) && $mec_h_fontfamily_arr ) :
		foreach($mec_h_fontfamily_arr as $key=>$mec_h_fontfamily_array) {
			if($key != '0') $variant_h .= $mec_h_fontfamily_array .', ';
		}
    endif;

	if ( is_array($mec_p_fontfamily_arr) && $mec_p_fontfamily_arr ) :
		foreach($mec_p_fontfamily_arr as $key=>$mec_p_fontfamily_array) {
			if($key != '0') $variant_p .= $mec_h_fontfamily_array .', ';
		}
	endif;

	$font_families[] = !empty($mec_h_fontfamily_arr[0]) ? $mec_h_fontfamily_arr[0] . ':' . $variant_h : '';
	$font_families[] = !empty($mec_p_fontfamily_arr[0]) ? $mec_p_fontfamily_arr[0] . ':' . $variant_p : '';
    
	if($font_families)
    {
		$fonts_url = add_query_arg(array(
            'family'=>urlencode(implode('|', $font_families)),
            'subset'=>urlencode($subsets),
		), 'https://fonts.googleapis.com/css');
    }
}

ob_start();

// render headings font familty
if($mec_h_fontfamily_arr): ?>
	/* == Custom Fonts For H Tag
		---------------- */
	.mec-wrap h1, .mec-wrap h2, .mec-wrap h3, .mec-wrap h4, .mec-wrap h5, .mec-wrap h6,.entry-content .mec-wrap h1, .entry-content .mec-wrap h2, .entry-content .mec-wrap h3,.entry-content  .mec-wrap h4, .entry-content .mec-wrap h5, .entry-content .mec-wrap h6
	{ font-family: '<?php echo $mec_h_fontfamily_arr[0]; ?>', Helvetica, Arial, sans-serif;}
<?php endif;

// render paragraph font familty
if($mec_p_fontfamily_arr): ?>
	/* == Custom Fonts For P Tag
		---------------- */
	.mec-event-content p, .mec-wrap p { font-family: '<?php echo $mec_p_fontfamily_arr[0]; ?>',sans-serif; font-weight:300;}
<?php endif;

// render colorskin
if($color && $color != '#40d9f1'): ?>
	/* == TextColors
		---------------- */
	.mec-wrap.colorskin-custom .mec-color, .mec-wrap.colorskin-custom .mec-event-sharing-wrap .mec-event-sharing > li:hover a, .mec-wrap.colorskin-custom .mec-color-hover:hover, .mec-wrap.colorskin-custom .mec-color-before *:before ,.mec-wrap.colorskin-custom .mec-widget .mec-event-grid-classic.owl-carousel .owl-controls .owl-buttons i,.mec-wrap.colorskin-custom .mec-event-list-classic a.magicmore:hover,.mec-wrap.colorskin-custom .mec-event-grid-simple:hover .mec-event-title,.mec-wrap.colorskin-custom .mec-single-event .mec-event-meta dd.mec-events-event-categories:before,.mec-wrap.colorskin-custom .mec-single-event-date:before,.mec-wrap.colorskin-custom .mec-single-event-time:before,.mec-wrap.colorskin-custom .mec-events-meta-group.mec-events-meta-group-venue:before,.mec-wrap.colorskin-custom .mec-calendar .mec-calendar-side .mec-previous-month i,.mec-wrap.colorskin-custom .mec-calendar .mec-calendar-side .mec-next-month,.mec-wrap.colorskin-custom .mec-calendar .mec-calendar-side .mec-previous-month:hover,.mec-wrap.colorskin-custom .mec-calendar .mec-calendar-side .mec-next-month:hover,.mec-wrap.colorskin-custom .mec-calendar.mec-event-calendar-classic dt.mec-selected-day:hover,.mec-wrap.colorskin-custom .mec-infowindow-wp h5 a:hover, .colorskin-custom .mec-events-meta-group-countdown .mec-end-counts h3,.mec-calendar .mec-calendar-side .mec-next-month i,.mec-wrap .mec-totalcal-box i,.mec-calendar .mec-event-article .mec-event-title a:hover,.mec-attendees-list-details .mec-attendee-profile-link a:hover
	{color: <?php echo $color; ?>}

	/* == Backgrounds
		----------------- */
	.mec-wrap.colorskin-custom .mec-event-sharing .mec-event-share:hover .event-sharing-icon,.mec-wrap.colorskin-custom .mec-event-grid-clean .mec-event-date,.mec-wrap.colorskin-custom .mec-event-list-modern .mec-event-sharing > li:hover a i,.mec-wrap.colorskin-custom .mec-event-list-modern .mec-event-sharing .mec-event-share:hover .mec-event-sharing-icon,.mec-wrap.colorskin-custom .mec-event-list-modern .mec-event-sharing li:hover a i,.mec-wrap.colorskin-custom .mec-calendar .mec-selected-day,.mec-wrap.colorskin-custom .mec-calendar .mec-selected-day:hover,.mec-wrap.colorskin-custom .mec-calendar .mec-calendar-row  dt.mec-has-event:hover,.mec-wrap.colorskin-custom .mec-calendar .mec-has-event:after, .mec-wrap.colorskin-custom .mec-bg-color, .mec-wrap.colorskin-custom .mec-bg-color-hover:hover, .colorskin-custom .mec-event-sharing-wrap:hover > li, .mec-wrap.colorskin-custom .mec-totalcal-box .mec-totalcal-view span.mec-totalcalview-selected,.mec-wrap .flip-clock-wrapper ul li a div div.inn,.mec-wrap .mec-totalcal-box .mec-totalcal-view span.mec-totalcalview-selected,.event-carousel-type1-head .mec-event-date-carousel,.mec-event-countdown-style3 .mec-event-date,#wrap .mec-wrap article.mec-event-countdown-style1,.mec-event-countdown-style1 .mec-event-countdown-part3 a.mec-event-button,.mec-wrap .mec-event-countdown-style2
	{background-color: <?php echo $color; ?>;}

	

	/* == BorderColors
		------------------ */
	.mec-wrap.colorskin-custom .mec-event-list-modern .mec-event-sharing > li:hover a i,.mec-wrap.colorskin-custom .mec-event-list-modern .mec-event-sharing .mec-event-share:hover .mec-event-sharing-icon,.mec-wrap.colorskin-custom .mec-event-list-standard .mec-month-divider span:before,.mec-wrap.colorskin-custom .mec-single-event .mec-social-single:before,.mec-wrap.colorskin-custom .mec-single-event .mec-frontbox-title:before,.mec-wrap.colorskin-custom .mec-calendar .mec-calendar-events-side .mec-table-side-day, .mec-wrap.colorskin-custom .mec-border-color, .mec-wrap.colorskin-custom .mec-border-color-hover:hover, .colorskin-custom .mec-single-event .mec-frontbox-title:before, .colorskin-custom .mec-single-event .mec-events-meta-group-booking form > h4:before, .mec-wrap.colorskin-custom .mec-totalcal-box .mec-totalcal-view span.mec-totalcalview-selected,.mec-wrap .mec-totalcal-box .mec-totalcal-view span.mec-totalcalview-selected,.event-carousel-type1-head .mec-event-date-carousel:after
	{border-color: <?php echo $color; ?>;}
	.mec-event-countdown-style3 .mec-event-date:after
	{border-bottom-color:<?php echo $color; ?>;}
	.mec-wrap article.mec-event-countdown-style1 .mec-event-countdown-part2:after
	{border-color: transparent transparent transparent <?php echo $color; ?>;}
<?php endif;

// get render content
$out = '';
$out = ob_get_clean();

// minify css
$out = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $out);
$out = str_replace(array("\r\n", "\r", "\n", "\t", '    '), '', $out);

update_option('mec_gfont', $fonts_url);
update_option('mec_dyncss', $out);