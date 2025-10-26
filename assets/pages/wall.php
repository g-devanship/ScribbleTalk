<?php
 global $user;
 global $posts;
 global $follow_suggestions;
 ?>
 <div class="d-flex flex-wrap">
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Treasures">
      #Anime
    </button>
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Treasures">
      #Comicons
    </button>
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add to Treasures">
      #WaltDisney
    </button>
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Treasures">
      #Goofy
    </button> 
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Treasures">
      #TomAndJerry
    </button>
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="right" title="Add to Treasures">
      #ScoobyDoo
    </button>
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add to Treasures">
      #CN
    </button>
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Treasures">
      #LiveActions
    </button> 
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Treasures">
      #Togopi
    </button>
    <button type="button" class="btn btn-secondary m-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Tap for more!">
      > > > > > > >
    </button>
  </div>
    <div class="container col-md-10 col-sm-12 col-lg-9 rounded-0 d-flex justify-content-between">
        <div class="col-md-8 col-sm-12" style="max-width:93vw">

        
            <?php
           
            showError('post_img');
            if(count($posts)<1){
                echo "<p style='width:100%' class='p-2 bg-white border rounded text-center my-3 col-12'>Embrace an Inspirer or Spark a Firework for Bountiful walls!</p>";
            }
foreach($posts as $post){
    $likes = getLikes($post['id']);
    $comments = getComments($post['id']);
    ?>
     <div class="card mt-4">
                <div class="card-title d-flex justify-content-between  align-items-center">

                    <div class="d-flex align-items-center p-2">
                        <img src="assets/images/profile/<?=$post['profile_pic']?>" alt="" height="30" width="30" class="rounded-circle border">&nbsp;&nbsp;<a href='?u=<?=$post['username']?>' class="text-decoration-none text-dark"><?=$post['first_name']?> <?=$post['last_name']?></a>
                    </div>
                    <div class="p-2">
                        <?php
if($post['uid']==$user['id']){
    ?>
<div class="dropdown">
  <i class="bi bi-three-dots-vertical" id="option<?=$post['id']?>" data-bs-toggle="dropdown" aria-expanded="false"></i>

  <ul class="dropdown-menu" aria-labelledby="option<?=$post['id']?>">
    <li><a class="dropdown-item" href="assets/php/actions.php?deletepost=<?=$post['id']?>"><i class="bi bi-trash-fill"></i> Yoink it Away!</a></li>

      </ul>
</div>

    <?php
}
                        ?>
                      
                    </div>
                </div>
                <img src="assets/images/posts/<?=$post['post_img']?>" loading=lazy class="" alt="...">
                <h4 style="font-size: x-larger" class="p-2 border-bottom d-flex">
               <span>
               <?php
if(checkLikeStatus($post['id'])){
$like_btn_display='none';
$unlike_btn_display='';

}else{
    $like_btn_display='';
    $unlike_btn_display='none';  
}
    ?>
                <i class="bi bi-heart-fill unlike_btn text-danger" style="display:<?=$unlike_btn_display?>" data-post-id='<?=$post['id']?>'></i>
                <i class="bi bi-heart like_btn" style="display:<?=$like_btn_display?>" data-post-id='<?=$post['id']?>'></i>

                </span>
                &nbsp;&nbsp;<i
                        class="bi bi-chat-left d-flex align-items-center"><span class="p-1 mx-2 text-small" style="font-size:small" data-bs-toggle="modal" data-bs-target="#postview<?=$post['id']?>"><?=count($comments)?> Thoughts</span></i> 
                        <i class="bi bi-magic d-flex align-items-center"><span class="p-1 mx-2 text-small" style="font-size:small" data-bs-toggle="modal" data-bs-target="#postview<?=$post['id']?>"><?=count($comments)?> Adds to TopTalk</span></i> 
                   
                </h4>
                <div>
                <span class="p-1 mx-2" data-bs-toggle="modal" data-bs-target="#likes<?=$post['id']?>"><span id="likecount<?=$post['id']?>"><?=count($likes)?></span> Fires</span>
                <span style="font-size:small" class="text-muted">Sparked!</span> <?=show_time($post['created_at'])?> 
                 
</div>
              <?php
if($post['post_text']){
    ?>
 <div class="card-body">
                <?=$post['post_text']?>
                </div>
    <?php
}
                ?>
                <div class="input-group p-2 <?=$post['post_text']?'border-top':''?>">
                 
                        <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="Beam-down your thoughts"
                                aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-success rounded-0 border-0 add-comment" data-page='wall' data-cs="comment-section<?=$post['id']?>" data-post-id="<?=$post['id']?>" type="button"
                                id="button-addon2">Spark!</button>
                </div>

            </div>
            <div class="modal fade" id="postview<?=$post['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body d-md-flex p-0">
                    <div class="col-md-8 col-sm-12">
                        <img src="assets/images/posts/<?=$post['post_img']?>" style="max-height:90vh" class="w-100 overflow:hidden">
                    </div>



                    <div class="col-md-4 col-sm-12 d-flex flex-column">
                        <div class="d-flex align-items-center p-2 border-bottom">
                            <div><img src="assets/images/profile/<?=$post['profile_pic']?>" alt="" height="50" width="50" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start">
                                <h6 style="margin: 0px;"><?=$post['first_name']?> <?=$post['last_name']?></h6>
                                <p style="margin:0px;" class="text-muted">@<?=$post['username']?></p>
                            </div>
                            <div class="d-flex flex-column align-items-end flex-fill">
                <div class="" ></div>
                <div class="dropdown">
  <span class="<?=count($likes)<1?'disabled':''?>" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <?=count($likes)?> Fires
</span>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
  <?php
  foreach($likes as $like){
      $lu = getUser($like['user_id']);
      ?>
  <li><a class="dropdown-item" href="?u=<?=$lu['username']?>"><?=$lu['first_name'].' '.$lu['last_name']?> (@<?=$lu['username']?>)</a></li>

      <?php
  }
  ?> 
    
  </ul>
</div>
                <div style="font-size:small" class="text-muted">Sparked! <?=show_time($post['created_at'])?> </div> 
                 
</div>
                        </div>


                        <div class="flex-fill align-self-stretch overflow-auto" id="comment-section<?=$post['id']?>" style="height: 100px;">

                          <?php
if(count($comments)<1){
    ?>
<p class="p-3 text-center my-2 nce">No Thoughts!</p>
    <?php
}
foreach($comments as $comment){
    $cuser = getUser($comment['user_id']);
    ?>
<div class="d-flex align-items-center p-2">
                                <div><img src="assets/images/profile/<?=$cuser['profile_pic']?>" alt="" height="40" width="40" class="rounded-circle border">
                                </div>
                                <div>&nbsp;&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-start align-items-start">
                                    <h6 style="margin: 0px;"><a href="?u=<?=$cuser['username']?>" class="text-decoration-none text-dark text-small text-muted">@<?=$cuser['username']?></a> - <?=$comment['comment']?></h6>
                                    <p style="margin:0px;" class="text-muted">(<?=show_time($comment['created_at'])?>)</p>
                                </div>
                            </div>

    <?php
}
                          ?>

                            
                          

                           

                        </div>
                        <div class="input-group p-2 border-top">
                            <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="Beam-down your Thoughts!"
                                aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-cs="comment-section<?=$post['id']?>" data-post-id="<?=$post['id']?>" type="button"
                                id="button-addon2"></button>
                        </div>
                    </div>



                </div>

            </div>
        </div>
    </div>

            <div class="modal fade" id="likes<?=$post['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fire</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <?php
                if(count($likes)<1){
                    ?>
<p>No Fires!</p>
                    <?php
                }
foreach($likes as $f){

    $fuser = getUser($f['user_id']);
    $fbtn='';
    if(checkBS($f['user_id'])){
continue;
    }else if(checkFollowStatus($f['user_id'])){
        $fbtn = '<button class="btn btn-sm btn-danger unfollowbtn" data-user-id='.$fuser['id'].' >Fizzle</button>';
    }else if($user['id']==$f['user_id']){
        $fbtn='';
    }else{
        $fbtn = '<button class="btn btn-sm btn-primary followbtn" data-user-id='.$fuser['id'].' >Embrace</button>';

    }
    ?>
<div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center p-2">
                        <div><img src="assets/images/profile/<?=$fuser['profile_pic']?>" alt="" height="40" width="40" class="rounded-circle border">
                        </div>
                        <div>&nbsp;&nbsp;</div>
                        <div class="d-flex flex-column justify-content-center">
                            <a href='?u=<?=$fuser['username']?>' class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;"><?=$fuser['first_name']?> <?=$fuser['last_name']?></h6></a>
                            <p style="margin:0px;font-size:small" class="text-muted">@<?=$fuser['username']?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <?=$fbtn?>

                    </div>
                </div>
    <?php
}
                ?>
            </div>
   
        </div>
  </div>
</div>

    <?php
}
            ?>
       
       

        </div>

        <div class="col-lg-4 col-sm-0 overflow-hidden mt-4 p-sm-0 p-md-3">
       

            <div class="d-flex align-items-center p-2">
                <div><img src="assets/images/profile/<?=$user['profile_pic']?>" alt="" height="60" width="60" class="rounded-circle border">
                </div>
                <div>&nbsp;&nbsp;&nbsp;</div>
                <div class="d-flex flex-column justify-content-center">
                <a href='?u=<?=$user['username']?>' class="text-decoration-none text-dark"><h6 style="margin: 0px;"><?=$user['first_name']?> <?=$user['last_name']?></h6></a>
                    <p style="margin:0px;" class="text-muted">@<?=$user['username']?></p>
                </div>
            </div>


            <div>
                <h6 class="text-muted p-2">Level up your Inspiration!</h6>
                <?php
