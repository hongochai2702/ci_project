<?php  echo $header; ?>
        
            <div class="bannercontainer bannercontainer-2 spacetop">
                <div class="banner">
                    <ul>
                        <li data-transition="random" data-slotamount="1">
                            <img src="<?php echo base_url('image/catalog/slide/Slider.jpg'); ?>" alt="" />
                            
                        </li>
                        <li data-transition="random" data-slotamount="1">
                            <img src="<?php echo base_url('image/catalog/slide/Slider2.jpg'); ?>" alt="" />
                            <span class="banner-overlay"></span>
                            
                        </li>
                    </ul>
                </div>
            </div>
          
            <section id="section">
                <!--Section box starts Here -->
                <div class="section">
                    <?php echo $content_top; ?>
                    <?php echo $content_bottom; ?>
                </div>
                <!--Section box ends Here -->
            </section>
<?php echo $footer; ?>