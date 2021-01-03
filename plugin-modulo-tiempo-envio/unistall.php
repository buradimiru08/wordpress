<?php

/*
* Archivo de desinstalacion
*/

//Solo se ejecuta la desinstalacion si es WordPress quien lo solicita
defined('ABSPATH') or die( "Bye bye" );
if(!defined('WP_UNINSTALL_PLUGIN'))
{
    die;
}
?>
