<?php
/*
Plugin Name: Titan días de envios
Plugin URI: https://vtorres.cl
Description: Plugin que permite agregar dos metabox al single product de woocommerce, para mostrar dias de despacho o mensajes relacionados.
Version: 1.0
Author: Vladimir Torres
Author URI: https://vtorres.cl
License: GPL2
*/


//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die("Chau Chau");

//Aqui se definen las constantes
define('TITAN_RUTA', plugin_dir_path(__FILE__));
define('TITAN_NOMBRE', 'dias-envio');


//Archivos externos.
//wp_register_style( 'TITAN_NOMBRE', '/includes/' );

//Archivos de estilos y script.
function titan_estilos_plugin_dias()
{

    wp_enqueue_style('iconos', plugins_url('/includes/css/all.css', __FILE__));
    wp_enqueue_style('iconos');

    wp_register_style('titan_style', plugins_url('/includes/css/titan-style.css', __FILE__));
    wp_enqueue_style('titan_style');
    wp_register_script( 'bootstrap',  plugin_dir_url( __FILE__ ) . '/includes/js/bootstrap.min.js' , array( 'jquery' ), 'all', true );

    wp_enqueue_script('bootstrap', array('jquery'), true);
    
    wp_register_script('titan_js', plugins_url('/includes/js/titan_js.js', __FILE__));
    wp_enqueue_script('titan_js', array('jquery'), true);
    
    wp_register_script('popper', plugins_url('/includes/js/popper.js', __FILE__));
    wp_enqueue_script('popper', array('jquery'), true);

}

add_action('wp_enqueue_scripts', 'titan_estilos_plugin_dias');

//add_action( 'admin_init','your_namespace');



// -----------------------------------------
// 1. agregamos los metabox al single product de woocommerce :)!

add_action('woocommerce_product_options_pricing', 'modulo_metabox_dias');

function modulo_metabox_dias()
{

    // CAMPO 1 
    woocommerce_wp_text_input(array(
        'id'          => 'titan_campo_texto_dias',
        'label'       => __('Inserte dias de envio', 'woocommerce'),
        'placeholder' => 'Jueves, viernes, etc..',
        'desc_tip'    => 'true',
        'type'        => 'text',
        'description' => __('ingresar tu día de entrega.', 'woocommerce')
    ));

     // CAMPO 2
     woocommerce_wp_text_input(array(
        'id'          => 'titan_campo_texto_horas',
        'label'       => __('Inserte horas de envio', 'woocommerce'),
        'placeholder' => '10am, 11am,etc..',
        'desc_tip'    => 'true',
        'type'        => 'text',
        'description' => __('ingresar tu horario.', 'woocommerce')
    ));
   
}



// -----------------------------------------
// 2. Guardar el valor meta box  titan campo texto.
// CAMPO 1 
add_action('save_post_product', 'modulo_gurdar_dias');

function modulo_gurdar_dias($product_id)
{
    global $pagenow, $typenow;
    if ('post.php' !== $pagenow || 'product' !== $typenow) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['titan_campo_texto_dias'])) {
        if ($_POST['titan_campo_texto_dias'])
            update_post_meta($product_id, 'titan_campo_texto_dias', $_POST['titan_campo_texto_dias']);
    } else delete_post_meta($product_id, 'titan_campo_texto_dias');
}



// CAMPO 2
add_action('save_post_product', 'modulo_gurdar_horas');

function modulo_gurdar_horas($product_id)
{
    global $pagenow, $typenow;
    if ('post.php' !== $pagenow || 'product' !== $typenow) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['titan_campo_texto_horas'])) {
        if ($_POST['titan_campo_texto_horas'])
            update_post_meta($product_id, 'titan_campo_texto_horas', $_POST['titan_campo_texto_horas']);
    } else delete_post_meta($product_id, 'titan_campo_texto_horas');
}


// -----------------------------------------
// 3. Mostrar campo en la página de producto
// CAMPO 1 
add_action('woocommerce_single_product_summary', 'modulo_display_dias', 31);

function modulo_display_dias()
{
    global $product;
    if ($product->get_type() <> 'variable' && $titan_campo_texto_dias = get_post_meta($product->get_id(), 'titan_campo_texto_dias', true)) {
        //aqui imprimimos el dìa
        echo '<div class="dias-de-envios filas">';
        echo '<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="'  . ($titan_campo_texto_dias) . '"><i class="fa fa-calendar-check"></i> Envio todos los días: ' . ($titan_campo_texto_dias) . '  </button>';
    }

}



// CAMPO 2
add_action('woocommerce_single_product_summary', 'modulo_display_horas', 31);

function modulo_display_horas()
{
    global $product;
    if ($product->get_type() <> 'variable' && $titan_campo_texto_horas = get_post_meta($product->get_id(), 'titan_campo_texto_horas', true)) {
        //aqui imprimimos el 
        echo '<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="' . ($titan_campo_texto_horas) . '"><i class="fa fa-clock"></i> Hora en que se despacha:' . ($titan_campo_texto_horas) . '</button>';
        echo '</div>';
    }
}




