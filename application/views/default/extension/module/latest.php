<section id="section">
      <div class="section  homepage8">
        <div class="services">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="heading">
                  <span><?php echo $heading_title; ?></span>
                  <h2><?php echo $heading_title; ?></h2>
                </div>
              </div>
            </div>

            <?php foreach ($products as $product) { ?>
            <div id="services-slides" class="services-slider">
              <div class="slides-tab zoom col-xs-12 col-sm-3 col-md-3">
                <figure>
                  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
                </figure>
                <div class="slides-text">
                  <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>