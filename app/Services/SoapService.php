<?php

namespace App\Services; 

use SoapClient;

class SoapService
{

  public function __construct() {
		$this->url = env('WS_SOCIO_URL');
		$this->domain = env('WS_SOCIO_DOMAIN_ID');
	}

  public function getToken() {
    date_default_timezone_set('America/Caracas');
    $domain_id =  $this->domain;
    $date = date('Ymd');
    $calculated_token = md5($domain_id.$date);
    $calculated_token = base64_encode(strtoupper(md5($domain_id.$date )));
    return $calculated_token;
  }

  public function getWebServiceClient(string $url) {
    $opts = array(
      'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
    );
    $params = array (
      'encoding' => 'UTF-8', 
      'verifypeer' => false, 
      'verifyhost' => false, 
      'soap_version' => SOAP_1_2, 
      'trace' => 1, 'exceptions' => 1, 
      "connection_timeout" => 180, 
      'stream_context' => stream_context_create($opts),
    );
    return new SoapClient($url,$params);
  }

    public function getSaldo($share) {
        $url = $this->url;
        try{
            $client = $this->getWebServiceClient($url);
            $response = $client->getSaldoXML([
              'group_id' => $share,
              'token' => $this->getToken(),
            ])->GetSaldoXMLResult;
            $i = 0;
            $newArray = array();
            foreach ($response as $key => $value) {
              if ($i==1) {
                $myxml = simplexml_load_string($value);				
                $registros= $myxml->NewDataSet->Table;
                $arrlength = @count($registros);
                for($x = 0; $x < $arrlength; $x++) {
                  array_push($newArray, $registros[$x]);
                }
              }
              $i++;
            }
            return $newArray;
        }
        catch(SoapFault $fault) {
            echo '<br>'.$fault;
        }
  }