foreach($follow_suggestions as $suser){
    ?>
<div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center p-2">
                        <div><img src="assets/images/profile/<?=$suser['profile_pic']?>" alt="" height="40" width="40" class="rounded-circle border">
                        </div>
                        <div>&nbsp;&nbsp;</div>
                        <div class="d-flex flex-column justify-content-center">
                            <a href='?u=<?=$suser['username']?>' class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;"><?=$suser['first_name']?> <?=$suser['last_name']?></h6></a>
                            <p style="margin:0px;font-size:small" class="text-muted">@<?=$suser['username']?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-success followbtn" data-user-id='<?=$suser['id']?>' >Embrace</button>

                    </div>







                </div>

                
                
    <?php
}

if(count($follow_suggestions)<1){
    echo "<p class='p-2 bg-white border rounded text-center'>The well of inspiration may seem dry, but the greatest discoveries lie ahead. Keep exploring!</p>";
}
                ?>
                
               


            </div>

<br><br>
            <p>
 <button class="btn btn-dark " type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
   Expand!
 </button>
</p>
<div style="min-height: 120px;">
 <div class="collapse collapse-horizontal" id="collapseWidthExample">
   <div class="card card-body" style="width: 500px;">
   Stuck in Category 2? <br> Unlock your full potential. <br>Age up, level up!
   </div>
 </div>
</div>




        </div>
    </div>
   

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    });
  </script>
