<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
                     <div class="breadcrumb">
                          <!--?php $url= home_url();
                            $url1= explode('/',$url);                          
                            array_pop($url1);
                            ?-->
                            <?php $categories = get_the_category( $post->ID ); ?>
                         
                       <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/lulu">Home</a>
                         // <a href="<?php echo home_url(); ?>/?cat=<?php    echo $categories[0]-> term_id; ?>"><?php echo $categories[0]->name ?></a>
                         // <a href="#"><?php the_title(); ?></a>
                      </div>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				
                           <div class="share"><!-- AddThis Button BEGIN -->
                                <div class="addthis_default_style">
                                  

                                    <a class="addthis_button_facebook"></a>
                                    <a class="addthis_button_twitter"></a>
                                    <a class="addthis_button_instagram"></a>

                                                    <a class="addthis_button_printest"> </a>
                                                    <a href="http://www.pinterest.com/pin/create/button/
                                                          ?url=http%3A%2F%2Fwww.flickr.com%2Fphotos%2Fkentbrew%2F6851755809%2F
                                                          &media=http%3A%2F%2Ffarm8.staticflickr.com%2F7027%2F6851755809_df5b2051c9_z.jpg
                                                          &description=Next%20stop%3A%20Pinterest"
                                                          data-pin-do="buttonPin"
                                                          data-pin-config="above">

                                                          </a>
                                                      <a class="addthis_button_compact"></a> 
                                </div>
                                <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
                                <script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
                                <!-- AddThis Button END --> 
                              </div>
				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>