  public function getUnpaidInvoices() {
    $url = $this->url;
    try{
        $client = $this->getWebServiceClient($url);
        $user = auth()->user()->username;
        $response = $client->GetSaldoDetalladoXML([
            'group_id' => $user,
            'token' => $this->getToken(),
        ])->GetSaldoDetalladoXMLResult;
        $i = 0;
        $newArray = array();
        foreach ($response as $key => $value) {
            if ($i==1) {
            $myxml = simplexml_load_string($value);				
            $registros= $myxml->NewDataSet->Table;
            $arrlength = @count($registros);
            $acumulado = 0;
            for($x = 0; $x < $arrlength; $x++) {
                $monto = $registros[$x]->saldo;
                $acumulado = bcadd($acumulado, $monto, 2);
                $registros[$x]->acumulado = $acumulado; 
                array_push($newArray, $registros[$x]);
            }
            }
            $i++;
        }
        foreach ($newArray as $key => $value) {
          $newArray[$key]->originalAmount = $value->saldo;
          $newArray[$key]->saldo = number_format((float)$value->saldo,2);
          $newArray[$key]->total_fac = number_format((float)$value->total_fac,2);
          $newArray[$key]->acumulado = number_format((float)$value->acumulado,2);
        }
        return response()->json([
            'success' => true,
            'data' => $newArray,
            'total' => $acumulado
        ]);;
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
  }

  public function getReportedPayments() {
    // $url = "http://190.216.224.53:8080/wsServiciosSociosCCC3/wsSociosCCC.asmx?WSDL";
    $url = $this->url;
    try{
        $client = $this->getWebServiceClient($url);
        $user = auth()->user()->username;
        $response = $client->GetReportePagosXML([
            'group_id' => $user,
            'token' => $this->getToken(),
        ])->GetReportePagosXMLResult;
        $i = 0;
        $newArray = array();
        foreach ($response as $key => $value) {
            if ($i==1) {
            $myxml = simplexml_load_string($value);				
            $registros= $myxml->NewDataSet->Table;
            $arrlength = @count($registros);
            for($x = 0; $x < $arrlength; $x++) {
                array_push($newArray, $registros[$x]);
            }
            }
            $i++;
        }
        foreach ($newArray as $key => $value) {
          $newArray[$key]->nMonto = number_format((float)$value->nMonto,2);
        }
        return $newArray;
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
  }

  public function getStatusAccount() {
    //$url = "http://190.216.224.53:8080/wsServiciosSociosCCC3/wsSociosCCC.asmx?WSDL";
    $url = $this->url;
    $client = $this->getWebServiceClient($url);
    $user = auth()->user()->username;
    $parametros = [
      'group_id' => $user,
      'token' => $this->getToken(),
    ];
    try{
      $response = $client->GetEstadoCuentaXML($parametros)->GetEstadoCuentaXMLResult;
      $i = 0;
      $newArray = array();
      foreach ($response as $key => $value) {
        if ($i==1) {
          $myxml = simplexml_load_string($value);				
          $registros= $myxml->NewDataSet->Table;
          $arrlength = @count($registros);
          $acumulado = 0;
          for($x = 0; $x < $arrlength; $x++) {
            $monto = $registros[$x]->total_fac;
            $acumulado = bcadd($acumulado, $monto, 2);
            $registros[$x]->acumulado = $acumulado; 
            array_push($newArray, $registros[$x]);
        }
        }
        $i++;
      }
      foreach ($newArray as $key => $value) {
        $newArray[$key]->saldo = number_format((float)$value->saldo,2);
        $newArray[$key]->total_fac = number_format((float)$value->total_fac,2);
        $newArray[$key]->acumulado = number_format((float)$value->acumulado,2);
      }
      return response()->json([
        'success' => true,
        'data' => $newArray,
        'total' => $acumulado
      ]);;

    }
    catch(SoapFault $fault) {
      echo '<br>'.$fault;
    }
}


// function EstadoCuenta($xml) {
// 	$EstadoCuenta = "";

// 	//echo  "<h3>Estado de Cuenta</h3>";

// 	$i = 0;
// 	$status = 0;
// 	//echo '<div id="gmp_de_persona" class="table-responsive card-body ew-grid-middle-panel">';
// 	echo '<div id="gmp_de_persona" class="table-responsive ew-grid-middle-panel">';

// 	echo "<table class='table table-striped' border='1' width='100%'>";
// 	//echo '<table id="tbl_estadocuenta" class="table ew-table">';
	
	
// 	foreach ($xml as $key => $value)
// 	{
// 		//foreach($value as $ekey => $eValue)
// 		{
// 			//echo $i . "<br>";
// 			//print($key . " =* " . $value . "<br>");
// 			if ($i==1)
// 			{
// 				$myxml = simplexml_load_string($value);
// 				//print_r($myxml);
// 				//$array2 = stdToArray($value);
// 				//print_r($array2);
// 				//var_dump($array2);
				
// 				$registros= $myxml->NewDataSet->Table;
// 				//print_r( $registros);
// 				$arrlength = @count($registros);
// 				//echo $arrlength;
// 				// echo 'fact_num '  . " - ";
// 				// echo 'fec_emis '  . " - ";
// 				// echo '                    fact_venc'  . " - ";
// 				// echo 'descrip  '  . " - ";
// 				// echo 'saldo    ';
// 				// echo "<br>";

// 				echo '<thead class="thead-dark">';
// 				echo '<tr>';
// 				echo '<th scope="col">Nro</th>';
// 				echo '<th scope="col">Emision</th>';
// 				//echo '<th scope="col">Vencimiento</th>';
// 				echo '<th scope="col">Descripcion</th>';
// 				echo '<th scope="col">Tipo</th>';
// 				echo '<th scope="col">Debe</th>';
// 				echo '<th scope="col">Haber</th>';
// 				echo '<th scope="col">Acumulado</th>';
// 				echo '</tr>';
// 				echo '</thead>';

// 				$acumulado = 0;
// 				for($x = 0; $x < $arrlength; $x++) {
// 					//print_r ($registros[$x]);
// 					// echo $registros[$x]->fact_num . " - ";
// 					// echo $registros[$x]->fec_emis . " - ";
// 					// echo $registros[$x]->fact_venc . " - ";
// 					// echo $registros[$x]->descrip . " - ";
// 					// echo $registros[$x]->saldo;
// 					// echo "<br>";

// 					echo '<tr>';
					
// 					$value = $registros[$x]->fact_num;
// 					echo '<td align="center">' . $value 	. "</td>";
// 					$EstadoCuenta = $EstadoCuenta . ";" . $value;

// 					$date = date_create( $registros[$x]->fec_emis );
// 					$value = date_format($date, 'd-m-Y');
// 					echo '<td>' .  $value  	. "</td>";
// 					$EstadoCuenta = $EstadoCuenta . ";" . $value;


// 					/*
// 					$date2 = date_create( $registros[$x]->fact_venc );
// 					$value = date_format($date2, 'd-m-Y');
// 					echo '<td>' . $value . "</td>";
// 					$EstadoCuenta = $EstadoCuenta . ";" . $value;
// */

// 					$value = $registros[$x]->descrip;
// 					echo '<td>' . $value 	. "</td>";
// 					$EstadoCuenta = $EstadoCuenta . ";" . $value;
					

// 					$value = $registros[$x]->tipo;
// 					echo '<td align="center">' . $value 	. "</td>";
// 					$EstadoCuenta = $EstadoCuenta . ";" . $value;

// 					$value = $registros[$x]->total_fac;
// 					echo '<td type="number" align="right">' . $value 	. "</td>";
// 					$EstadoCuenta = $EstadoCuenta . ";" . $value;

// 					$value = $registros[$x]->saldo;
// 					echo '<td type="number" align="right">' . $value 	. "</td>";
// 					$EstadoCuenta = $EstadoCuenta . ";" . $value;
					
// 					echo '</tr>';
// 				}
				
				
// 				//echo '$status = ' . $status;
				
// 				if ($status >= 0)
// 				{
// 				//	echo '$saldo = ' . $myxml->NewDataSet->Table->saldo;
// 				}
// 			}
// 			$i++;

// 		}
// 	}
// 	echo "<tr>"  . "<td colspan='6'  align='right'><strong>Total</strong></td><td type='number' align='right'><b>" . $acumulado . "</b></td>"  . "</tr>";
// 	echo "</table>";
//	echo '<div>';
//}	

}