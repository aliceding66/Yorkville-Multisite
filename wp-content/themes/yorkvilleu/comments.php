






           










<div class="comments">
                
<a id="comments"></a>


<span id="ctl00_ctl00_mainContent_columnOneContent_CommentView_commentView_lblTitle" class="BlogCommentsTitle"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?>
<?php if ( comments_open() ) : ?>
	<a href="#postcomment" title="<?php _e("Leave a comment"); ?>">&raquo;</a>
<?php endif; ?>
</span>

<?php if ( $comments ) : ?>
<ol id="commentlist">

<?php foreach ($comments as $comment) : ?>
	<li id="comment-<?php comment_ID() ?>">
  <?php echo get_avatar( $comment, 32 ); ?>  
	<?php comment_text() ?>
	<p><cite><?php comment_type(__('Comment'), __('Trackback'), __('Pingback')); ?> <?php _e('by'); ?> <?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite> <?php edit_comment_link(__("Edit This"), ' |'); ?></p>
	</li>

<?php endforeach; ?>

</ol>

<?php else : // If there are no comments yet ?>
	<p><?php _e('Blog post currently doesn\'t have any comments.'); ?></p>
<?php endif; ?>



<?php if ( comments_open() ) : ?>
<span id="ctl00_ctl00_mainContent_columnOneContent_CommentView_commentView_lblLeaveCommentLnk" class="BlogLeaveComment"><?php _e('Leave a comment'); ?></span>



<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<table class="BlogPanel">
    <tbody><tr>
        <td>
      
<div class="CommentFormContainer">
    <ul class="commentForm">
        <li class="name">
            
            <div class="label BlogCommentName ">
                <label for="author" id="author">Name:</label>
            </div>
            <div id="ctl00_ctl00_mainContent_columnOneContent_CommentView_commentView_ctrlCommentEdit_pnlName" class="inputWrapper">
		
               
                <input type="text" name="author"  id="author" class="TextBoxField" value="<?php echo $comment_author; ?>" maxlength="200"  />
                
                <br>
            
	</div>
            
        </li>
        <li class="email">
            
            <div class="label BlogCommentEmail ">
                <label for="email" id="email">E-mail:</label>
            </div>
            <div id="ctl00_ctl00_mainContent_columnOneContent_CommentView_commentView_ctrlCommentEdit_pnlEmail" class="inputWrapper">
		

                <input type="text" name="email" value="<?php echo $comment_author_email; ?>" maxlength="250" id="email" class="TextBoxField" />
                <br>
            
	</div>
           
        </li>
        <li class="url">
            
            <div class="label BlogCommentUrl ">
                <label for="url" id="url">Your URL:</label>
            </div>
            <div id="ctl00_ctl00_mainContent_columnOneContent_CommentView_commentView_ctrlCommentEdit_pnlUrl" class="inputWrapper url">
              <input type="text" name="url" value="<?php echo $comment_author_url; ?>" maxlength="450" id="url" class="TextBoxField" />
              
            </div>
        </li>
        <li class="comments">
            
            <div class="label BlogCommentComments ">
                <label for="comment" id="comment">Comments:</label>
            </div>
            <textarea name="comment" rows="4" cols="20" id="comment" class="TextAreaField"></textarea>
           <br>
            
        </li>
        
        
         
        
        
          
        
        
            <li class="submit">
                <div class="BlogRequiredValidator">
                <input name="submit" type="submit" value="<?php echo attribute_escape(__('Submit Comment')); ?>" id="submit" class="SubmitButton" tabindex="5"/>
           
                <?php comment_id_fields(); ?>
                   
                </div>
            </li>
        
    </ul>
</div>

</td></tr></tbody></table>





<?php do_action('comment_form', $post->ID); ?>
 
</form>
 

<?php else : // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php endif; ?>
 </div>