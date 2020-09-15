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
            <table width="100%" cellspacing="0">
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
                        <td></td>
                        <td></td>
                   </tr>
            <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Reporte General</td>
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
                        <td>Parentesco</td>
                        <td>Nombre</td>
                        <td>Rif/CI</td>
                        <td>Pasaporte</td>
                        <td>Carnet</td>
                        <td>Telf</td>
                        <td>Cel</td>
                        <td>Correo</td>
                        <td>Sexo</td>
                        <td>Status</td>
                   </tr>
                @foreach ($data as $element)
                    <tr>
                        <td>{{ $element->shareList }}</td> 
                        <td> {{ $element->relation ? $element->relation: '' }} </td> 
                        <td>{{ $element->name }} {{ $element->last_name }}</td> 
                        <td>{{ $element->rif_ci }}</td> 
                        <td>{{ $element->passport }}</td> 
                        <td>{{ $element->card_number }}</td> 
                        <td>{{ $element->telephone1 }}</td> 
                        <td>{{ $element->phone_mobile1 }}</td> 
                        <td>{{ $element->primary_email }}</td> 
                        <td>{{ $element->gender ? $element->gender()->first()->description : '' }}</td> 
                        <td>{{ $element->statusPerson? $element->statusPerson()->first()->description : '' }}</td> 
                    </tr> 
                @endforeach

            </table>
    </body>
</html>