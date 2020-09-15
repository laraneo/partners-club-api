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
        }

        </style>
    </head>
    <body>
            <header>Reporte de Control de Acceso</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            <table width="100%" cellspacing="0" page-break-inside: auto>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Ubicacion</th>
                        <th>Accion</th>
                        <th>CI</th>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Invitado</th>
                   </tr>
               <thead>
                <tbody>
                @foreach ($data as $element)
                    <tr>
                        <td>{{ $element->created ? $element->created : '' }}</td>
                        <td>{{ $element->location ? $element->location()->first()->description : '' }}</td>
                        <td>{{ $element->share? $element->share()->first()->share_number : '' }}</td>
                        <td>{{ $element->person ? $element->person()->first()->rif_ci : '' }}</td>
                        <td>{{ $element->person ? $element->person()->first()->card_number : '' }}</td>
                        <td>{{ $element->person ? $element->person()->first()->name : '' }} {{ $element->person ? $element->person()->first()->last_name : '' }}</td>
                        <td>{{ $element->status == 1 ? 'OK' : '' }}</td>
                        <td>
                            @if ($element->guest)
                                <div>{{ $element->guest? $element->guest()->first()->name: '' }} {{ $element->guest ? $element->guest()->first()->last_name : '' }}</div>
                                <div>CI: {{ $element->guest ? $element->guest()->first()->rif_ci : '' }}</div>
                            @else
                            -
                            @endif 
                        </td>
                    </tr> 
                @endforeach
                 <tbody>
            </table>
    </body>
</html>