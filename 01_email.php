<?php

use util\Html;
use util\Autocarga;

require_once('./util/Autocarga.php');

Autocarga::autoload_reg();

Html::inicio('Email', ['./estilos/formulario.css', './estilos/general.css']);

session_start();

if( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['operacion'] == 'cerrar_sesion' ){
    $cookieparams = session_get_cookie_params();
    $name = session_name();

    setcookie($name, '', time() - 1000, $cookieparams['path'], $cookieparams['domain'], $cookieparams['secure'], $cookieparams['httponly']);

    session_unset();

    session_destroy();

    session_start();
}
?>


<form action="02_registros.php" method="POST">
    <fieldset>
        <legend>Indicar email</legend>
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
    </fieldset>
    <input type="submit" value="Enviar" name="operacion">
</form>

<?php
Html::fin();
?>