<?php

/*cutoas para productos woocommerce*/
/*Autor Vladimir Torres.
/*Web: vtorres.cl
/*Cliente: Forsend.cl
/*Version: 1.0.0
/*Año:2020.
/* Espero lo disfruten y puedan mejorar.
Git:
*/



add_action('woocommerce_before_add_to_cart_button', 'titan_calculadora_precio');

function titan_calculadora_precio()
{
    global $product;
    //aquí imprimimos los div que iran bajo el precio y antes del botón agregar al carro.
    echo '<div class="cuotas-modulo primera-linea"><span>COTIZA TU PRODUCTO:</span></div>';
    echo '<div class="cuotas-modulo" id="precio_unitario">Precio unitario de este producto:<span class="precio_unitario_total"></span></div>';
    echo '<div class="cuotas-modulo" id="total">Precio total <span class="precio_total"></span> por <span class="precio_total_unidad"></span>ítem</div>';
    echo '<div class="cuotas-modulo" id="subtot_24">Paga hasta en <span>24</span> cuotas de <span class="subtotal"></span> sin interés</div>';
    echo '<div class="cuotas-modulo" id="subtot">Paga hasta en <span>12</span> cuotas de <span class="subtotal"></span> sin interés</div>';
    echo '<div class="cuotas-modulo ultima-linea">Métodos de pago: <span class="tc-cuotas-modulo"></span></div>';
    $price = $product->get_price();
    $currency = get_woocommerce_currency_symbol();
    wc_enqueue_js("
    $('[name=quantity]').on('input change', function() { 
         var qty = $(this).val();
         var price = '" . esc_js($price) . "';
         var price_string = (price*qty/12).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
         var price_string_24 = (price*qty/24).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
         var price_final = (price*qty).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
         var precio_unitario = (price*1).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
         $('#subtot_24 > span.subtotal').html('" . esc_js($currency) . "'+price_string_24);
         $('#subtot > span.subtotal').html('" . esc_js($currency) . "'+price_string);
         $('#precio_unitario > span.precio_unitario_total').html('" . esc_js($currency) . "'+precio_unitario);
         $('#total > span.precio_total').html('" . esc_js($currency) . "'+ price_final);
         $('#total > span.precio_total_unidad').html( qty );
         $('.woocommerce-Price-amount.amount > bdi').html('" . esc_js($currency) . "'+price_final);
      }).change(); 
   ");

   
}
