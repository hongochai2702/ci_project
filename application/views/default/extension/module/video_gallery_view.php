<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="<?php echo base_url('public/catalog/default/javascript/jquery/jquery-2.1.1.min.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/catalog/default/module/video-gallery/style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/catalog/default/javascript/jquery/fancybox/jquery.fancybox.min.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('public/catalog/default/javascript/jquery/fancybox/jquery.fancybox.min.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/catalog/default/javascript/jquery/owl-carousel/assets/owl.carousel.min.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('public/catalog/default/javascript/jquery/owl-carousel/owl.carousel.min.js'); ?>"></script>

<div id="module-video-1">

	<div class="wrapper-video">
		<div class="video-heading">
			<span>TAKE A TOUR</span>
			<h2>Our Videos</h2>
		</div>
		<div class="video-item big-video">
			<a data-fancybox="iframe" href="https://www.youtube.com/watch?v=_1GKHMTpTtw" class="fancybox fancy-video iframe">
				<img src="<?php echo base_url('image/catalog/demo/video-demo1.jpg'); ?>" alt="video-demo" />
			</a>
		</div>
		<div class="wrapper-carousel-video owl-carousel">
			<!-- /.video-item -->
			<div class="video-item">
				<a data-fancybox="iframe" href="https://www.youtube.com/watch?v=_1GKHMTpTtw" class="fancybox fancy-video iframe">
					<img class="owl-lazy" data-src="<?php echo base_url('image/catalog/demo/video-demo1.jpg'); ?>" alt="video-demo" />
				</a>
			</div>
			<!-- /.video-item -->
			<div class="video-item">
				<a data-fancybox="iframe" href="https://www.youtube.com/watch?v=_1GKHMTpTtw" class="fancybox fancy-video iframe">
					<img class="owl-lazy" data-src="<?php echo base_url('image/catalog/demo/video-demo1.jpg'); ?>" alt="video-demo" />
				</a>
			</div>
			<!-- /.video-item -->
			<div class="video-item">
				<a data-fancybox="iframe" href="https://www.youtube.com/watch?v=_1GKHMTpTtw" class="fancybox fancy-video iframe">
					<img class="owl-lazy" data-src="<?php echo base_url('image/catalog/demo/video-demo1.jpg'); ?>" alt="video-demo" />
				</a>
			</div>
			<!-- /.video-item -->
			<div class="video-item">
				<a data-fancybox="iframe" href="https://www.youtube.com/watch?v=_1GKHMTpTtw" class="fancybox fancy-video iframe">
					<img class="owl-lazy" data-src="<?php echo base_url('image/catalog/demo/video-demo1.jpg'); ?>" alt="video-demo" />
				</a>
			</div>
			<!-- /.video-item -->
			<div class="video-item">
				<a data-fancybox="iframe" href="https://www.youtube.com/watch?v=_1GKHMTpTtw" class="fancybox fancy-video iframe">
					<img class="owl-lazy" data-src="<?php echo base_url('image/catalog/demo/video-demo1.jpg'); ?>" alt="video-demo" />
				</a>
			</div>
			<!-- /.video-item -->
			<div class="video-item">
				<a data-fancybox="iframe" href="https://www.youtube.com/watch?v=_1GKHMTpTtw" class="fancybox fancy-video iframe">
					<img class="owl-lazy" data-src="<?php echo base_url('image/catalog/demo/video-demo1.jpg'); ?>" alt="video-demo" />
				</a>
			</div>
			<!-- /.video-item -->
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var owl = $('.owl-carousel');
		owl.owlCarousel({
		    items:3,
		    lazyLoad:true,
		    loop:true,
		    margin:0,
		    nav:true,
		});
		owl.on('mousewheel', '.owl-stage', function (e) {
	    if (e.deltaY>0) {
	        owl.trigger('next.owl');
	    } else {
	        owl.trigger('prev.owl');
	    }
	    e.preventDefault();
	});
	});
</script>