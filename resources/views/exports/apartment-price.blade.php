<table cellpadding="0" cellspacing="0" width="100%" style="font-family: Calibri,sans-serif;font-size: 11px;text-align: center;color: #000;" border="0">
    <thead>
    <tr style="vertical-align: middle;height: 60px;">
        <th colspan="3" style="border: 2px solid #999999;border-right: 0 solid transparent;text-align: left;padding-left: 30px;">
            <img src="{{ public_path('images/atomikal-logo-blanco.png') }}" style="" alt="EfronArq">
        </th>
        <th colspan="6" style="font-size: 14px;border: 2px solid #999999;border-left: 0 solid transparent;text-align: right;padding-right: 30px;">
            Proyecto: {{ $apartments->first()->project->name }}
        </th>
    </tr>
    <tr>
        <th colspan="8">&nbsp;</th>
    </tr>
    <tr style="height: 40px;">
        <th colspan="6" style="border: 2px solid #999999;border-right: 0 solid transparent;text-align: center;padding-left: 30px;font-size: 14px;background: #dee2e6;">DEPARTAMENTOS</th>
        <th colspan="3" style="border: 2px solid #999999;text-align: center;padding-left: 30px;font-size: 14px;background: #dee2e6;">PRECIOS DE VENTA</th>
    </tr>
    <tr style="background-color: #dee2e6;vertical-align: middle;height: 20px;">
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">DPTO</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">TIPO</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">#DORM</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">A. Techada (M2)</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">A. Libre (M2)</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">A. Total (M2)</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">CONSTRUCCIÓN</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 2px solid #999999;">ENTREGA</th>
    </tr>
    </thead>
    <tbody style="border: 2px solid #999999;">
    @foreach($apartments as $apartment)
        <tr>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $apartment->name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $apartment->apartmentType->type_name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $apartment->apartmentType->bedroom }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $apartment->apartmentType->roofed_area }} m<sup>2</sup></td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $apartment->apartmentType->free_area }} m<sup>2</sup></td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">
                {{ $apartment->apartmentType->roofed_area + $apartment->apartmentType->free_area }} m<sup>2</sup>
            </td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $apartment->availability }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $apartment->availability }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
