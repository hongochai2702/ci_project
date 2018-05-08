<div class="categories-side">
    <h2 class="sidebar-title"><?php echo $heading_title; ?></h2>
    <div class="all-category">
        <ul id="menu_categfory" class="dropdown_ms treeview">
            <?php foreach ($categories as $category) { ?>
            <?php if ($category['category_id'] == $category_id) { ?>
            <li class="expandable">
                <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
                <?php } else { ?>
            <li>
                <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                <?php } ?>
                <?php if (isset($category['children'])) { ?>
                <span class="icons"></span>
                <ul class="label2 sub-menu treeview">
                    <?php foreach ($category['children'] as $child) { ?>
                    <li class="expandable">
                        <?php if ($child['category_id'] == $child_id) { ?>
                        <a title ="<?php echo $child['name']; ?>" href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a> <?php } else { ?>
                        <a title ="<?php echo $child['name']; ?>" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>

                        <?php } ?>
                        <?php if (isset($child['children'])) { ?>
                        <span class="icons"></span>
                        <ul class="label3 sub-menu treeview">
                            <?php foreach ($child['children'] as $child2) { ?>
                            <li>
                                <?php if ($child2['category_id'] == $child_id) { ?>
                                <a href="<?php echo $child2['href']; ?>" class="active"><?php echo $child2['name']; ?></a>
                                <?php } else { ?>
                                <a href="<?php echo $child2['href']; ?>"><?php echo $child2['name']; ?></a>
                                <?php } ?>

                                <?php if(isset($child2['children'])) { ?>
                                <span class="icons"></span>
                                <ul class="label4 sub-menu treeview">
                                    <?php foreach ($child2['children'] as $child3) { ?>
                                    <li>
                                        <?php if ($child3['category_id'] == $child_id) { ?>
                                        <a href="<?php echo $child3['href']; ?>" class="active"><?php echo $child3['name']; ?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $child3['href']; ?>"><?php echo $child3['name']; ?></a>
                                        <?php } ?>

                                        <?php if(isset($child3['children'])) { ?>
                                        <span class="icons"></span>
                                        <ul class="label5 sub-menu treeview">
                                            <?php foreach ($child3['children'] as $child4) { ?>
                                            <li>
                                                <?php if ($child4['category_id'] == $child_id) { ?>
                                                <a href="<?php echo $child4['href']; ?>" class="active"><?php echo $child4['name']; ?></a>
                                                <?php } else { ?>
                                                <a href="<?php echo $child4['href']; ?>"><?php echo $child4['name']; ?></a>
                                                <?php } ?>

                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<script>
    $('.dropdown_ms').tendina({
    
    });
    var isMobile = window.matchMedia("only screen and (max-width: 760px)");
    if (isMobile.matches) {
        $('.all-category').hide();
        $('.sidebar-title').click(function(event) {
            $('.all-category').toggle(400);
        });
    }else{ }

</script>
