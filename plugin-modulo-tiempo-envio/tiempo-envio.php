<?php
/*
Plugin Name: Titan Tiempo de entrega
Plugin URI: https://vtorres.cl
Description: Plugin que permite agregar dos metabox al single product de woocommerce, para mostrar tiempos de despacho o mensajes relacionados.
Version: 1.0
Author: Vladimir Torres
Author URI: https://vtorres.cl
License: GPL2
*/


//Evita que un usuario malintencionado ejecute codigo php desde la barra del navegador
defined('ABSPATH') or die("Chau Chau");

//Aqui se definen las constantes
define('TITAN_RUTA', plugin_dir_path(__FILE__));
define('TITAN_NOMBRE', 'tiempo-envio');


//Archivos externos.
//wp_register_style( 'TITAN_NOMBRE', '/includes/' );

//Archivos de estilos y script.
function titan_estilos_plugin()
{
    wp_register_style('titan_style', plugins_url('/includes/css/tiempo-envio.css', __FILE__));
    wp_enqueue_style('titan_style');
    wp_register_script('titan_js', plugins_url('titan_js.js', __FILE__));
    wp_enqueue_script('titan_js');
}

add_action('wp_enqueue_scripts', 'titan_estilos_plugin');

//add_action( 'admin_init','your_namespace');



// -----------------------------------------
// 1. agregamos los metabox al single product de woocommerce :)!

add_action('woocommerce_product_options_pricing', 'modulo_tiempo_envio_add_titan_campo_texto_to_products');

function modulo_tiempo_envio_add_titan_campo_texto_to_products()
{

    // CAMPO 1 
    woocommerce_wp_text_input(array(
        'id'          => 'titan_campo_texto',
        'label'       => __('Inserte tiempo de envio', 'woocommerce'),
        'placeholder' => 'envio en 24 horas o más..',
        'desc_tip'    => 'true',
        'type'        => 'text',
        'description' => __('ingresar tu texto.', 'woocommerce')
    ));
    // CAMPO 1 
    woocommerce_wp_text_input(array(
        'id'          => 'titan_campo_texto_dos',
        'label'       => __('Inserte tiempo de envio', 'woocommerce'),
        'placeholder' => 'Tiempo de envío: 3-6 días ',
        'desc_tip'    => 'true',
        'type'        => 'text',
        'description' => __('ingresar tu texto.', 'woocommerce')
    ));
}



// -----------------------------------------
// 2. Guardar el valor meta box  titan campo texto.
// CAMPO 1 
add_action('save_post_product', 'modulo_tiempo_envio_guardar_datos');

function modulo_tiempo_envio_guardar_datos($product_id)
{
    global $pagenow, $typenow;
    if ('post.php' !== $pagenow || 'product' !== $typenow) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['titan_campo_texto'])) {
        if ($_POST['titan_campo_texto'])
            update_post_meta($product_id, 'titan_campo_texto', $_POST['titan_campo_texto']);
    } else delete_post_meta($product_id, 'titan_campo_texto');
}

// CAMPO 2
add_action('save_post_product', 'modulo_tiempo_envio_guardar_datos_dos');
function modulo_tiempo_envio_guardar_datos_dos($product_id)
{
    global $pagenow, $typenow;
    if ('post.php' !== $pagenow || 'product' !== $typenow) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['titan_campo_texto_dos'])) {
        if ($_POST['titan_campo_texto_dos'])
            update_post_meta($product_id, 'titan_campo_texto_dos', $_POST['titan_campo_texto_dos']);
    } else delete_post_meta($product_id, 'titan_campo_texto_dos');
}

// -----------------------------------------
// 3. Mostrar campo en la página de producto
// CAMPO 1 
add_action('woocommerce_single_product_summary', 'modulo_tiempo_envio_mostrar_campo_titan_texto', 30);

function modulo_tiempo_envio_mostrar_campo_titan_texto()
{
    global $product;
    if ($product->get_type() <> 'variable' && $titan_campo_texto = get_post_meta($product->get_id(), 'titan_campo_texto', true)) {
        //aqui imprimimos el 
        echo '<div class="tiempos-de-envios filas">';

        echo '<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="' . ($titan_campo_texto) . '"><i class="far fa-clock"></i> Enviar en 24 horas </button>';
    }
}


// CAMPO 2
add_action('woocommerce_single_product_summary', 'modulo_tiempo_envio_mostrar_campo_titan_texto_dos', 30);

function modulo_tiempo_envio_mostrar_campo_titan_texto_dos()
{
    global $product;
    if ($product->get_type() <> 'variable' && $titan_campo_texto_dos = get_post_meta($product->get_id(), 'titan_campo_texto_dos', true)) {
        //aqui imprimimos el 
        echo '<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="' . ($titan_campo_texto_dos) . '"><i class="fas fa-plane"></i> Tiempo de envío: 3-6 días  </button>';
        echo '</div>';
    }
}
