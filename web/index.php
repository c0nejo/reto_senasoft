<?php

    include_once '../lib/helpers.php';
    include_once '../view/partials/header.php';
    
        //include_once '../view/facturas/prueba_factura.php';
        if (isset($_GET['modulo'])) {
            resolve();
        }

    include_once '../view/partials/footer.php';
    include_once '../view/partials/scripts.php';
