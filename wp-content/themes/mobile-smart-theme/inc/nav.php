<div class="navigation"><div class="clear"></div>

<?php
$prev_link = get_previous_posts_link(__('Newer Posts &raquo;'));
$prev_link = str_replace("www", "m", $prev_link);
$next_link = get_next_posts_link(__('&laquo; Older Posts'));
$next_link = str_replace("www", "m", $next_link);
// as suggested in comments

  if ($prev_link){
    echo '<div class="prev-posts">'.$prev_link.'<div class="clear"></div></div>';
  }
  if ($next_link){
    echo '<div class="next-posts">'.$next_link.'<div class="clear"></div></div>';
  }

?>

    <div class="clear"></div>
</div>