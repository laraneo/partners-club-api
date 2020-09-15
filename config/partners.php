<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lista de estatus de Control de Acceso
    |--------------------------------------------------------------------------
    |
    | Esta opcion muestra la lista de diferentes casos de error para el
    | registro de control de acceso, categorizadas por estatus
    |
    */
    'ACCESS_CONTROL_STATUS' => [
        'SOCIO_INACTIVO' => -1,
        'SOCIO_ACCION_SALDO_DEUDOR' => -2,
        'SOCIO_ACCION_INACTIVA' => -3,
        'SOCIO_BLOQUEO_EXPEDIENTE' => -4,
        'SOCIO_FAMILIAR_INCORRECTO' => -5,
        'SOCIO_LISTA_EXCEPCION' => -6,
        'INVITADO_VISITAS_POR_MES' => -7,
        'INVITADO_INACTIVO' => -8,
        'INVITADO_INCORRECTO' => -9,
        'INVITADO_LISTA_EXCEPCION' => -10,
    ],

];
