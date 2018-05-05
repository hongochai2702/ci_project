{{ header }}{{ column_left }}
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" data-toggle="tooltip" title="{{ button_filter }}" onclick="$('#filter-reviewblog').toggleClass('hidden-sm hidden-xs');" class="btn btn-default hidden-md hidden-lg"><i class="fa fa-filter"></i></button>
        <a href="{{ add }}" data-toggle="tooltip" title="{{ button_add }}" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="{{ button_delete }}" class="btn btn-danger" onclick="confirm('{{ text_confirm }}') ? $('#form-reviewblog').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1>{{ heading_title }}</h1>
      <ul class="breadcrumb">
        {% for breadcrumb in breadcrumbs %}
        <li><a href="{{ breadcrumb.href }}">{{ breadcrumb.text }}</a></li>
        {% endfor %}
      </ul>
    </div>
  </div>
  <div class="container-fluid">{% if error_warning %}
    <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> {{ error_warning }}
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    {% endif %}
    {% if success %}
    <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> {{ success }}
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    {% endif %}
    <div class="row">
      <div id="filter-reviewblog" class="col-md-3 col-md-push-9 col-sm-12 hidden-sm hidden-xs">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-filter"></i> {{ text_filter }}</h3>
          </div>
          <div  class="panel-body">
            <div class="form-group">
              <label class="control-label" for="input-blog">{{ entry_blog }}</label>
              <input type="text" name="filter_blog" value="{{ filter_blog }}" placeholder="{{ entry_blog }}" id="input-blog" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-author">{{ entry_author }}</label>
              <input type="text" name="filter_author" value="{{ filter_author }}" placeholder="{{ entry_author }}" id="input-author" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label" for="input-status">{{ entry_status }}</label>
              <select name="filter_status" id="input-status" class="form-control">
                <option value=""></option>
                
                  
              
              
          
          
                  
                  
                  
                  {% if filter_status == '1' %}
                  
                  
                  
                  
          
          
              
              
                  
                <option value="1" selected="selected">{{ text_enabled }}</option>
                
                  
              
              
          
          
                  
                  
                  
                  {% else %}
                  
                  
                  
                  
          
          
              
              
                  
                <option value="1">{{ text_enabled }}</option>
                
                  
              
              
          
          
                  
                  
                  
                  {% endif %}
                  {% if filter_status == '0' %}
                  
                  
                  
                  
          
          
              
              
                  
                <option value="0" selected="selected">{{ text_disabled }}</option>
                
                  
              
              
          
          
                  
                  
                  
                  {% else %}
                  
                  
                  
                  
          
          
              
              
                  
                <option value="0">{{ text_disabled }}</option>
                
                  {% endif %}
                
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="input-date-added">{{ entry_date_added }}</label>
              <div class="input-group date">
                <input type="text" name="filter_date_added" value="{{ filter_date_added }}" placeholder="{{ entry_date_added }}" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <div class="form-group text-right">
              <button type="button" id="button-filter" class="btn btn-default"><i class="fa fa-filter"></i> {{ button_filter }}</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9 col-md-pull-3 col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> {{ text_list }}</h3>
          </div>
          <div class="panel-body">
            <form action="{{ delete }}" method="post" enctype="multipart/form-data" id="form-reviewblog">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                      <td class="text-left">{% if sort == 'pd.name' %} <a href="{{ sort_blog }}" class="{{ order|lower }}">{{ column_blog }}</a> {% else %} <a href="{{ sort_blog }}">{{ column_blog }}</a> {% endif %}</td>
                      <td class="text-left">{% if sort == 'r.author' %} <a href="{{ sort_author }}" class="{{ order|lower }}">{{ column_author }}</a> {% else %} <a href="{{ sort_author }}">{{ column_author }}</a> {% endif %}</td>
                      <td class="text-right">{% if sort == 'r.rating' %} <a href="{{ sort_rating }}" class="{{ order|lower }}">{{ column_rating }}</a> {% else %} <a href="{{ sort_rating }}">{{ column_rating }}</a> {% endif %}</td>
                      <td class="text-left">{% if sort == 'r.status' %} <a href="{{ sort_status }}" class="{{ order|lower }}">{{ column_status }}</a> {% else %} <a href="{{ sort_status }}">{{ column_status }}</a> {% endif %}</td>
                      <td class="text-left">{% if sort == 'r.date_added' %} <a href="{{ sort_date_added }}" class="{{ order|lower }}">{{ column_date_added }}</a> {% else %} <a href="{{ sort_date_added }}">{{ column_date_added }}</a> {% endif %}</td>
                      <td class="text-right">{{ column_action }}</td>
                    </tr>
                  </thead>
                  <tbody>
                  
                  {% if reviewblogs %}
                  {% for reviewblog in reviewblogs %}
                  <tr>
                    <td class="text-center">{% if reviewblog.reviewblog_id in selected %}
                      <input type="checkbox" name="selected[]" value="{{ reviewblog.reviewblog_id }}" checked="checked" />
                      {% else %}
                      <input type="checkbox" name="selected[]" value="{{ reviewblog.reviewblog_id }}" />
                      {% endif %}</td>
                    <td class="text-left">{{ reviewblog.name }}</td>
                    <td class="text-left">{{ reviewblog.author }}</td>
                    <td class="text-right">{{ reviewblog.rating }}</td>
                    <td class="text-left">{{ reviewblog.status }}</td>
                    <td class="text-left">{{ reviewblog.date_added }}</td>
                    <td class="text-right"><a href="{{ reviewblog.edit }}" data-toggle="tooltip" title="{{ button_edit }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                  </tr>
                  {% endfor %}
                  {% else %}
                  <tr>
                    <td class="text-center" colspan="7">{{ text_no_results }}</td>
                  </tr>
                  {% endif %}
                    </tbody>
                  
                </table>
              </div>
            </form>
            <div class="row">
              <div class="col-sm-6 text-left">{{ pagination }}</div>
              <div class="col-sm-6 text-right">{{ results }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'admin/catalog/reviewblog?user_token={{ user_token }}';
	
	var filter_blog = $('input[name=\'filter_blog\']').val();
	
	if (filter_blog) {
		url += '&filter_blog=' + encodeURIComponent(filter_blog);
	}
	
	var filter_author = $('input[name=\'filter_author\']').val();
	
	if (filter_author) {
		url += '&filter_author=' + encodeURIComponent(filter_author);
	}
	
	var filter_status = $('select[name=\'filter_status\']').val();
	
	if (filter_status !== '') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}		
			
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	language: '{{ datepicker }}',
	pickTime: false
});
//--></script></div>
{{ footer }}