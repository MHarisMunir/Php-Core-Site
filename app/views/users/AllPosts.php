<?php
   require APPROOT . '/views/includes/head.php';
?>

<div class="navbar">
    <?php
       require APPROOT . '/views/includes/navigation.php';
    ?>
</div>
<div class="container-users">
    <div class="wrapper-login">
        <h2>All Posts</h2>

        <h3> <table style="width:100%">

        <tr style='font-weight:bold'>
             <td>Id</td>
             <td>title</td>
             <td>Content</td>
             <td>Post_date/Time</td>
            
         </tr>
    
<?php 
foreach($data as $item){
?>
     
        
         <tr>
             <td><?=$item->id?></td>
             <td><?=$item->title?></td>
             <td><?=$item->content?></td>
             <td><?=$item->created_at?></td>
             
         </tr>
         
     
     
     <?php

    
}

?>
</table></h3>

    </div>
</div>