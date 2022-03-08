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
        <h2>All Users</h2>

        <h3>
        <table style="width:100%">

        <tr style='font-weight:bold'>
                     <td>Id</td>
                     <td>Username</td>
                     <td>Email</td>
                     <td>Password</td>
                     <td>Is_verified</td>
                 </tr>
            <?php 

        foreach($data as $item){
?>
             
                
                 <tr>
                     <td><?=$item->id?></td>
                     <td><?=$item->username?></td>
                     <td><?=$item->email?></td>
                     <td><?=$item->password?></td>
                     <td><?=$item->is_verified?></td>
                 </tr>
                 
             
             
             <?php       
        }
        
        ?>
        </table>
        
    </h3>

    </div>
</div>