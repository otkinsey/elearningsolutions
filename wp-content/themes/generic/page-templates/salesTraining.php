<?php
/*
Template Name: Sales Training
*/
get_header(); ?>


<!---SECTION FIVE--->

<!-- audio files -->
<div id="audioFileContainer">
	<!-- <audio class="audio_1" autoplay="false" src="wp-content/themes/generic/assets/audio_files/audio_1.mp3"></audio>
	<audio class="audio_2" autoplay="false" src="wp-content/themes/generic/assets/audio_files/audio_2.mp3"></audio>
	<audio class="audio_3" autoplay="false" src="wp-content/themes/generic/assets/audio_files/audio_3.mp3"></audio>
	<audio class="audio_4" autoplay="false" src="wp-content/themes/generic/assets/audio_files/audio_4.mp3"></audio> -->
</div>
<section id="section_five" class="section_5">
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
	<video width="" height="" loop muted autoplay>
		<source src="wp-content/themes/generic/assets/videos/Macbook.mp4" type="video/mp4"></source>
	</video>

	<div class="animateBox_2" >
		<!-- <div class=""> -->

			<div class='wa_image'>
					<!--video player-->
					<div class="overflow_container" style="background: url('')">
						<div class="video_container columns wow slideInRight" >
							<h1 id="welcome">Welcome to the Elearning Solutions Demo Application!</h1>
							<!-- begin: presentation content -->
								<div class="signIn">
									<div class="signIn-text">
										<? $test = isset($_POST['complete']) ? $_POST['complete'] : NULL; ?>
										<!-- <? var_dump(get_presentation('two')); ?> -->
										<!-- The following presentation demonstrates the functional and aesthetic features that are possible with a learning application from Elearning solutions.  The features of this application are fully customizable, and represent a small portion of the full range of functional, visual, and administrative features that can be provided. Please enter your username and password in the form below to begin. -->
									</div>
									<form class="sign-in-form" action="" method="">
										<h3>Sign in Here.</h3>
										<input id="username" type="text" name="username" placeholder="username">
										<input id="password" type="password" name="password" placeholder="password">
										<input type="hidden" name="function" value="sign-in">
										<div class="button" onclick="signin(event)">sign in <i class="fa fa-hand-o-right"></i></div>
									</form>
								</div>
								<?

									// $postVar == test();
									// 	if($postVar == 'complete'){
								?>
								<!-- test questions -->
								<div class="questions">

										<!-- <? $args = array('post_type'=>'test-question', 'posts_per_page'=>-1); ?>
										<? $query = new WP_query($args); ?>
										<? $i = 0; ?>
										<? while( $query->have_posts() ) : $query->the_post(); ?>
										<? $i++; ?>
											 <div class="question" id="question<? print $i; ?>">
												 	<h1><? the_title(); ?></h1>
													<p> <? the_content(); ?> </p>
													<?
														$options = array('a','b','c','d');
														$b = 1;
														for( $a=0;$a<count($options)-1;$a++){
															echo "<p class='option o$b' >" . types_render_field('option-'.$options[$a]). "</p>";
															$b++;
														}

													?>

											 </div>
									 <? endwhile;  ?>
									 <? wp_reset_query(); ?>
									 <?
									 		global $post;
									 		$options = get_multiple_choice_options($post->ID);

									?> -->
								</div>
								<div class="video_border">

								<!-- presentation slides -->
									<div class="presentation_text">
											<!-- <? $args = array( "post_type" => "presentation", "posts" => -1, "orderby" => "ID", 'order' => 'desc'); ?>
											<? $query = new WP_Query($args); ?>
											<? while( $query->have_posts() ) : $query->the_post(); ?> -->

														<!-- <h1><? the_title(); ?></h1> -->
														<?
														// $numbers = array('one','two','three','four','five','six','seven','eight','nine','ten');
														// for($a=0;$a<11;$a++){
														// 	$slide= 'slide-'.$numbers[$a];
														// 	if(!empty(types_render_field($slide))){
															?>
															<!-- <div class="textItem"><? echo types_render_field($slide); ?></div> -->
														<?
															// 	}
															// 	else{ break; }
															// }
															?>
														<!-- <? echo $post->ID?> -->

										<!-- <? endwhile; ?> -->
										<!-- <? wp_reset_query(); ?> -->

									</div>
								</div>
							<!-- end: presentation content -->

								<!--
								**  VIDEO PLAYER CONTROL BUTTONS:
								**  these may be brought back at a later time
								*************************************-->
								<!-- <audio controls class="audio1">
									<source src="http://localhost:8888/practice/eliteTrainingVideos/wp-content/themes/generic/assets/audio_files/audio_1.m4a" type="audio/mpeg">
								</audio>
								<audio controls class="audio2">
									<source src="http://localhost:8888/practice/eliteTrainingVideos/wp-content/themes/generic/assets/audio_files/audio_2.m4a" type="audio/mpeg">
								</audio>
								<audio controls class="audio3">
									<source src="http://localhost:8888/practice/eliteTrainingVideos/wp-content/themes/generic/assets/audio_files/audio_3.m4a" type="audio/mpeg">
								</audio> -->
								<div class="controls_container">
									<span class="control close" id="close"></span>
									<span class="control rwd" id="rwd"></span>
									<span onclick="controlToggle(); pauseAudio();" class="control pause" id="pause"></span>
									<span onclick="controlToggle(); playAudio();" class="control play" id="play"></span>
									<span class="control fwd" id="fwd"></span>
								</div>
						</div>

			</div>
			<div class="wa_text"><?php echo types_render_field('wa_text-one'); ?></div>
	<div class="" ></div>
		<!-- </div> -->
	</div>
</section>



<?php get_footer();
