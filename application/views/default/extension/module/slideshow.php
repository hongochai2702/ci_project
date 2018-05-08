
 <div class="bannercontainer bannercontainer-2 spacetop">
                <div class="banner">
                    <ul>
                      <?php foreach($banners as $banner) { ?>
                        <li data-transition="random" data-slotamount="1">
                            <?php if($banner['link']) { ?>
                            <a href="<?php echo $banner['link'] ?>"><img src="<?php echo $banner['image'] ?>" alt="<?php echo $banner['title'] ?>" class="img-responsive" /></a>
                            <?php } else { ?>
                            <img src="<?php echo $banner['image'] ?>" alt="<?php echo $banner['title'] ?>" class="img-responsive" />
                          <?php } ?>
                        </li>
                        <?php } ?> 
                    </ul>
                </div>
            </div>