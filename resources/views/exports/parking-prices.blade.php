<table cellpadding="0" cellspacing="0" width="100%" style="font-family: Calibri;font-size: 11px;text-align: center;color: #000;" border="0">
    <thead>
    <tr style="vertical-align: middle;height: 60px;">
        <th colspan="3" style="border: 2px solid #999999;border-right: 0 solid transparent;text-align: left;padding-left: 30px;">
            <img src="images/atomikal-logo-blanco.png" style="" alt="EfronArq">
        </th>
        <th colspan="5" style="font-size: 14px;border: 2px solid #999999;border-left: 0 solid transparent;text-align: right;padding-right: 30px;">Proyecto: Mirador</th>
    </tr>
    <tr>
        <th colspan="8">&nbsp;</th>
    </tr>
    <tr style="height: 40px;">
        <th colspan="7" style="border: 2px solid #999999;border-right: 0 solid transparent;text-align: center;padding-left: 30px;font-size: 14px;background: #dee2e6;">ESTACIONAMIENTOS</th>
        <th colspan="1" style="border: 2px solid #999999;text-align: center;padding-left: 30px;font-size: 14px;background: #dee2e6;">PRECIOS DE VENTA</th>
    </tr>
    <tr style="background-color: #dee2e6;vertical-align: middle;height: 20px;">
        <th style="border: 1px solid #999999;border-top: 0 solid transparent;border-left: 2px solid #999999;border-bottom: 2px solid #999999;">PROYECTO</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">PISO</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">ESTAC.</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">TIPO</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">A. Techada (M2)</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">A. Libre (M2)</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">A. Total (M2)</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 1px solid #999999;">CLOSET</th>
        <th style="border-top: 0 solid transparent;border-bottom: 2px solid #999999;border-right: 2px solid #999999;">PRECIO</th>
    </tr>
    </thead>
    <tbody style="border: 2px solid #999999;">
    @foreach($parkingLots as $parkingLot)
        <tr>
            <td style="border: 1px solid #999999;border-top: 0 solid transparent;">{{ $parkingLot->project->name }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $parkingLot->address->floor }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $parkingLot->address->address }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $parkingLot->type }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $parkingLot->roofed_area }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $parkingLot->free_area }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">
                {{ $parkingLot->roofed_area + $parkingLot->free_area }}
            </td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">{{ $parkingLot->closet }}</td>
            <td style="border-top: 0 solid transparent;border-bottom: 1px solid #999999;border-right: 1px solid #999999;">
                @if($parkingLot->availability === 'VENDIDO')
                    {{ $parkingLot->availability }}
                @else
                    {{ $parkingLot->project->currency === 'PEN' ? 'S/.' : 'US$.' }} {{ number_format($parkingLot->price) }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
