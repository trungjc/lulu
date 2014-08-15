<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div>
	
<?php 
$menu = file_get_contents('http://localhost/lulu/index.php?route=common/menu?footer');
echo $menu;
?>	

<?php wp_footer(); ?>
</body>
</html>