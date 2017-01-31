<?php
/*
Template Name: Sales Training
*/
get_header(); ?>

<!-- audio files -->
<div id="audioFileContainer"></div>
<!-- -->

<section id="section_five" class="section_5">
<!-- assement content -->
	<div class="overlay">
		<div class="evalMessage correct">
			<h1>CORRECT!</h1>
			<span class="button nextQuestion">next <i class="fa fa-arrow-right"></i></span>
		</div>/
		<div class="evalMessage incorrect">
			<h1>INCORRECT</h1>
			<span class="button nextQuestion">next<i class="fa fa-arrow-right"></i></span>
		</div>
		<div class="evalMessage complete">
			<h1>Assessment Complete!</h1>
			<p>Your Score is: <span class="score">100%</span></p>
			<span class="button complete">home</span>
		</div>
	</div>
<!-- -->
	<video width="" height="" loop muted autoplay>
		<source src="wp-content/themes/generic/assets/videos/Macbook.mp4" type="video/mp4"></source>
	</video>

	<div class="presentation_container" >
			<!-- <div class='wa_image'> -->
					<!--video player-->
					<div class="overflow_container" style="background: url('')">
						<div class="video_container columns wow slideInRight" >

								<div class="signIn">
									<div class="signIn-text">
										<? $test = isset($_POST['complete']) ? $_POST['complete'] : NULL; ?>
									</div>
									<form class="sign-in-form" action="" method="">
										<h3>Sign in Here</h3>
										<div>Enter your username and passcode.</div>
										<input id="username" type="text" name="username" placeholder="username">
										<input id="password" type="password" name="password" placeholder="password">
										<input type="hidden" name="function" value="sign-in">
										<div class="button" onclick="signin(event)">sign in <i class="fa fa-hand-o-right"></i></div>
									</form>
								</div>
								<div class="questions">	</div>
						<div class="video_border">
								<!-- presentation slides -->
									<div class="presentation_text">

						</div>
					</div>
			<div class="wa_text"></div>
	<div class="" ></div>
		</div>
	</div>
	</div><!-- presentation container -->

<!-- video controls -->
	<div class="controls_row">
		<div class="controls_container">
			<span class="control close" id="close"></span>
			<span class="control rwd" id="rwd"></span>
			<span onclick="controlToggle(); pauseAudio(event);" class="control pause" id="pause" style="display:inline;"></span>
			<span onclick="controlToggle(); playAudio(event);" class="control play" id="play"></span>
			<span class="control fwd" id="fwd"></span>
		</div>
	</div>
<!-- -->
</section>



<?php get_footer();
