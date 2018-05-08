/**
 * Created by doanvanquoc on 1/5/2016.
 */
$(document).ready(function() {
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
        placeholder: "portlet-placeholder ui-corner-all col-md-12"
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