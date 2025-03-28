<?php

require __DIR__."/includes/head.php"; ?>

  <!-- Page Content-->
  <div class="container">
  <div class="row">
<?php
require __DIR__."/components/Categories.php"; ?>
  <div class="col-lg-9">
      <?php
      require __DIR__."/components/Slider.php"; ?>
      <?php
      require __DIR__."/components/Products.php"; ?>
  </div>
<?php
require "./includes/foot.php"; ?>