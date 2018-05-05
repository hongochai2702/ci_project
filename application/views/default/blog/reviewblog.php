{% if reviewblogs %}
<div class="comment">
                    <ul class="user-comment-list">
{% for reviewblog in reviewblogs %}

                      <li>
                        <div class="comment-box-wrapper clearfix">
                          <a href="#" class="blog-user"> <img src="image/catalog/profile-pic.png" alt="" /> </a>
                          <div class="comment-wrap">
                            <div class="user-name">
                              <span class="name">{{ reviewblog.author }}</span><span class="posted-date"> {{ reviewblog.date_added }}</span>
                            </div>

                            <p>
                              {{ reviewblog.text }}
                            </p>
                            {% for i in 1..5 %}
                              {% if reviewblog.rating < i %} <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> {% else %} <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> {% endif %}
                              {% endfor %}
                          </div>
                        </div>
                      </li>

                      

                   

{% endfor %}
 </ul>
                  </div>
<div class="text-right">{{ pagination }}</div>
{% else %}
<p>{{ text_no_reviewblogs }}</p>
{% endif %} 