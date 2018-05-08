<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="<?php echo base_url('public/default/javascript/jquery/jquery-2.1.1.min.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/default/module/video-gallery/style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/default/javascript/jquery/fancybox/jquery.fancybox.min.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('public/default/javascript/jquery/fancybox/jquery.fancybox.min.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/default/javascript/jquery/owl-carousel/assets/owl.carousel.min.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('public/default/javascript/jquery/owl-carousel/owl.carousel.min.js'); ?>"></script>

<div id="module-video-<?php echo $module; ?>">
	<div class="wrapper-video">
		<div class="video-heading">
			<span>TAKE A TOUR</span>
			<h2>Our Videos</h2>
		</div>
		<?php if ( $videos['featured'] ) { ?>
		<div class="video-item big-video video-id-<?php echo $videos['featured']['id']; ?>">
			<a data-fancybox="iframe" href="<?php echo $videos['featured']['link']; ?>" class="fancybox fancy-video iframe">
				<img src="<?php echo $videos['featured']['image']; ?>" alt="video-demo" />
			</a>
		</div>
		<?php } ?>
		<div class="wrapper-carousel-video owl-carousel">
			<?php if ( $videos['list_videos'] ) { ?>
			<?php foreach( $videos['list_videos'] as $video ) { ?>
				<div class="video-item big-video video-id-<?php echo $video['id']; ?>">
					<a data-fancybox="iframe" href="<?php echo $video['link']; ?>" class="fancybox fancy-video iframe">
						<img src="<?php echo $video['image']; ?>" alt="video-demo" />
					</a>
				</div>
			<?php } ?>
			<?php } ?>
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