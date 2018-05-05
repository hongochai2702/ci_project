{{ header }}
<div class="homepage common-page shop-details-page about">
<div class="banner spacetop">
        <div class="banner-image parallax">
          
        </div>
        <div class="banner-text">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <a href="#" class="shipping">Danh mục tin tức</a>
                <h1>{{ heading_title }}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
  <section id="section"> 
    <!--Section box starts Here -->
    <div class="section">
      <div class="blog">
        <div class="container">
          <div class="row">
            <div class="masonry-section">
              {% for blog in blogs %}
              <div class="col-sm-4 zoom pad-bottom blog-items"> <span class="stick-pin"> <i class="fa fa-thumb-tack "></i> </span>
                <figure> <a href="{{ blog.href }}"><img src="{{ blog.thumb }}" alt="{{ blog.name }}" title="{{ blog.name }}" class="img-responsive" /></a></figure>
                <div class="blog-text">
                  <div class="user-blog ">
                    <h2 class="h5"><a href="{{ blog.href }}">{{ blog.name }}</a></h2>
                    <ul>
                      <li> <i class="fa fa-user"></i><a href="#">by : john samual</a> </li>
                      <li> <i class="fa fa-clock-o"></i><a href="#">july 18- 2015</a> </li>
                      <li> <i class="fa fa-comment-o flip-text"></i><a href="#">18 comments</a> </li>
                    </ul>
                    <p> {{ blog.description }} </p>
                    <a class="button services-link button-hover" href="{{ blog.href }}">read more</a> </div>
                </div>
              </div>
              {%  endfor %}
            
         
            </div>
            
          </div>
        </div>
      </div>
     
    </div>
    <!--Section box ends Here --> 
  </section>

{{ footer }} 
