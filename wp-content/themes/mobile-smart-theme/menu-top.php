<div class="topmenu">
<div class="topmenu-center">
<?php 
$post_slug=$post->post_name;
$post_parent = $post->post_parent;
$post_parent_id = get_post($post_parent);
$post_parent_slug=$post_parent_id->post_name;



if($post_slug == "scholarships"){
	$title = "FACULTY OF EDUCATION";
	$link = "http://m.yorkvilleu.ca/programs/faculty-of-education/";}
else if($post_parent && $post_parent_slug == "tuition-fees-and-financial-aid"){
	$title = "HOME";
	$link = "http://m.yorkvilleu.ca/";
}else if($post_parent){
	$title = $post_parent_id->post_title;
	$link_get = get_permalink($post_parent_id);
	$link = preg_replace('/www/', 'm', $link_get);
} 
 
else {
$title = "HOME";
$link = "http://m.yorkvilleu.ca/";
}
?>
<a href="<?php echo $link; ?>" class="backbutton"><span> <?php echo $title; ?> </span></a>
<a href="javascript:return false;" onclick="jQuery('#info_accordeon').toggle('show');" class="menubutton"> Menu </a>
<div class="clear"></div>
</div>

</div>
<div id="info_accordeon" style="display: none;border:none !important;">
<?php get_template_part( 'menu', 'home' );?>
</div>
<div class="clear"></div>