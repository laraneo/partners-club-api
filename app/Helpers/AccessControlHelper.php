<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class AccessControlHelper {

	public function __construct( ) {
	}

    // Funcion para usar en el filtro del reporte para el estatus
	public function accessControl($status) {
        // Esta clase ya muestra el arreglo de los estatus que se encuentran en el archivo /config/partners.php -> linea 13
        $arrayStatus = Config::get('partners.ACCESS_CONTROL_STATUS'); 
		return $status;
    }
    

    // Funcion para usar en el registro de control de acceso para calcular el estatus
    function getAccesControlStatus($accesStatus, $currentStatus) {
		return pow($accesStatus, $currentStatus);
	}
}