<html>
    <head></head>
    <body>

            <header>Reporte de Cumpleaños para el mes de {{ ucwords($month) }}</header>
            <footer>
                <div class="page-number"></div> 
            </footer>
            <table width="100%" cellspacing="0" page-break-inside: auto>
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>Parentesco</th>
                        <th>Rif/CI</th>
                        <th>Nombre</th>
                        <th>Nacimiento</th>
                   </tr>
               <thead>
                <tbody>
                @foreach ($data as $element)
                    <tr>
                        <td>{{ $element->shareList }}</td> 
                        <td>{{ $element->relation ? $element->relation: '' }} </td> 
                        <td>{{ $element->rif_ci }}</td> 
                        <td>{{ $element->name }} {{ $element->last_name }}</td> 
                        <td>{{ $element->birth_date }}</td> 
                        
                    </tr> 
                @endforeach
                 <tbody>
            </table>
    </body>
</html>