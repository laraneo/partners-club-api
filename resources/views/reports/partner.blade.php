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
            table td{
                font-size: 10px;
            }
.divTable{
	display: table;
	width: 100%;
}
.divTableRow {
	display: table-row;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
}
.divTableCell, .divTableHead {
	border: 1px solid #999999;
	display: table-cell;
	padding: 3px 10px;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
	font-weight: bold;
}
.divTableFoot {
	background-color: #EEE;
	display: table-footer-group;
	font-weight: bold;
}
.divTableBody {
	display: table-row-group;
}
.divTableCell .custom {
    width: 10%;
}
.caption {
    caption-side: right; 
    display: table-caption; 
    }

        </style>
    </head>
    <body>
            <header>Ficha del Socio</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            {{-- <div class="divTable" style="border: 1px solid #000;" >

<div class="divTableBody">
<div class="divTableRow">
<div class="divTableCell">Tipo</div>
<div class="divTableCell">Natural</div>
<div class="divTableCell">RIF/CI</div>
<div class="divTableCell">8334556</div>
<div class="divTableCell">Carnet</div>
<div class="divTableCell">345345345</div>
<div class="divTableCell">Vence</div>
<div class="divTableCell">17-FEB-2015</div>
<div class="caption">FOTO</div>
</div>

</div>
</div> --}}
            <div style="margin-bottom: 10px;">Socio</div>
            <table width="100%" cellspacing="0" border="1">
                    <tr>
                        <td>Tipo: {{ $data->type_person === 1 ? 'Natural' : 'Empresa' }}</td> 
                        <td>RIF/CI: {{ $data->rif_ci }}</td> 
                        <td>Carnet: {{ $data->card_number }}</td> 
                        <td>Vence: {{ $data->expiration_date }}</td> 
                        <td rowspan="8" width="100" align="center">
                            @if($data->picture && $data->picture !== '')
                                <img src={{ public_path() . '/storage/partners/'. $data->picture }} width="120" height="120">
                            @else
                                <img src={{ public_path() . '/images/partner-empty.png' }} width="120" height="120">
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">Nombre: {{ $data->name }}</td> 
                        <td colspan="2">Apellido: {{ $data->last_name }}</td>
                    </tr>

                    <tr>
                        <td colspan="1">Nacionalidad: Mexicana</td> 
                        <td colspan="1">Nacimiento: {{ $data->birth_date }}</td>
                        <td colspan="2">Estado Civil: {{ $data->maritalStatus ? $data->maritalStatus->description : '' }}</td>
                    </tr>

                    <tr>
                        <td colspan="2">Profesion : {{ $data->professionList }}</td> 
                        <td colspan="2">Representante: {{ $data->representante }}</td>
                    </tr>

                    <tr>
                        <td colspan="4">Direccion : {{ $data->address }}</td> 
                    </tr>

                    <tr>
                        <td colspan="1">Ciudad: {{ $data->city }}</td>  
                        <td colspan="1">Estado: {{ $data->state }}</td> 
                        <td colspan="1">Cod Posta: {{ $data->postal_code }}</td>  
                        <td colspan="1">Pais : {{ $data->country ? $data->country->description : '' }}</td> 
                    </tr>

                    <tr>
                        <td colspan="2">Telefonos : {{ $data->telephone1 }} / {{ $data->telephone2 }}</td>  
                        <td colspan="2">Celulares : {{ $data->phone_mobile1 }} / {{ $data->phone_mobile2 }}</td> 
                    </tr>

                    <tr>
                        <td colspan="4">Email: {{ $data->primary_email }}</td>
                    </tr>


                {{-- <tr>
                    <td>Tipo: Natural</td> <td>RIF/CI: 8334556</td> 
                    <td>Carnet: 345345345</td> <td>Vence: 17-FEB-2015</td> 
                    <td>Tipo: Natural</td> <td>RIF/CI: 8334556</td>
                    <td rowspan="8" width="100" align="center">
                        <img src={{ public_path() . '/storage/partners/3242424.png' }} width="120" height="120">
                    </td>
                  </tr>
                    <tr>
                    <td colspan="2">Nombre: Juan</td> <td colspan="4">Apellido: Perez</td>
                  </tr>
                    <tr>
                    <td colspan="1">Nacionalidad: Mexicana</td> <td colspan="1">Nacimiento: 27-DIC-1964</td>
                    <td colspan="2">Estado Civil: Casado</td> <td colspan="2">Vence: 17-FEB-2015</td>
                  </tr>
                    <tr>
                    <td colspan="2">Profesion : Ingeniero</td> <td colspan="4">Representante: Prueba</td>
                  </tr>
                    </tr>
                    <tr>
                    <td colspan="6">Direccion : Caracas, Venezuela</td> 
                  </tr>
                    <tr>
                    <td colspan="1">Ciudad : Caracas</td>  <td colspan="1">Estado : Miranda</td> 
                    <td colspan="2">Cod Posta : 1211</td>  <td colspan="2">Pais : Venezuela</td> 
                  </tr>
                    <tr>
                    <td colspan="2">Telefonos : 02395566765 / 02395566765</td>  
                    <td colspan="4">Celulares : 04245556767 / 04245556767</td> 
                  </tr>
                    <tr>
                    <td colspan="6">Email: correo@correo.com</td>
                  </tr> --}}
            </table>
            @foreach ($data->familyMembers as $element)
            <div style="margin: 10px 0px 10px 0px;">{{ $element->relationType ? $element->relationType->description : '' }}</div>
            <table width="100%" cellspacing="0" border="1">
                    <tr>
                        <td>Tipo: {{ $data->type_person === 1 ? 'Natural' : 'Empresa' }}</td> 
                        <td>RIF/CI: {{ $element->rif_ci }}</td> 
                        <td>Carnet: {{ $element->card_number }}</td> 
                        <td>Vence: {{ $element->expiration_date }}</td> 
                        <td rowspan="8" width="100" align="center">
                            @if($element->picture && $element->picture !== '')
                                <img src={{ public_path() . '/storage/partners/'. $element->picture }} width="120" height="120">
                            @else
                                <img src={{ public_path() . '/images/partner-empty.png' }} width="120" height="120">
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">Nombre: {{ $element->name }}</td> 
                        <td colspan="2">Apellido: {{ $element->last_name }}</td>
                    </tr>

                    <tr>
                        <td colspan="1">Nacionalidad: Mexicana</td> 
                        <td colspan="1">Nacimiento: {{ $element->birth_date }}</td>
                        <td colspan="2">Estado Civil: {{ $element->maritalStatus ? $element->maritalStatus->description : '' }}</td>
                    </tr>

                    <tr>
                        <td colspan="2">Profesion : {{ $element->professionList }}</td> 
                        <td colspan="2">Representante: {{ $element->representante }}</td>
                    </tr>

                    <tr>
                        <td colspan="4">Direccion : {{ $element->address }}</td> 
                    </tr>

                    <tr>
                        <td colspan="1">Ciudad: {{ $element->city }}</td>  
                        <td colspan="1">Estado: {{ $element->state }}</td> 
                        <td colspan="1">Cod Posta: {{ $element->postal_code }}</td>  
                        <td colspan="1">Pais : {{ $element->country ? $element->country->description : '' }}</td> 
                    </tr>

                    <tr>
                        <td colspan="2">Telefonos : {{ $element->telephone1 }} / {{ $element->telephone2 }}</td>  
                        <td colspan="2">Celulares : {{ $element->phone_mobile1 }} / {{ $element->phone_mobile2 }}</td> 
                    </tr>

                    <tr>
                        <td colspan="4">Email: {{ $element->primary_email }}</td>
                    </tr>
                    </table>
            @endforeach
    </body>
</html>