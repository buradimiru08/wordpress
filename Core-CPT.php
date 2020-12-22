<?php
 /*speakers*/

// Register Custom Post Type
add_action( 'init', 'charlistas', 0 );

function charlistas() {

	$labels = array(
		'name'                  => _x( 'Charla', 'Post Type General Name', 'charlistas' ),
		'singular_name'         => _x( 'Charlista', 'Post Type Singular Name', 'charlistas' ),
		'menu_name'             => __( 'charlistas', 'charlistas' ),
		'name_admin_bar'        => __( 'charlistas', 'charlistas' ),
		'archives'              => __( 'charlistas', 'charlistas' ),
		'attributes'            => __( 'charlistas', 'charlistas' ),
		'parent_item_colon'     => __( 'Basado en:', 'charlistas' ),
		'all_items'             => __( 'Todos los charlistas', 'charlistas' ),
		'add_new_item'          => __( 'Agregar nueva charla', 'charlistas' ),
		'add_new'               => __( 'Agregar nueva', 'charlistas' ),
		'new_item'              => __( 'nueva Charla', 'charlistas' ),
		'edit_item'             => __( 'editar Charla', 'charlistas' ),
		'update_item'           => __( 'actualizar', 'charlistas' ),
		'view_item'             => __( 'Ver Charla', 'charlistas' ),
		'view_items'            => __( 'ver la Charla', 'charlistas' ),
		'search_items'          => __( 'buscar una Charla', 'charlistas' ),
		'not_found'             => __( 'no se encuentra', 'charlistas' ),
		'not_found_in_trash'    => __( 'no se encuentra en la basura', 'charlistas' ),
		'featured_image'        => __( 'imagen destacada', 'charlistas' ),
		'set_featured_image'    => __( 'seleccionar imagen destacada', 'charlistas' ),
		'remove_featured_image' => __( 'remover imagen destacada', 'charlistas' ),
		'use_featured_image'    => __( 'usar imagen destacada', 'charlistas' ),
		'insert_into_item'      => __( 'insertar en el item', 'charlistas' ),
		'uploaded_to_this_item' => __( 'Subido a este artículo', 'charlistas' ),
		'items_list'            => __( 'Lista de artículos', 'charlistas' ),
		'items_list_navigation' => __( 'Lista de elementos de navegación', 'charlistas' ),
		'filter_items_list'     => __( 'Primer elemento del articulo', 'charlistas' ),
	);
	$args = array(
		'label'                 => __( 'charlistas', 'charlistas' ),
		'description'           => __( 'charlistas', 'charlistas' ),
		'labels'                => $labels,
		'show_in_rest' => true,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes', 'excerpt' ),
		'taxonomies'            => array( 'categoria-charlistas', 'etiqueta-charlistas', ), 
		'rewrite' => true,
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true, 
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-book-alt',
		'menu_position' => null,
		'query_var' => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post', 
		'rewrite' => array('slug' => 'charlistas', 'with_front' => FALSE)
		
	);




	register_post_type( 'charlistas', $args );

}

 /*categorias personalizadas para charlistas*/
 function categoria_charlistas() {

	register_taxonomy(
		'categoria-charlistas',
		'charlistas',
		array(
			'label' => __( 'Categoria charlistas' ),
			'rewrite' => array( 'slug' => 'categoria-charlistas' ),
			'hierarchical' => true,
			 // Allow automatic creation of taxonomy columns on associated post-types table?
			 'show_admin_column'   => true,
			 // Show in quick edit panel?
			 'show_in_quick_edit'  => true,
		)
	);
}
add_action( 'init', 'categoria_charlistas' );


function etiqueta_charlistas() {

register_taxonomy(
			'etiqueta-charlistas','charlistas',array(
			'hierarchical' => false,
			'labels' => $labels,
			'label' => __( 'Etiqueta charlistas' ),
			 // Allow automatic creation of taxonomy columns on associated post-types table?
			 'show_admin_column'   => true,
			 // Show in quick edit panel?
			 'show_in_quick_edit'  => true,
			'update_count_callback' => '_update_post_term_count',
			'charlaquery_var' => true,
			'rewrite' => array( 'slug' => 'etiqueta-charlistas' ),
		)
	);




}
add_action( 'init', 'etiqueta_charlistas' );

function display_charlistas( $charlaquery ) {
	if( is_category() || is_tag() && empty( $charlaquery->charlaquery_vars['charlistasfilter'] ) ) {
	$charlaquery->set( 'post_type', array(
	'post', 'nav_menu_item', 'charla', 
	'post', 'nav_menu_item', 'charlistas', 
	));
	return $charlaquery;
	}
   }
   
   add_filter( 'pre_get_posts', 'display_charlistas' );
   include get_template_directory() . '/titan/charlistas/campos-charlistas.php';
