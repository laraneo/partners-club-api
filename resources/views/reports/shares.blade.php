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
            <header>Reporte de Acciones</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            <table width="100%" cellspacing="0" page-break-inside: auto>
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>Accion Padre</th>
                        <th>Status</th>
                        <th>Forma de Pago</th>
                        <th>Tipo</th>
                        <th>Socio</th>
                        <th>Titular</th>
                        <th>Facturador</th>
                        <th>Fiador</th>
                   </tr>
               <thead>
                <tbody>
                @foreach ($data as $element)
                    <tr>
                        <td>{{ $element->share_number }}</td> 
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
                    @if (count($element->shareMovements))
                        <tr>
                            <td colspan="9" align="center">
                                <div class="share-movement">Movimientos de Accion N° {{ $element->share_number }}</div>
                                <table width="100%" cellspacing="0" border="1">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Descripcion</th>
                                            <th>Moneda</th>
                                            <th>Tarifa</th>
                                            <th>Moneda</th>
                                            <th>Precio Venta</th>
                                            <th>Socio</th>
                                            <th>Titular</th>
                                            <th>Procesado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($element->shareMovements as $element)
                                            <tr>
                                                <td>{{ $element->created }}</td>
                                                <td>{{ $element->transaction ? $element->transaction()->first()->description : '' }}</td>
                                                <td>{{ $element->description }}</td>
                                                <td>{{ $element->rateCurrency ? $element->rateCurrency()->first()->description : '' }}</td>
                                                <td>{{ $element->rate }}</td>
                                                <td>{{ $element->saleCurrency ? $element->saleCurrency()->first()->description : '' }}</td>
                                                <td>{{ $element->number_sale_price }}</td>
                                                <td>{{ $element->partner ? $element->partner()->first()->name : '' }} {{ $element->partner ? $element->partner()->first()->last_name : '' }}</td>
                                                <td>{{ $element->titular ? $element->titular()->first()->name : '' }} {{ $element->titular ? $element->titular()->first()->last_name : '' }}</td>
                                                <td>{{ $element->number_procesed === 1 ? 'SI' : 'NO' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            <td>
                        </tr>
                    @endif
                @endforeach
                 <tbody>
            </table>
    </body>
</html>