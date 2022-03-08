<nav class="top-nav">
    <ul>
        <li>
            <a href="<?php echo URLROOT; ?>/index">Home</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/pages/about">About</a>
        </li>
        <li>
            <?php if(isset($_COOKIE['jwt'])) : ?>
                <a href="<?php echo URLROOT; ?>/pages/allUsers">All Users</a>
            <?php else : ?>
            <?php endif; ?>   
        </li>
        <li>
            <?php if(isset($_COOKIE['jwt'])) : ?>
                <a href="<?php echo URLROOT; ?>/pages/allPosts">Blog</a>
            <?php else : ?>
            <?php endif; ?>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/pages/contact">Contact</a>
        </li>
        <li class="btn-login">
        
            <?php if(isset($_COOKIE['jwt'])) : ?>  
                <a href="<?php echo URLROOT; ?>/users/logout">Log out</a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/users/login">Login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>
