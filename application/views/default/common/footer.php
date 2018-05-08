<footer>
  <div class="container">
    <div class="row">
     <div class="col-sm-12"><?php echo $footer_top; ?></div>
     <div class="col-sm-12"><?php echo $footer_bottom; ?></div>
  </div>
</footer>
<?php foreach($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<!-- jQuery REVOLUTION Slider  -->
<script type="text/javascript" src="<?php echo base_url('public/default/js/jquery.themepunch.tools.min.js'); ?>" ></script>
<script type="text/javascript" src="<?php echo base_url('public/default/js/jquery.themepunch.revolution.min.js"'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/default/js/revolution.js'); ?>"></script>
</body></html>