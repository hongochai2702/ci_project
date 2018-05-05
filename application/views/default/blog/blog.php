{{ header }}
<div class="homepage common-page shop-details-page about">
<div class="banner spacetop">
        <div class="banner-image parallax">
          
        </div>
        <div class="banner-text">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <a href="#" class="shipping">Tin tức</a>
                <h1>{{ heading_title }}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <section id="section">
        <div class="section">
          <div class="blog">
            <div class="container">
              <div class="row">
                <div class="col-xs-12">
                  <div class="heading ">
                    <span>our</span>
                    <h3>{{ heading_title }}</h3>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                  <div class="blog-banner ">
                    <img src="{{ blog.thumb }}" alt="" />
                  </div>
                  <div class="blog-text">
                    <div class="user-blog ">
                      <h5>{{ heading_title }}</h5>
                      <ul>
                        <li>
                          <a href="#">by : {{ manufacturer }}</a>

                        </li>
                        <li>
                          <i class="fa fa-clock-o"></i><a href="#">{{ date_available }}</a>
                        </li>
                        <li>
                          <i class="fa fa-comment-o flip-text"></i>
                           <a href="" onclick="$('a[href=\'#tab-reviewblog\']').trigger('click'); return false;">{{ reviewblogs }}</a>
                        </li>
                      </ul>
                      {{ description }}
                    </div>
                    <div class="author ">
                      <span><img src="image/{{ manufacturer_info.image }}"></span>
                      <div class="author-text">
                        <h6>{{ manufacturer }}</h6>
                        <p>
                          <strong>admin : </strong> When an unknown printer took a galley of type and scrambled it to make a type
                          specimen book. It has survived not only five centuries, but also the leap into.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div id="comment"></div>
                </div>
               {{ column_right }}
              </div>
            </div>
          </div>
          {% if reviewblog_status %}
            {% if reviewblog_guest %}
            
             
            <div class="comment-drop-box ">
             
                
              <div class="container">
                 
                <div class="row">
                  
                  <div class="col-xs-12">
                    <div id="reviewblog"></div>
                    <h3>{{ text_write }}</h3>
                     <form class="form-horizontal" id="form-reviewblog">
                    <input type="text" name="name" value="{{ customer_name }}" id="input-name" class="comment-name" placeholder="{{ entry_name }}" />
                    <textarea name="text" rows="5" id="input-reviewblog" class="form-control" placeholder="{{ entry_reviewblog }}"></textarea>
                    <div class="help-block">{{ text_note }}</div>

                    <div class="">
                    <label class="control-label">{{ entry_rating }}</label>
                    &nbsp;&nbsp;&nbsp; {{ entry_bad }}&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;{{ entry_good }}</div>
                    <button type="button" id="button-reviewblog" class="button contact-us" data-loading-text="{{ text_loading }}" class="btn btn-primary">{{ button_continue }}</button>
                  
                    </form>
                  </div>
                </div>
              </div>
           
            </div>
           
            {% else %}
            {{ text_login }}
            {% endif %}
             {% endif %}

          {{ content_bottom }}
        </div>
        <!--Section box ends Here -->
      </section>
      <script type="text/javascript">
       $(document).ready(function(){
         $('#comment').load('index.php?routing=blog/blog/reviewblog&blog_id={{ blog_id }}');
          $('#button-reviewblog').on('click', function() {
            $.ajax({
              url: 'index.php?routing=blog/blog/write&blog_id={{ blog_id }}',
              type: 'post',
              dataType: 'json',
              data: $("#form-reviewblog").serialize(),
              beforeSend: function() {
                $('#button-reviewblog').button('loading');
              },
              complete: function() {
                $('#button-reviewblog').button('reset');
              },
              success: function(json) {
                $('.alert-dismissible').remove();

                if (json['error']) {
                  $('#reviewblog').after('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
                }

                if (json['success']) {
                  $('#reviewblog').after('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                  $('input[name=\'name\']').val('');
                  $('textarea[name=\'text\']').val('');
                  $('input[name=\'rating\']:checked').prop('checked', false);
                }
              }
            });
          });
        });

      </script>
{{ footer }} 