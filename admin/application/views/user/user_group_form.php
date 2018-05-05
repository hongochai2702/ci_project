<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user-group" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb.href; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php }  ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    {% if error_warning %}
    <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    {% endif %}
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user-group" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              {% if error_name %}
              <div class="text-danger"><?php echo $error_name; ?></div>
              {% endif %}
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_access; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                {% for permission in permissions %}
                <div class="checkbox">
                  <label>
                    {% if permission in access %}
                    <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" checked="checked" />
                    <?php echo $permission; ?>
                    {% else %}
                    <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" />
                    <?php echo $permission; ?>
                    {% endif %}
                  </label>
                </div>
                <?php }  ?>
              </div>
              <button type="button" onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="btn btn-link"><?php echo $text_select_all; ?></button> / <button type="button" onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="btn btn-link"><?php echo $text_unselect_all; ?></button></div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_modify; ?></label>
            <div class="col-sm-10">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                {% for permission in permissions %}
                <div class="checkbox">
                  <label>
                    {% if permission in modify %}
                    <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" checked="checked" />
                    <?php echo $permission; ?>
                    {% else %}
                    <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" />
                    <?php echo $permission; ?>
                    {% endif %}
                  </label>
                </div>
                <?php }  ?>
              </div>
              <button type="button" onclick="$(this).parent().find(':checkbox').prop('checked', true);" class="btn btn-link"><?php echo $text_select_all; ?></button> / <button type="button" onclick="$(this).parent().find(':checkbox').prop('checked', false);" class="btn btn-link"><?php echo $text_unselect_all; ?></button></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 