<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: Calibri;font-size: 11px;text-align: center;color: #000;">
    <thead>
    <tr style="background-color: #B4C6E7;vertical-align: middle;height: 60px;">
        <th style="background-color: #B4C6E7;" colspan="3">
            <img src="images/atomikal-logo-blanco.png" style="" alt="EfronArq">
        </th>
        <th colspan="11" style="font-size: 14px; background-color: #B4C6E7;">Reporte de Visitas</th>
        <th style="background-color: #B4C6E7;" colspan="3">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="17">&nbsp;</th>
    </tr>
    <tr style="background-color: #B4C6E7;vertical-align: middle;height: 20px;">
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Visita</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Vendedor</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Fecha de visita</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Origen</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">DNI</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Nombres y Apellidos</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Correo</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Teléfono</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Proyecto</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Departamento</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Interesado</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Financiamiento</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Próxima acción</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Fecha de acción</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Estado de Acción</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Comentario de Acción</th>
        <th style="background-color: #B4C6E7;border: 1px solid #999999;">Estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($visits as $visit)
        <tr>
            <td style="border: 1px solid #999999;border-top: 0 solid transparent;">{{ $visit->id }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->user->name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->created_at }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->origin->name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->customer->dni }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->customer->full_name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->customer->email }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->customer->phone }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->project->name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->apartment->name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->interested ? 'Si' : 'No' }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->type_financing }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">
                {{ $visit->tracking->count() > 0 ? $visit->tracking->last()->action : '' }}
            </td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">
                {{ $visit->tracking->count() > 0 ? $visit->tracking->last()->action_at : '' }}
            </td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">
                {{ $visit->tracking->count() > 0 ? $visit->tracking->last()->status : '' }}
            </td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">
                {{ $visit->tracking->count() > 0 ? $visit->tracking->last()->comments : '' }}
            </td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $visit->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
