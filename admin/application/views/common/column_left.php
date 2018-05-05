<nav id="column-left">
  <div id="navigation"><span class="fa fa-bars"></span> <?php  echo $text_navigation ?> </div>
  <ul id="menu">
    <?php  $i = 0 ?>
    <?php  foreach( $menus as $menu) { ?>
    <li id="<?php echo $menu['id'] ?> ">
      <?php  if( $menu['href']){ ?>
      <a href="<?php echo $menu['href']; ?> ">
      <i class="fa <?php echo $menu['icon']; ?>  fw"></i>
      <?php  echo $menu['name']; ?>
      </a>
      <?php } else { ?><a href="#collapse<?php echo $i; ?> " data-toggle="collapse" class="parent collapsed"><i class="fa <?php echo $menu['icon']; ?>  fw"></i>
      <?php echo $menu['name']; ?> </a>
      <?php  }  ?>
      <?php  if( $menu['children']) { ?>
      <ul id="collapse<?php echo $i; ?>" class="collapse">
        <?php  foreach(  $menu['children'] as $children_1) { ?>
        <li><?php  if( $children_1['href']){ ?>
          <a href="<?php  echo $children_1['href']; ?> ">
          <?php echo $children_1['name']; ?> </a>
          <?php }  else { ?>
          <a href="#collapse<?php echo  $i; ?> " data-toggle="collapse" class="parent collapsed">
            <?php echo $children_1['name']; ?> </a>
            <?php  }  ?>
          <?php  if( $children_1['children']) { ?>
          <ul id="collapse<?php echo $i; ?> " class="collapse">
            <?php  foreach( $children_1['children'] as $children_2) { ?>
            <li><?php  if( $children_2['href']) { ?>
              <a href="<?php echo  $children_2['href'] ?> ">
                <?php  $children_2['name'] ?> </a><?php } else { ?>
                <a href="#collapse<?php echo $i; ?> " data-toggle="collapse" class="parent collapsed">
                  <?php echo $children_2['name']; ?> </a>
                  <?php  }  ?>
              <?php  if( $children_2['children']){ ?>
              <ul id="collapse<?php echo $i; ?> " class="collapse">
                <?php  foreach($children_2['children'] as $children_3) { ?>
                <li><a href="<?php echo $children_3['href']; ?>"><?php  echo $children_3['name']; ?> </a></li>
                <?php  }  ?>
              </ul>
              <?php  }  ?> </li>
            <?php  $i = $i+ 1; ?>
            
            <?php  }  ?>
          </ul>
          <?php  }  ?></li>
        <?php  $i =$i+ 1 ?>
        <?php  }  ?>
      </ul>
      <?php  }  ?></li>
    <?php  $i =$i+ 1 ?>
    <?php  }  ?>
  </ul>
 
</nav>
