<div class="<?php if($width_full==1) echo 'dv-builder-full'; else  echo 'container'; ?>">
<div <?php if(!empty($id_dv)) echo "id='".$id_dv."'"; ?> class="dv-builder <?php if(!empty($class)) echo $class; ?><?php if(!empty($_GET['tpl'])) { ?> show-col<?php } ?>">
<?php if(!empty($_GET['tpl'])) { ?>
<div class="show-class">
    <span class="fa fa-code"></span><i><?php if(!empty($id_dv)) echo $id_dv; else echo "*"; ?></i> 
    <span class="fa fa-code-fork"></span><i><?php if(!empty($class)) echo $class; else echo "*"; ?></i>
    <span class="fa fa-book"></span><i><?php echo $name; ?></i>
</div>
<?php } ?>
<?php if($show_title==1) { ?>
<div class="title"><h3><?php echo $name; ?></h3></div>
<?php } ?>
<div class="dv-module-content">
<div class="row">
    <?php foreach($modules_cols as $modules_col) { ?>
        <div class="col-sm-<?php if($col_ms) echo '12'; else  echo $modules_col['col']; ?> col-md-<?php echo $modules_col['col']?> col-lg-<?php echo $modules_col['col']?> col-xs-12">
            <?php foreach($modules_col['content'] as $item): ?>
                <div class="dv-item-module <?php if(!empty($_GET['tpl'])) { ?>show-col<?php } ?>">
                    <?php echo $item; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } ?>
</div>
</div>
</div>
</div>
<?php if(!empty($_GET['tpl'])) { ?>
	<style type="text/css">
		.show-class{
			background: #83CEA3;
			padding:2px 7px; color: #fff;
			border:0px solid #399661; 
			border-radius: 30px;
			position: absolute;
			left:0px;
			top:-20px;
			font-family: 'open sans',Arial,Helvetica;
			display:inline-block;
			z-index: 9999;
			font-size:12px;
		}
		.show-class span.fa {
			margin: 0 5px;
			color: #FFFFFF;
			background: #399661;
			border-radius: 100%;
			width: 20px;
			height: 20px;
			text-align: center;
			padding: 3px 1px;
			font-size: 12px;
		}
		.dv-builder.show-col{
			margin: 3px 0px!important;
			position: relative;	
		}
		.dv-item-module.show-col{
			border:1px dashed #399661;
			position: relative;
			margin: 10px 0px 10px 0px!important;
			padding:3px!important;
			border-radius:5px;
		}	
</style>
<?php } ?>