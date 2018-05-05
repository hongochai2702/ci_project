 <nav>

     <div id='cssmenu'>
     
     <ul class="navigation">
        <?php foreach ($menus as $menu1) { ?>
        <?php if (isset($menu1['children'])) { ?>
        <?php if($menu1['style']=='' || $menu1['style']=='dropdown'){ ?>
      <li>
          <a <?php if($menu1['url']){ ?> href="<?php echo $menu1['url']; ?>" <?php } ?>   class="dropdown-toggle sss" aria-expanded="false">
              <?php if($menu1['image']){ ?>
          <img src="<?php echo $menu1['thumb']; ?>" class="img-thumbnail" />
          <?php } ?> 
          <?php echo $menu1['title']; ?> 
          </a>
          <ul class="sub-menu">
            <?php foreach ($menu1['children'] as $menu2) { ?>
            <?php if(isset($menu2['children'])){ ?>
            <li>
              <a href="<?php echo $menu2['url']; ?>" class="trigger down-mega-child2" aria-expanded="false">
        <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>
                <?php echo $menu2['title']; ?>
              </a>
              <ul class="sub-menu">
              <?php foreach ($menu2['children'] as $menu3) { ?>
              <?php if(isset($menu3['children'])){ ?>
              <li>
                <a href="<?php echo $menu3['url']; ?>" class="trigger down-mega-child3">
        <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>
                  <?php echo $menu3['title']; ?>
                </a>
                <ul class="sub-menu">
                <?php foreach ($menu3['children'] as $menu4) { ?>
                  <?php if(isset($menu4['children'])){ ?>
                  <?php }else{ ?>
                  <li>
                    <a class="down-mega-child4" href="<?php echo $menu4['url']; ?>">
           <?php if($menu4['font']){ ?><i class="fa <?php echo $menu4['font']; ?>"></i><?php } ?>
                      <?php echo $menu4['title']; ?>                     
                    </a>
                  </li>
                  <?php } ?>                
                <?php } ?>
                </ul>
              </li>
              <?php }else{ ?>
              <li>
                <a class="down-mega-child3" href="<?php echo $menu3['url']; ?>">
        <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>
                  <?php echo $menu3['title']; ?>
                </a>
              </li>
              <?php } ?>
              <?php } ?>
              </ul>
            </li>
            <?php }else{ ?>
            <li>
              <a class="down-mega-child2" href="<?php echo $menu2['url']; ?>">
        <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>
                <?php echo $menu2['title']; ?>
              </a>
            </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if($menu1['style']=='lists'){ ?>
       <li><?php echo $menu1['title']; ?> </a>

         <ul class="sub-menu">
            <li>
              <div class="yamm-content">
                <div class="row">
                <?php foreach ($menu1['children'] as $menu2) { ?>
                  <ul class="sub-menu">
                    <li>
                      <a href="<?php echo $menu2['url']; ?>">
              <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>
                        <h4><?php echo $menu2['title']; ?></h4>
                        <?php if($menu2['image']){ ?><img src="<?php echo $menu2['thumb']; ?>" class="img-thumbnail" /><?php } ?>
                      </a>
                    </li>
                    <?php if(isset($menu2['children'])){ ?>
                    <?php foreach ($menu2['children'] as $menu3) { ?>
                    <li>
                      <a href="<?php echo $menu3['url']; ?>">
              <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>                     
                        <?php if($menu3['image']){ ?><img src="<?php echo $menu3['thumb']; ?>" class="img-thumbnail" /><?php } ?>
                        <?php echo $menu3['title']; ?>
                      </a>
                    </li>
                    <?php } ?>
                    <?php } ?>
                  </ul>
                <?php } ?>
                </div>
              </div>
            </li>
          </ul>
        </li>
       <?php } ?>
                <?php if($menu1['style']=='tabbed'){ ?>
                <!--li table -->
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu1['title']; ?> <span class="caret"></span></a>
                    <ul class="sub-menu">
                        <?php foreach ($menu1['children'] as $menu2) { ?>
                        <?php if(isset($menu2['children'])){ ?>

                        <li>
                            <a class="table-mega-child-2" href="<?php echo $menu2['url']; ?>">
                            <div class="imgage_mega hidden-xs">
                        <?php if($menu2['image']){ ?><img src="<?php echo $menu2['thumb']; ?>" class="img-thumbnail" /><?php } ?>
                        </div>
                            <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>
                            <?php echo $menu2['title']; ?>
                            </a>
                           <ul class="sub-menu">
                                <?php foreach ($menu2['children'] as $menu3) { ?>
                                <?php if(isset($menu3['children'])){ ?>
                                <li>
                                    <a class="table-mega-child-3">
                                    <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>
                                    <?php echo $menu3['title']; ?> </a>
                                    <ul class="sub-menu">
                                        <?php foreach ($menu3['children'] as $menu4) { ?>
                                        <?php if(isset($menu4['children'])){ ?>
                                        <?php }else{ ?>
                                        <li>
                                            <a class="table-mega-child-4" href="<?php echo $menu4['url']; ?>">
                                            <?php if($menu4['font']){ ?><i class="fa <?php echo $menu4['font']; ?>"></i><?php } ?>
                                            <?php echo $menu4['title']; ?></a>
                                        </li>
                                        <?php } ?>                
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php }else{ ?>
                                <li>

                                    <a class="table-mega-child-3" href="<?php echo $menu3['url']; ?>">
                                    <?php if($menu3['font']){ ?><i class="fa <?php echo $menu3['font']; ?>"></i><?php } ?>
                                        <?php echo $menu3['title']; ?>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php } ?>
                            </ul>

                        </li>
                        <?php }else{ ?>
                        <li>
                            <a class="table-mega-child-2" href="<?php echo $menu2['url']; ?>">
                                <?php if($menu2['font']){ ?><i class="fa <?php echo $menu2['font']; ?>"></i><?php } ?>
                                <?php echo $menu2['title']; ?>
                                <div class="img-menu-mega">
                                <?php if($menu2['image']){ ?><img src="<?php echo $menu2['thumb']; ?>" class="img-thumbnail" /><?php } ?>
                                </div>

                            </a>
                        </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <!-- end li tablle -->
                <?php } ?>
                <?php } else { ?>
        <li>
          <a href="<?php echo $menu1['url']; ?>" <?php if($menu1['window']){ ?>target="<?php echo $menu1['window']; ?>"<?php } ?>>
        <?php if($menu1['font']){ ?>
          <i class="fa <?php echo $menu1['font']; ?>"></i>
        <?php } ?>
        <?php if($menu1['image']){ ?>
          <img src="<?php echo $menu1['thumb']; ?>" class="img-thumbnail" />
          <?php } ?>  
          <?php echo $menu1['title']; ?>
          </a>
        </li>
        <?php } ?>

        <?php } ?>
      </ul>
    </div>
    <?php if($type=="vertical") { ?>
        </div>
    <?php } ?>
</nav>
