<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 40px;

                /** Extra personal styles **/
                border: 1px solid black;
                border-top: 0px;
                border-left: 0px;
                border-right: 0px;
                border-bottom: 1px solid black;
                text-align: left;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 30px; 

                text-align: center;
                line-height: 35px;
            }
            .page-number:before {
                content: "Pagina " counter(page);
            }
            thead th{
                font-size: 8px;
                border-bottom: 1px black solid;
                padding-bottom: 5px;
                text-align: left;
            }
            tbody td{
                font-size: 8px;
                padding-top: 5px;
                padding-bottom: 5px;
            }
            .share-movement {
                font-style: italic;
                font-weight: bold;
                margin-bottom: 10px;
                text-decoration: underline;
            }
        }

        </style>
    </head>
    <body>
            <table>
                   <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                   </tr>
                   <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Reporte de Acciones</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                   </tr>
                   <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                   </tr>
                    <tr>
                        <td>Accion</td>
                        <td>Accion Padre</td>
                        <td>Status</td>
                        <td>Forma de Pago</td>
                        <td>Tipo</td>
                        <td>Socio</td>
                        <td>Titular</td>
                        <td>Facturador</td>
                        <td>Fiador</td>
                   </tr>
                @foreach ($data as $element)
                    <tr>
                        <td><h1>{{ $element->share_number }}</h1></td> 
                        <td>
                            @if ($element->fatherShare)
                            {{ $element->fatherShare()->first()->share_number }}
                            @else
                            Principal
                            @endif 
                        </td>
                        <td>{{ $element->status === 1 ? 'Activo' : 'Inactivo' }}</td>
                        <td>{{ $element->paymentMethod ? $element->paymentMethod()->first()->description : '' }}</td>  
                        <td>{{ $element->shareType ? $element->shareType()->first()->description: '' }}</td>
                        <td>{{ $element->partner? $element->partner()->first()->name : '' }} {{ $element->partner? $element->partner()->first()->last_name : '' }}</td>
                        <td>{{ $element->titular ? $element->titular()->first()->name : '' }} {{ $element->titular ? $element->titular()->first()->last_name : '' }}</td>
                        <td>{{ $element->facturador ? $element->facturador()->first()->name : '' }} {{ $element->facturador ? $element->facturador()->first()->last_name : '' }}</td>
                        <td>{{ $element->fiador ? $element->fiador()->first()->name : '' }} {{ $element->fiador ? $element->fiador()->first()->last_name : '' }}</td>
                    </tr> 
                    <!-- @if (count($element->shareMovements))
                        <tr>
                            <td></td>
                            <td colspan="9" align="center">
                                Movimientos de Accion N° {{ $element->share_number }}
                            </td>
                        </tr>
                    @endif -->
                    @if (count($element->shareMovements))
                        <tr>
                            <td>-----------</td>
                        </tr>

                        <tr>
                            <td colspan="9" align="center">
                            <table>
                            <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Movimientos de Accion N° {{ $element->share_number }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
                                    
                                        <tr>
                                            <td>-----------</td>
                                            <td>Fecha</td>
                                            <td>Tipo</td>
                                            <td>Descripcion</td>
                                            <td>Moneda</td>
                                            <td>Tarifa</td>
                                            <td>Moneda</td>
                                            <td>Precio Venta</td>
                                            <td>Socio</td>
                                            <td>Titular</td>
                                            <td>Procesado</td>
                                        </tr>

                                    
                                        @foreach ($element->shareMovements as $shareMovementElement)
                                            <tr>
                                                <td >-----------</td>
                                                <td>{{ $shareMovementElement->created }}</td>
                                                <td>{{ $shareMovementElement->transaction ? $shareMovementElement->transaction()->first()->description : '' }}</td>
                                                <td>{{ $shareMovementElement->description }}</td>
                                                <td>{{ $shareMovementElement->rateCurrency ? $shareMovementElement->rateCurrency()->first()->description : '' }}</td>
                                                <td>{{ $shareMovementElement->rate }}</td>
                                                <td>{{ $shareMovementElement->saleCurrency ? $shareMovementElement->saleCurrency()->first()->description : '' }}</td>
                                                <td>{{ $shareMovementElement->number_sale_price }}</td>
                                                <td>{{ $shareMovementElement->partner ? $shareMovementElement->partner()->first()->name : '' }} {{ $shareMovementElement->partner ? $shareMovementElement->partner()->first()->last_name : '' }}</td>
                                                <td>{{ $shareMovementElement->titular ? $shareMovementElement->titular()->first()->name : '' }} {{ $shareMovementElement->titular ? $shareMovementElement->titular()->first()->last_name : '' }}</td>
                                                <td>{{ $element->number_procesed === 1 ? 'SI' : 'NO' }}</td>
                                            </tr>
                                        @endforeach
                                </table>
                            <td>
                        </tr>
                    @endif
                @endforeach
            </table>
    </body>
</html>

<!--  -->