<?php
/*
Template Name: Clean & Empty
*/
?>


<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

                <!-- Page Content -->         
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

          <h1><?php the_title(); ?></h1>
          <?php the_content(); ?>
                 

            <a href="#" target="_top" class="toTop">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
            </a>

        </div>     

		
       
     <?php endwhile;?>
    <?php endif;?>

<?php  get_footer();?>



<script type="text/javascript">
setTimeout(function(){
	//alert("loaded");
    var mec_fes_form_ajax = false;
    jQuery("#mec_fes_form").on("submit", function(event)
    {
        event.preventDefault();
		
		//alert("do submit");
        
        // Hide the message
        jQuery("#mec_fes_form_message").removeClass("mec-success").removeClass("mec-success").html("").hide();

        // Add loading Class to the form
        jQuery("#mec_fes_form").addClass("loading");
        
        // Fix WordPress editor issue
        jQuery("#mec_fes_content-html").click();
        jQuery("#mec_fes_content-tmce").click();
        
        // Abort previous request
        if(mec_fes_form_ajax) mec_fes_form_ajax.abort();
        
        var data = jQuery("#mec_fes_form").serialize();
        mec_fes_form_ajax = jQuery.ajax(
        {
            type: "POST",
            url: "/wp-admin/admin-ajax.php",
            data: data,
            dataType: "JSON",
            success: function(response)
            {
                // Remove the loading Class from the form
                jQuery("#mec_fes_form").removeClass("loading");
                
                if(response.success == "1")
                {
					
					//alert("do success");
					
					window.location="/event-now-pending";
		
                    // Show the message
                    jQuery("#mec_fes_form_message").removeClass("mec-success").addClass("mec-success").html(response.message).css("display","inline-block");
                    
                    // Set the event id
                    jQuery("#mec_fes_post_id").val(response.data.post_id);
                }
                else
                {
					
						//alert("do FAIL");
                    // Show the message
                    jQuery("#mec_fes_form_message").removeClass("mec-error").addClass("mec-error").html(response.message).css("display","inline-block");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
					//alert("do ERROR");
                // Remove the loading Class from the form
                jQuery("#mec_fes_form").removeClass("loading");
            }
        });
    });
},2000);

function mec_fes_upload_featured_image()
{
    var fd = new FormData();
    fd.append("action", "mec_fes_upload_featured_image");
    fd.append("_wpnonce", "'.wp_create_nonce('mec_fes_upload_featured_image').'");
    fd.append("file", jQuery("#mec_featured_image_file").prop("files")[0]);
    
    jQuery.ajax(
    {
        url: "'.admin_url('admin-ajax.php', NULL).'",
        type: "POST",
        data: fd,
        dataType: "json",
        processData: false,
        contentType: false
    })
    .done(function(data)
    {
        jQuery("#mec_fes_thumbnail").val(data.data.url);
        jQuery("#mec_featured_image_file").val("");
        jQuery("#mec_fes_thumbnail_img").html("<img src=\""+data.data.url+"\" />");
        jQuery("#mec_fes_remove_image_button").removeClass("mec-util-hidden");
    });
    
    return false;
}
</script>