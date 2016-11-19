<?php
/*
Template Name: members area
*/
get_header(); ?>

<?

/*******************************************************************
*  MODAL WINDOW FOR PROFILE IMAGE UPDATE
*******************************************************************/
$id = do_shortcode('[MM_Member_Data name="id"]');
$user = getMMUser($id);
$relativeLink = substr($user[0]->mm_img_url, strrpos($user[0]->mm_img_url, 'html/')+4);
//var_dump($relativeLink);
?>
<div class="modal">

</div>
<section class="large-12 form_wrap section member_section">
	<div class="image_container">
		<div class="members row">
			<div class="large-3 columns membersMenu">
					<?php
							$args = array( 'menu' => 'membersMenu');
							wp_nav_menu($args);
					?>
			</div>
			<div class="memberContent large-8 columns">
					<div class="member_content_wrap">
						<?php
							while(have_posts()) : the_post();
							/*start loop*/
 ?>
						<?php
/*******************************************************************
*  MEMBER SECTION CONTENT
*******************************************************************/

		/****************************
		*	1.	Member Home
		*****************************/
				if ( $post->post_name == 'home-1'){
						// $args = array('post_type' => 'news-article', 'order' => 'asc');
						// $query = new WP_Query($args);
						// while ( $query->have_posts() ) : $query->the_post();
						// $articleLink = types_render_field('article-url', array('output' => 'raw'));

				?>

						<div class="personal_info">
								<div class="columns profile_image">
									<?
										if(!empty($user)){
									?>
										<img src="<? echo $relativeLink; ?>">
									<?
										}
										else {
									?>
												<i class="fa fa-user"></i>
									<?	} ?>
									<form  action="/xmpiu" class="hover_control" enctype="multipart/form-data" method="post">
										<span id="img_prompt">update image?</span>
										<input type='file' name='imgData' onchange="showUpdateControl()" id="imgData">
										<input type='hidden' name='update' value='profileImage'>
									</form>
									<script>
										$('.profile_image').on('mouseenter', function(){
												console.log('hover');
												$('.hover_control').addClass('show');
										}).on('mouseleave', function(){
											$('.hover_control').removeClass('show');
										});
									</script>
									<script>

										function showUpdateControl(){
											if (imgVar.value != ''){
												console.log('update line 72 - page-members-area.php');
												$('#img_prompt').html((imgVar.value)+"<div>use this image?</div><button class='button'>submit</button><div onclick='closeUpdateControl()' class='close_prompt subscript'>close</div>");
												document.querySelector('#imgData').setAttribute('style', 'bottom:0');
												document.querySelector('.hover_control').setAttribute('style', 'opacity:1;height:100%;');
											}
											console.log('update');
										}

										function closeUpdateControl(){
											$('#img_prompt').html("<span id='img_prompt'>update image?</span>");
											document.querySelector('#imgData').setAttribute('style', 'bottom:31px');
											document.querySelector('.hover_control').setAttribute('style', 'height:40px;');
										}

										var imgVar = document.getElementById('imgData');
										// imgVar.addEventListener('input', showUpdateControl, false);
									</script>
								</div>
								<div class="columns profile_info">
										<h3><? echo do_shortcode('[MM_Member_Data name=firstName]'); ?> <? echo do_shortcode('[MM_Member_Data name=lastName]'); ?></h3>
										<p>You have been a member for <b><? echo do_shortcode('[MM_Member_Data name=daysAsMember]'); ?> days</b></p>

										<div>
											<h3>Account Summary</h3>
											Current Subscription Start Date: <b><? echo do_shortcode('[MM_Member_Data name=registrationDate]'); ?></b><br>
											<?
												$id= do_shortcode('[MM_Member_Data name=id]');
												$billingDate = nextBillingDate($id);
												x
											?>
											Current Subscription Expiration Date: <b><?  foreach($billingDate as $date){ $dateStr = strtotime($date); $myDate = date("M d, Y g:i A", $dateStr); echo $myDate; } ?></b>
										</div>
								</div>
						</div>
						<div>
							<h3>Recent News</h3>
							<?
									$args =  array('post_type' => 'news-article', 'posts_per_page' => 3);
									$query = new WP_Query($args);
									while ( $query->have_posts() ) : $query->the_post();
									$articleTitle =  get_the_title();
									$articleLink = types_render_field('article-url', array('output' => 'raw'));
								?>
								<h4><? echo $articleTitle; ?></h4>
								<p>
									<? echo get_the_excerpt(array('output' => 'raw')); ?>...<a class="subscript" href="<? echo $articleLink; ?>">read full text</a>
								</p>
						</div>
				<?
						endwhile;
						wp_reset_query();
				}
				/**************
				* section end
				***************/

		/****************************
		*	2.	News
		*****************************/
				if ( $post->post_name == 'news'){
						$args = array('post_type' => 'news-article', 'order' => 'asc');
						$query = new WP_Query($args);
						while ( $query->have_posts() ) : $query->the_post();
						$articleLink = types_render_field('article-url', array('output' => 'raw'));
						$customExcerpt = customExcerpt(get_the_content());
				?>
						<h2 class="article_heading"><? the_title(); ?></h2>
						<div class=""><? echo $customExcerpt; ?> <a href='<? echo $articleLink; ?>'>..read full article</a>"</div>
				<?
						endwhile;
						wp_reset_query();
				}
				/**************
				* section end
				***************/

		/****************************
		*	3.	Member Directory
		*****************************/

				// if ( $post->post_name == 'member-directory') {
				// 		$userArgs	= array('role' => array('subscriber'));
				// 		/* remove padding from member content area*/
				// 		echo "<style> .memberContent{padding: 0 !important;} </style>";
				// 		/* get list memeber mouse users*/
				// 		$users 		= getMMUsers();
				// 		$i = 0;
				// 		foreach($users as $user) {
				// 			$i++;
				// 			if( ($i % 2) == 0){
				// 				$bgClass = even;
				// 			}
				// 			else{
				// 				$bgClass = odd;
				// 			}
				// 	?>
				<!-- // 		<div class="directory_entry <?php echo $bgClass; ?>" >
				// 				<div class="large-2 columns profile_image">
				// 					<?php $email = getMMUserEmail($user->wp_user_id); ?>
				// 					<i class="fa fa-user"></i>
				// 				</div>
				// 				<div class="large-9 columns profile_info">
				// 						<div>
				// 							<h3><?php  echo $user->first_name; ?> <?php  echo $user->last_name; ?></h3>
				// 							<b>phone:</b> <?php  echo $user->phone; ?><br>
				// 							<b>email:</b> <?php  echo $email[0]->user_email; ?>
				// 					</div>
				// 				</div>
				// 		</div> -->
				 			<!--begin form-->
				 			<?php
				// 		}
				// 	}

					/**************
					* section end
					***************/

		/****************************
		*	4.	Renew Subscription
		*****************************/
						if( $post->post_name == 'myaccount'){

							the_content();
						}
						/**************
						* section end
						***************/
		/****************************
		*	5.	Special Reports
		*****************************/
						if( $post->post_name == 'special-reports'){
							$args = array('post_type' => 'special-report', 'posts_per_page' => -1);
							$query = new WP_Query($args);
							while ( $query->have_posts() ) : $query->the_post();
									$ext = types_render_field('file-extension', array('output' => 'raw'));
							?>

								<a target="_blank" href="<? echo types_render_field('resource-url'); ?>"><h3><? echo get_the_title(); ?></h3></a>
									<?
									/*out put file-type icon*/
										/*if( $ext == 'pdf') { ?><img href="<? echo $ext; ?>.png" /><? }
										else if( $ext == 'png' || $ext == 'jpg'|| $ext == 'gif') { ?><img href="<? echo $ext; ?>.gif" /><? }
										else if( $ext == 'doc') { ?><img href="<? echo $ext; ?>.png" /><? }
										else{ echo '<i class="fa fa-files-o"></i>'; }*/
									?>
									<p><? echo get_the_content() . ' <a target="_blank" href="'.types_render_field('resource-url').'"><span class="subscript">learn more <i class="fa fa-arrow-right"></i></span></a>'; ?></p>

						<? endwhile; ?>
						<? wp_reset_query(); ?>
						<? }
						/**************
						* section end
						***************/
						?>
					</div>
			</div>
		</div>

	</div>
</section>
<?php
endwhile;

do_action( 'foundationpress_before_content' ); ?>

<?php do_action( 'foundationpress_after_content' ); ?>





<?php get_footer();
