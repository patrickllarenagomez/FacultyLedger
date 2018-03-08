
<!DOCTYPE html>
<html lang="en">
<head>
<title>About Us</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Educative Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/styles.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/font-awesome.css" rel="stylesheet"> 

<!--web-fonts-->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
<!--//web-fonts-->
<!--//fonts-->
<!-- js -->
<link rel="icon" type="image/png" href="images/logo-pcu.png">
</head>
<body>
<!-- banner -->
	<div class="banner about-banner-w3ls">
		<!-- header -->
		<?php include 'header.php' ?>
	<!-- //header -->
	<h2>About Us</h2>
	</div>
<!-- //banner -->
<!--about-->
<!-- //main-content -->
		<div class="wthree-main-content">
		<!-- About-page -->
			<div class="container">
			<div class="head-top-w3ls"><i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
			<h5 class="title-w3">Our History</h5>
				<div class="w3-about-top">
				
				<div class="col-md-6 w3ls-about-top-right-grid">
					<div class="w3ls-about-gd">
						<div class="w3-about-gd-left">
							<h4>1999 -</h4>
						</div>
						<div class="w3-about-gd-right">
							<p>Donec vestibulum tincidunt rutrum. Vestibulum a justo aliquet, mollis tellus eget, suscipit lectus.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="w3ls-about-gd">
						<div class="w3-about-gd-left">
							<h4>2005 -</h4>
						</div>
						<div class="w3-about-gd-right">
							<p>Vivamus fermentum felis quis justo accumsan, sed euismod tellus luctus. Donec in augue non nisl tempus pellentesque.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="w3ls-about-gd">
						<div class="w3-about-gd-left">
							<h4>2013 -</h4>
						</div>
						<div class="w3-about-gd-right">
							<p>Donec vestibulum tincidunt rutrum. Vestibulum a justo aliquet, mollis tellus eget, suscipit lectus.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="w3ls-about-gd">
						<div class="w3-about-gd-left">
							<h4>2015 -</h4>
						</div>
						<div class="w3-about-gd-right">
							<p>Vivamus fermentum felis quis justo accumsan, sed euismod tellus luctus. Donec in augue non nisl tempus pellentesque.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="w3ls-about-gd">
						<div class="w3-about-gd-left">
							<h4>2016 -</h4>
						</div>
						<div class="w3-about-gd-right">
							<p>Donec vestibulum tincidunt rutrum. Vestibulum a justo aliquet, mollis tellus eget, suscipit lectus.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="col-md-6 w3ls-about-top-left-grid">
					<img src="images/about.jpg" alt=" " class="img-responsive" />
					<h4>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet</h4>
					<p>Aliquam scelerisque augue nec auctor iaculis. Aenean nec efficitur sapien, a ornare eros. Cras et lorem libero. Fusce magna massa, tincidunt id neque sit amet, rutrum convallis odio. Suspendisse vitae erat vel enim vulputate vehicula vehicula euismod erat.</p>
				</div>
				<div class="clearfix"> </div>
			</div>
			</div>
			</div>
<!--//about-->
<!-- Footer -->
<?php include 'footer.php' ?>
<!-- //Footer -->
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script src="js/responsiveslides.min.js"></script>
							 
							 
							 <script>
								// You can also use "$(window).load(function() {"
								$(function () {
								  // Slideshow 4
								  $("#slider1").responsiveSlides({
									auto: true,
									pager:false,
									nav:true,
									speed: 500,
									namespace: "callbacks",
									before: function () {
									  $('.events').append("<li>before event fired.</li>");
									},
									after: function () {
									  $('.events').append("<li>after event fired.</li>");
									}
								  });
							
								});
							 </script>
							 
<!--gallery-->

<script type="text/javascript">
							$(window).load(function() {
								$("#flexiselDemo1").flexisel({
									visibleItems:3,
									animationSpeed: 1000,
									autoPlay: true,
									autoPlaySpeed: 3000,    		
									pauseOnHover: true,
									enableResponsiveBreakpoints: true,
									responsiveBreakpoints: { 
										portrait: { 
											changePoint:480,
											visibleItems: 1
										}, 
										landscape: { 
											changePoint:640,
											visibleItems:1
										},
										tablet: { 
											changePoint:768,
											visibleItems: 1
										}
									}
								});
								
							});
					</script>
					<script type="text/javascript" src="js/jquery.flexisel.js"></script>
<!--gallery-->



 <!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>
<!-- //here ends scrolling icon -->
<!--js for bootstrap working-->
	<script src="js/bootstrap.js"></script>
<!-- //for bootstrap working -->


<!-- script-for-menu -->
					<script>					
						$("span.menu").click(function(){
							$(".top-nav ul").slideToggle("slow" , function(){
							});
						});
					</script>
					<!-- script-for-menu -->

</body>
</html>