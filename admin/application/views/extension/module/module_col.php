<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" class="module-column">
  <div class="page-header">
    <div class="container-fluid">
        <div class="pull-right action-tool" id="tool_module">
        <button type="submit" form="form-col" class="item-action"><?php echo $button_save; ?></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-col" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_title; ?></label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name" class="form-control"/>
                    <?php if ($error_name) { ?>
                            <div class="text-danger"><?php echo $error_name; ?></div>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name">Nhập tên  hiển thị</label>
                <div class="col-sm-10">
                    <?php foreach ($languages as $language) { ?>
                        <div style="position: relative; ">
                            <input type="text" name="title[<?php echo $language['language_id']; ?>]" value="<?php if(isset($title[$language['language_id']])) { echo $title[$language['language_id']]; } ?>" placeholder="" id="input-name" class="form-control"/>
                            <img style="position: absolute; right: 10px; top: 12px;" src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                        </div>
                        <?php if ($error_name) { ?>
                                <div class="text-danger"><?php echo $error_name; ?></div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-class"><?php echo $entry_class; ?></label>

                <div class="col-sm-10">
                    <input type="text" name="class" value="<?php echo $class; ?>"
                           placeholder="<?php echo $entry_class_placehoder; ?>" id="input-class" class="form-control"/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-id"><?php echo $entry_id_dv; ?></label>
                <div class="col-sm-10">
                    <input type="text" name="id_dv" value="<?php echo $id_dv; ?>"
                           placeholder="<?php echo $entry_id_placehoder; ?>" id="input-class" class="form-control"/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_title_full; ?></label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <?php if($width_full==0){ ?>
                            <label class="btn btn-primary active">
                                <input type="radio" name="width_full" id="option1" value="0" autocomplete="off" checked> <?php echo $entry_not_full; ?>
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="width_full" id="option2" value="1" autocomplete="off"> <?php echo $entry_full; ?>
                            </label>
                        <?php } else { ?>
                            <label class="btn btn-primary">
                                <input type="radio" name="width_full" id="option1" value="0" autocomplete="off" > <?php echo $entry_not_full; ?>
                            </label>
                            <label class="btn btn-primary active">
                                <input type="radio" name="width_full" id="option2" value="1" autocomplete="off" checked> <?php echo $entry_full; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_title_bootstrap; ?></label>
                <div class="col-sm-10">
                    <div class="btn-group" data-toggle="buttons">
                        <?php if($col_ms==0){ ?>
                            <label class="btn btn-primary active">
                                <input type="radio" name="col_ms" id="option2" value="0" autocomplete="off" checked> col-sm-{x}
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="col_ms" id="option1" value="1" autocomplete="off"> col-sm-12
                            </label>
                        <?php } else { ?>
                            <label class="btn btn-primary">
                                <input type="radio" name="col_ms" id="option2" value="0" autocomplete="off"> col-sm-{x}
                            </label>
                            <label class="btn btn-primary active">
                                <input type="radio" name="col_ms" id="option1" value="1" autocomplete="off" checked> col-sm-12
                            </label>
                        <?php } ?>
                    </div>
                    </br>
                    <div class="des" style="margin-top: 5px;"><?php echo $entry_title_bootstrap_des; ?></div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_title_show; ?></label>
                <div class="col-sm-10">                    
                    <div class="btn-group" data-toggle="buttons">
                        <?php if($show_title==0){ ?>
                            <label class="btn btn-primary">
                                <input type="radio" name="show_title" id="option1" value="1" autocomplete="off" > <?php echo $entry_show; ?>
                            </label>
                            <label class="btn btn-primary active">
                                <input type="radio" name="show_title" id="option2" value="0" autocomplete="off" checked> <?php echo $entry_hide; ?>
                            </label>
                        <?php } else { ?>
                            <label class="btn btn-primary active">
                                <input type="radio" name="show_title" id="option1" value="1" autocomplete="off" checked> <?php echo $entry_show; ?>
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="show_title" id="option2" value="0" autocomplete="off"> <?php echo $entry_hide; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                    <select name="status" id="input-status" class="form-control">
                        <?php if ($status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_module; ?></label>
            <div class="col-sm-10">
                <div>
                    <span data-toggle="modal" data-target="#list_module"style="border-radius: 100%; padding: 10px; background-color:#29B2B9; color: #fff; cursor: pointer; margin:0 2px;" class="fa fa-arrows-h">                       
                    </span>
                    <?php echo $entry_hide_show; ?>
                </div>
                <div id="list_module" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Detail Module">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="gridSystemModalLabel"><?php echo $text_module; ?></h3>
                            </div>
                            <div class="modal-body">
                                <div class="module_active row" id="collapseExample">
                                    <?php foreach($module_active as $key_module=>$item_module):?>
                                    <?php if(empty($item_module['module_child'])) { ?>
                                    <div class="name_module col-sm-4">
                                        <div class="inner-module">
                                            <span class="fa fa-plug icon-plugin"></span>
                                            <?php echo $item_module['name']?>
                                            <div class="tool-list-module">
                                                <span class="name_module" data-module-val="<?php echo $item_module['module']; ?>">
                                                    <div class="hidden data-module-name"><?php echo str_replace(array("[","]","\"","\'"),"",strip_tags($item_module['name'])); ?></div>
                                                    <?php echo $entry_add; ?>
                                                </span>
                                                <span class="fa fa-gear" data-link="<?php echo $item_module['edit_link']; ?>" data-toggle="modal" data-target="#edit_module"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                        <?php foreach($item_module['module_child'] as $key_child_module=>$child_module): ?>
                                            <div class="name_module col-sm-4">
                                                <div class="inner-module">
                                                    <span class="fa fa-plug icon-plugin"></span>
                                                    <b><?php echo $item_module['name']?></b>-><?php echo $child_module['name']?>
                                                    <div class="tool-list-module">
                                                        <span class="name_module" data-module-val="<?php echo $child_module['module']; ?>">
                                                            <div class="hidden data-module-name"><?php echo str_replace(array("[","]","\"","\'"),"",strip_tags($child_module['name'])); ?></div>
                                                            <i class="fa fa-plus"></i>
                                                            <?php echo $entry_add; ?>
                                                        </span>
                                                        <span class="fa fa-gear" data-link="<?php echo $child_module['edit_link']; ?>" data-toggle="modal" data-target="#edit_module"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tool_col" id="tool-col">
                    <div class="action-tool">
                        <div class="item-action add_col"><span class="fa fa-plus-square"></span></div>
                    </div>
                    <div id="content_col" class="row">
                        <div id="inner_content_col" class="col-sm-12 inner_content_col">
                         <?php if(!empty($modules)){ ?>
                            <?php foreach($modules as $keys=>$items):?>
                            <?php if($items[2]!=-1){ ?>
                                <div class='col-module col-sm-<?php echo $items[0];?>' data-col='<?php echo $items[0];?>'>
                                    <div class='inner-col-module'>
                                        <div class='action-module'>
                                            <div class='col-move item-action-module'><span class='fa fa-arrows'></span></div>
                                            <div class='col-div item-action-module dropdown-toggle' data-toggle="dropdown">
                                                    <span class='fa fa-reorder'></span>
                                                    <div class="selete-col dropdown-menu">
                                                        <?php for($i=1; $i<=12; $i++){ ?>
                                                            <div class="item-selete-col <?php if($i==$items[0]) echo 'active';?>" data-col='<?php echo $i; ?>'><?php echo $i; ?></div>
                                                        <?php } ?>
                                                        <div class="clearfix"></div>
                                                    </div>
                                            </div>
                                            <div class='col-delete item-action-module pull-right'><span class='fa fa-trash'></span></div>
                                        </div>
                                        <div class='col-active pull-right'><?php echo $entry_active; ?></div>
                                        <div class='name-module-setting'>
                                            <div class="item-name-module">
                                                <?php foreach($items[2] as $key=>$item): ?>
                                                    <div class='name <?php if($items[4][$key]==0) echo "no-active"; ?>'>
                                                        <a data-link="<?php echo $items[3][$key]; ?>" data-toggle="modal" data-target="#edit_module" href="javascript:;">
                                                            <?php echo $items[1][$key]; ?></span></a>
                                                        <span class="remove-module-list fa fa-times-circle" data-code-module="<?php echo $item;?>"></span>
                                                    </div>
                                                <?php endforeach;  ?>
                                            </div>
                                            <div class='input'>
                                                <input type='hidden' name='module[]' value='<?php echo $items[0];?>quocdvowow<?php echo implode("quocdvkaka",$items[1]);?>quocdvowow<?php echo implode("quocdvkaka",$items[2]);?>'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php endforeach; ?>
                         <?php }else { ?>
                            <div class="text-center">Phân cột và chọn chức năng từ danh sách.</div>
                         <?php } ?>
                        
                         <?php if(!empty($module) && false){ ?>
                            <?php foreach($module as $key_module=>$item_module): $item=explode("quocdvowow",$item_module);?>
                            <?php if($item[2]!=-1){ ?>
                                <div class='col-module col-sm-<?php echo $item[0];?>' data-col='<?php echo $item[0];?>'>
                                    <div class='inner-col-module'>
                                        <div class='action-module'>
                                            <div class='col-move item-action-module'><span class='fa fa-arrows'></span></div>
                                            <div class='col-div item-action-module dropdown-toggle' data-toggle="dropdown">
                                                    <span class='fa fa-reorder'></span>
                                                    <div class="selete-col dropdown-menu">
                                                        <?php for($i=1; $i<=12; $i++){ ?>
                                                            <div class="item-selete-col <?php if($i==$item[0]) echo 'active';?>" data-col='<?php echo $i; ?>'><?php echo $i; ?></div>
                                                        <?php } ?>
                                                        <div class="clearfix"></div>
                                                    </div>
                                            </div>
                                            <div class='col-delete item-action-module pull-right'><span class='fa fa-trash'></span></div>
                                        </div>
                                        <div class='col-active pull-right'><?php echo $entry_active; ?></div>
                                        <div class='name-module-setting'>
                                            <?php $item_name_modules=explode("quocdvkaka",$item[1]); ?>
                                            <?php $item_val_modules=explode("quocdvkaka",$item[2]); ?>
                                            <div class="item-name-module">
                                                <?php foreach($item_name_modules as $l=>$item_name): ?>
                                                    <?php if($item_name!=-1) { ?>
                                                        <div class='name'>
                                                            <?php echo $item_name; ?>
                                                            <span class="remove-module-list fa fa-times-circle" data-code-module="<?php echo $item_val_modules[$l];?>"></span>
                                                        </div>
                                                    <?php }else{
                                                        array_splice($item_name_modules, $l, 1);
                                                        array_splice($item_val_modules, $l, 1);
                                                     } ?>
                                                <?php endforeach; ?>
                                                <?php 
                                                $item_name_modules=implode("quocdvkaka",$item_name_modules);
                                                $item_val_modules=implode("quocdvkaka",$item_val_modules);
                                                ?>
                                            </div>
                                            <div class='input'>
                                                <input type='hidden' name='module[]' value='<?php echo $item[0];?>quocdvowow<?php echo $item_name_modules;?>quocdvowow<?php echo $item_val_modules;?>'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php endforeach; ?>
                         <?php } ?>
                          
                        </div>
                    </div>
                </div>
                <?php if ($error_module) { ?>
                    <div class="text-danger"><?php echo $error_module; ?></div>
                <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
 </div>
<div id="edit_module" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Detail Module">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="gridSystemModalLabel"><?php echo $entry_edit_module_custom; ?></h3>
            </div>
            <div class="modal-body">
                <div id="loader" class="text-center" style="display: none;"></div>
                <iframe src="" class="hidden" frameborder="0" width="100%" id="modalFrame"></iframe>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
/**
 * Created by doanvanquoc on 1/5/2016.
 */
$(document).ready(function() {
    function removeActive(){
            $(".col-module").removeClass("active");
    }
    $(".add_col").click(function(){
        var col=window.prompt("<?php echo $entry_alert_input_col;?>",12);
        if(col!=null){
            removeActive();
            var html="<div class='col-module active col-sm-"+col+"' data-col='"+col+"'>";
            html+="<div class='inner-col-module'>";
            html+="<div class='action-module'>";
            html+="<div class='col-move item-action-module'><span class='fa fa-arrows'></span></div>";
            html+="<div class='col-div item-action-module dropdown-toggle' data-toggle='dropdown'>";
            html+="<span class='fa fa-reorder'></span>";
            html+="<div class='selete-col dropdown-menu'>";
            for(var i=1; i<=12; i++){
                if(i==col)
                    html+="<div class='item-selete-col active' data-col='"+i+"'>"+i+"</div>";
                else
                    html+="<div class='item-selete-col' data-col='"+i+"'>"+i+"</div>";
            }
            html+="<div class='clearfix'></div>";
            html+="</div>";
            html+="</div>";
            html+="<div class='col-delete item-action-module pull-right'><span class='fa fa-trash'></span></div>";
            html+="</div>";
            html+="<div class='col-active pull-right'><?php echo $entry_active; ?></div>";
            html+="<div class='name-module-setting'>";
            html+="<div class='item-name-module'>";
            html+="<div class='name'>Chọn chức năng</div>";
            html+="</div>";
            html+="<div class='input'><input type='hidden' name='module[]' value='"+col+"quocdvowow"+(-1)+"quocdvowow"+(-1)+"'></div>";
            html+="</div>";
            html+="</div>";
            html+="</div>";
            $("#inner_content_col").append(html);
        }
    });
     $( document ).on( "click", ".name_module", function() {
        var module_name=$(this).find(".data-module-name").first().text();
        var module_val=$(this).data("module-val");
        var active=$(".col-module.active");
        if (module_val != undefined && module_name != undefined) {
            if(active.length>=1) {
                var array_par=active.find("input").first().val().split("quocdvowow");
                if(array_par[1]==-1){
                    $(".col-module.active .name-module-setting>.item-name-module>.name").html(module_name+"<span class='remove-module-list fa fa-times-circle' data-code-module='"+module_val+"'></span>");
                    $(".col-module.active .name-module-setting>.input>input").val($(".col-module.active").data("col") + "quocdvowow" + module_name + "quocdvowow" + module_val);
                    $('#list_module').modal('hide');
                }else{
                    var name_item="",val_item="";
                    var item_module_name=array_par[1].split("quocdvkaka");
                    var item_module_value=array_par[2].split("quocdvkaka");
                    if(item_module_name.length==1){
                        name_item=item_module_name+"quocdvkaka"+module_name;
                        val_item=item_module_value+"quocdvkaka"+module_val;                       
                    }else{
                        name_item=array_par[1]+"quocdvkaka"+module_name;
                        val_item=array_par[2]+"quocdvkaka"+module_val;
                    }
                    $(".col-module.active .name-module-setting>.item-name-module").append('<div class="name">'+module_name+"<span class='remove-module-list fa fa-times-circle' data-code-module='"+module_val+"'></span></div>");
                    $(".col-module.active .name-module-setting>.input>input").val($(".col-module.active").data("col") + "quocdvowow" + name_item + "quocdvowow" + val_item);
                    $('#list_module').modal('hide');
                }
            }else{
                alert("<?php echo $entry_alert_choose_col;?>");
            }
        }
    });
    $( document ).on( "click", ".remove-module-list", function() {
        var array_par=$(this).parents(".name-module-setting").find("input").first().val().split("quocdvowow");
        var code_module=$(this).data('code-module');
        if(array_par[0]!=-1){
            var array_item_name=array_par[1].split("quocdvkaka");
            var array_item_val=array_par[2].split("quocdvkaka");
            if(array_item_name.length>1){
                for(var i=0;i<array_item_val.length; i++){
                    if(array_item_val[i]==code_module){
                        array_item_val.splice(i, 1);
                        array_item_name.splice(i, 1);
                        break;
                    }
                }
                var name_item="",val_item="";
                for(var i=0;i<array_item_val.length; i++){
                    if(i!=0){
                        name_item+="quocdvkaka"+array_item_name[i];
                        val_item+="quocdvkaka"+array_item_val[i];
                    }else{
                        name_item+=array_item_name[i];
                        val_item+=array_item_val[i];
                    }
                }
                $(this).parents(".name-module-setting").find("input").first().val($(this).parents(".col-module").first().data("col") + "quocdvowow" + name_item + "quocdvowow" + val_item);
                $(this).parents(".name").remove();
            }else{
                $(this).parents(".name-module-setting").find("input").first().val($(this).parents(".col-module").first().data("col")+"quocdvowow"+(-1)+"quocdvowow"+(-1));
                $(this).parents(".name").first().html("Chọn chức năng");
            }
        }
    });
    $( document ).on( "click", ".col-module", function() {
        removeActive();
        $(this).addClass("active");
    });
    $( document ).on( "click", ".col-delete", function() {
        $(this).parents('.col-module').remove();
    });

    $( "#inner_content_col" ).sortable({
        connectWith: ".inner_content_col",
        handle: ".col-move",
        opacity:0.5,
        placeholder: "portlet-placeholder ui-corner-all",
        sort: function( event, ui ){
                var col=ui.item.data('col');
                console.log(col);
                $(this).find('.portlet-placeholder').html('<div class="placeholder-dv col-sm-'+col+'"><div class="child-placeholder"></div></div>');
        },
    });
    $( ".col-module" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" );
    $(document).on( "click", ".col-div",function() {
        if(!$(this).find('.selete-col').first().hasClass('active'))
            $('.selete-col').removeClass("active");
        $(this).find('.selete-col').first().toggleClass('active');

    });
    $(document).on( "click", ".item-selete-col",function() {
        var col=$(this).data("col");
        $(this).parents(".col-module").removeClass("col-sm-"+$(this).parents(".col-module").data('col'));
        $(this).parents(".col-module").addClass("col-sm-"+col);
        $(this).parents(".col-module").data('col',col);
        var input=$(this).parents(".col-module").find(".input>input").first();
        var arr_val=input.val().split("quocdvowow");
        var string=col+"quocdvowow"+arr_val[1]+"quocdvowow"+arr_val[2];
        input.val(string);
    });


    $('#edit_module').on('show.bs.modal', function (event) {
        $(".module_active#collapseExample").removeClass("in");
        $('html').css('overflow','hidden');
        $("#loader").show();
        var elem =$('#modalFrame').addClass('hidden');
        var button = $(event.relatedTarget) // Button that triggered the modal
        var target = button.data('link');
        elem.attr("src", target);
        elem.load(function() {
            elem.contents().find("#column-left").remove();
            elem.contents().find("#header").remove();
            elem.contents().find(".breadcrumb").remove();
            elem.contents().find("#footer").remove();
            elem.contents().find("#content").css({"background":"none","padding-top":"1px",'padding-bottom':'0px','margin-top':'-15px'});
            if (GetURLParameter(this.contentWindow.location, 'route') == "extension/module") {
                $('#edit_module').modal('hide');
                $('#module-ajax-success').removeClass('hidden');
            }
            iframeLoaded('modalFrame');
            $("#loader").hide();
        });
        elem.removeClass('hidden');
    });
    $('#edit_module').on('hide.bs.modal', function(event) {
        $(".module_active#collapseExample").addClass("in");
        $('html').css('overflow-y','scroll');
        $('#modalFrame').attr("src", "");
    });


}); /* end document */


function iframeLoaded(id) {
    var iFrameID = document.getElementById(id);
    if (iFrameID) {
        iFrameID.height = "";
        iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight-50 + "px";
    }
}
function GetURLParameter(url, sParam) {
    var sPageURL = url.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}
</script>
<?php echo $footer; ?>