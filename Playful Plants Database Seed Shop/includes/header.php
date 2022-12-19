<nav>
  <ul>
    <li> <a href="/browse-plants">Administrative Database</a></li>
    <li><a href="/">Home</a></li>
  <?php if (is_user_logged_in()) { ?>
        <li class= 'logout'><a href="<?php echo logout_url(); ?>">Sign Out</a></li>
      <?php } ?>
  </ul>
</nav>



<img src="/public/images/ppheader6.png" alt="header image" class= "head1">
       <!-- Source: (original work) Anika Tasnim -->
