<div id="charlista-home" class="jumbotron col-12 col-md-4 mt-3 mb-0 p-0">
<div class="row no-gutters">
	<?php $active=true;
                  $temp = $wp_query;
                  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                  $post_per_page = 1; // -1 shows all posts
                  $args=array(
                    'post_type' => 'charlistas',
                    'orderby' => 'date',
                    'order' => 'ASC',
                    'paged' => $paged,
                    'posts_per_page' => $post_per_page);
                    $wp_query = new WP_Query($args);
					if( have_posts() ) : while ($wp_query->have_posts()) : $wp_query->the_post();?>
					
					<div class="charlistas-home col-12 col-md-12 mb-3">	
<div class="cabecera">

<!--foto charlista-->
	<?php $image = get_field('foto_perfil_charlista');
if( !empty($image) ): ?>
	<div class="foto-charlista" style="background-image: url('<?php echo $image['url']; ?>');"></div>
	

<?php endif; ?>
	<!--foto charlista-->
	<div class="nombre-titulo">	

	<ul class="tag">
	<li><?php
$terms = get_the_terms( $post->ID , 'etiqueta-charlistas' );
foreach ( $terms as $term ) {
echo $term->name;
}
?></li>

</ul>

<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
		
		<?php endif; ?>
		<div class="subtitulo"><?php the_field('sub_titulo'); ?></div>
		

		</div>
		</div>
		</div><!-- .charlistas home -->


		
		<?php endwhile; else: ?>
		<?php endif; wp_reset_query(); $wp_query = $temp ?>
	</div>
</div>     

  
