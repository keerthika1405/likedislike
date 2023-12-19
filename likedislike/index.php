

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
       
    <title>like/dislike </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/fe459689b4.js"> </script>

   
</head>

<style media="screen">
        .selected{
            color: green;
            outline:1px solid black;
           
        }
</style>
<body>

<?php

$user_id=8;
require 'config.php';

 $posts = mysqli_query( $conn, 'SELECT * FROM posts');
 foreach($posts as $post): 

         $post_id = $post["id"]; // Post's ID
        
         $likesCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS likes FROM ratings WHERE post_id = $post_id AND status = 'like' "))['likes'];
        $dislikesCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS dislikes FROM ratings WHERE post_id = $post_id AND status = 'dislike' "))['dislikes'];
         $status = mysqli_query($conn, "SELECT `status` FROM ratings WHERE post_id = $post_id AND user_id = $user_id");
        
        if ($statusResult = mysqli_query($conn, "SELECT `status` FROM ratings WHERE post_id = $post_id AND user_id = $user_id"))
        {
        if(mysqli_num_rows($status) > 0){
        $status = mysqli_fetch_assoc($status)['status']; // Current user's rating status
        }
        else{
        $status = 0; // If user has not rated yet
        }
        }

?>


<div class="post">
<h2><?php echo $post["title"];?> </h2>

<button  class=" like <?php if($status ==  'like') echo "selected"; ?>" data-post-id = <?php echo $post_id; ?>>
<i class="fa fa-thumbs-up fa-lg"></i>
<span class=".likes_count <?php echo $post_id; ?>" data-count = <?php echo $likesCount; ?>><?php  echo $likesCount; ?></span>
</button>

<button  class="dislike <?php if($status == 'dislike') echo "selected"; ?>" data-post-id = <?php echo $post_id; ?>>
<i class="fa fa-thumbs-down fa-lg"></i>
<span class=".dislikes_count <?php echo $post_id; ?>" data-count = <?php echo $dislikesCount; ?>><?php  echo $dislikesCount; ?></span>
</button>
</div> 




<?php  
 endforeach; 
 ?>








<script type="text/javascript">

$(document).ready(function () {

$('.like, .dislike').click(function(){
   



var data = {
post_id: $(this).data('post-id'),
user_id: <?php echo $user_id; ?>,
status: $(this).hasClass('like') ? 'like': 'dislike',
};

console.log('Data:', data);

$.ajax({
url: 'function.php',
type: 'post',
data: data,

success:function(response){
 

var post_id = data['post_id'];

var likes = $('.likes_count'+ post_id);
var likesCount = likes.data('count');

var dislikes = $('.dislikes_count' + post_id); 
var dislikesCount = dislikes.data('count');

var likeButton = $(".like[data-post-id=" + post_id + "]");
var dislikeButton = $(".dislike[data-post-id=" + post_id + "]");



if(response == 'newlike'){
likes.html(likesCount + 1);
likeButton.addClass('selected');
}

else if (response == 'newdislike'){ 
dislikes.html(dislikesCount + 1);
dislikeButton.addClass('selected');
}


else if (response == 'changetolike'){
likes.html(parseInt($('.likes_count' + post_id).text()) + 1);
dislikes.html(parseInt($('.dislikes_count'+ post_id).text()) - 1);
likeButton.addClass('selected');
dislikeButton.removeClass('selected');
}
else if(response == 'changetodislike'){ 
likes.html (parseInt($('.likes_count' + post_id).text()) - 1);
dislikes.html(parseInt($('.dislikes_count'+ post_id).text()) + 1); 
likeButton.removeClass('selected');
dislikeButton.addClass('selected');
}



else if (response =='deletelike'){
likes.html(parseInt($('.likes_count' + post_id).text()) - 1);
likeButton.removeClass('selected');
}

else if (response =='deletedislike'){
dislikes.html(parseInt($('.dislikes_count' + post_id).text()) - 1);
dislikeButton.removeClass('selected');
}
}



})
});
});

</script>

</body>
</html>
