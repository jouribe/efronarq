<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<table width="100%" style="color: #696969;">
    <tbody>
        <tr>
            <td width="30%">
                <img src="storage/{{$visit['project']['logo']}}" width="200" height="80" alt="{{ $visit['project']['name'] }}">
            </td>
            <td width="40%"></td>
            <td width="30%" style="text-align: right;">
                <img src="images/atomikal-logo-blanco.png" style="" alt="EfronArq">
            </td>
        </tr>
    <tr>
        <td colspan="3" align="right" style="font-family: Helvetica,serif;font-size: 19px;font-weight: bold;">
            Cotización Nº {{$visit['id']}}
        </td>
    </tr>
    <tr height="50px"></tr>
    </tbody>
</table>

<table width="70%" cellspacing="0" style="color: #696969;">
    <tbody>
    <tr>
        <td style="font-family: Helvetica,serif;font-size: 14px;"><span style="font-weight: bold;">Proyecto:</span> {{$visit['project']['name']}}</td>
        <td style="font-family: Helvetica,serif;font-size: 14px;"><span style="font-weight: bold;">Fecha:</span> {{\Carbon\Carbon::parse($visit['created_at'])->format('d/m/Y')}}</td>
    </tr>
    </tbody>
</table>

<hr>

<table cellspacing="0" width="100%" style="color: #696969;margin-bottom: 10px;">
    <tbody>
    <tr style="font-family: Helvetica,serif;font-size: 14px;">
        <td width="50%" style="font-family: Helvetica,serif;font-size: 14px;"><span style="font-weight: bold;">
                Nombre:</span><br> {{$visit['customer']['first_name']}} {{$visit['customer']['last_name']}}
        </td>
        <td width="50%" style="font-family: Helvetica,serif;font-size: 14px;"><span style="font-weight: bold;">DNI:</span><br> {{$visit['customer']['dni']}}</td>
        <td width="50%" style="font-family: Helvetica,serif;font-size: 14px;"><span style="font-weight: bold;">Teléfono:</span><br> {{$visit['customer']['phone']}}</td>
    </tr>
    <tr>
        <td height="5"></td>
        <td height="5"></td>
        <td height="5"></td>
    </tr>
    <tr style="font-family: Helvetica,serif;font-size: 14px;">
        <td width="50%" style="font-family: Helvetica,serif;font-size: 14px;"><span style="font-weight: bold;">E-mail:</span><br> {{$visit['customer']['email']}}</td>
        @if(!is_null($visit['customer']['secondary_email']))
            <td width="50%" style="font-family: Helvetica,serif;font-size: 14px;"><span style="font-weight: bold;">E-mail Secundario:</span><br> {{$visit['customer']['secondary_email']}}</td>
        @endif
        <td></td>
    </tr>
    </tbody>
</table>

<br>

{{--<h2 style="color: #0c5b8b;font-family: Helvetica,serif;font-size: 14px;">Departamento de Interés:</h2>--}}
<table width="100%" style="color: #696969;border: 1px solid;font-family: Helvetica,serif;text-align: center;" cellspacing="0">
    <thead style="background-color: #0c5b8b;font-size: 12px; color: #FFF">
    <tr>
        <th style="border-bottom: 1px solid;padding: 6px 0;border-right: 1px solid;">INMUEBLE</th>
        <th style="border-bottom: 1px solid;padding: 6px 0;border-right: 1px solid;"># UNIDAD</th>
        <th style="border-bottom: 1px solid;padding: 6px 0;border-right: 1px solid;"># DORM.</th>
        <th style="border-bottom: 1px solid;padding: 6px 0;border-right: 1px solid;">ÁREA LIBRE</th>
        <th style="border-bottom: 1px solid;padding: 6px 0;border-right: 1px solid;">ÁREA <br>TECHADA</th>
        <th style="border-bottom: 1px solid;padding: 6px 0;border-right: 1px solid;">ÁREA TOTAL</th>
        <th style="border-bottom: 1px solid;padding: 6px 0;">PRECIO</th>
    </tr>
    </thead>
    <tbody style="font-size: 14px;">
    @if(!is_null($visit['apartment']))

        @php
            $total_apartment_price = $visit['apartment']['price'];
            $totalApartmentPriceWithDiscount = $visit['apartment']['price'] * (1 - ($discount/100));
            $discountAmount = ($visit['apartment']['price'] * $discount) / 100
        @endphp

        <tr>
            <td style="border-bottom: 1px solid;border-right: 1px solid; text-align:left;padding: 3px 0 3px 20px;"> Departamento</td>
            <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $visit['apartment']['name'] }}</td>
            <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $visit['apartment']['apartment_type']['bedroom'] }}</td>
            <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $visit['apartment']['apartment_type']['free_area'] }}</td>
            <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $visit['apartment']['apartment_type']['roofed_area'] }}</td>
            <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">
                {{ $visit['apartment']['apartment_type']['free_area'] + $visit['apartment']['apartment_type']['roofed_area'] }}
            </td>
            <td style="border-bottom: 1px solid;text-align:right; padding: 3px 20px 3px 0;">
                {{ $visit['project']['currency'] === 'PEN' ? 'S/.' : 'US$.' }} {{ number_format($visit['apartment']['price'] , 2) }}
            </td>
        </tr>
    @endif

    @php
        $total_parking_price = 0;
    @endphp


    @if(!is_null($visit['parking_lots']))

        @foreach($visit['parking_lots'] as $key => $value)

            @php
                $total_parking_price += $value['parking_lot']['price'];
            @endphp

            <tr>
                <td style="border-bottom: 1px solid;border-right: 1px solid; text-align:left;padding: 3px 0 3px 20px;"> Estacionamiento {{ $key + 1 }} </td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $value['parking_lot']['parking_lot'] }}</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">-</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $value['parking_lot']['free_area'] }}</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $value['parking_lot']['roofed_area'] }}</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $value['parking_lot']['free_area'] + $value['parking_lot']['roofed_area'] }}</td>
                <td style="border-bottom: 1px solid;text-align:right; padding: 3px 20px 3px 0;">
                    {{ $visit['project']['currency'] === 'PEN' ? 'S/.' : 'US$.' }} {{ number_format(  $value['parking_lot']['price'], 2) }}
                </td>
            </tr>
        @endforeach

    @endif

    @php
        $total_closet_price = 0
    @endphp

    @if(!is_null($visit['closets']))

        @foreach($visit['closets'] as $key => $value)

            @php
                $total_closet_price += $value['closet']['price']
            @endphp

            <tr>
                <td style="border-bottom: 1px solid;border-right: 1px solid; text-align:left;padding: 3px 0 3px 20px;"> Depósito/Closet {{ $key + 1 }} </td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $value['closet']['closet'] }}</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;"> -</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">0</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $value['closet']['roofed_area'] }}</td>
                <td style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;">{{ $value['closet']['roofed_area'] }}</td>
                <td style="border-bottom: 1px solid;text-align:right; padding: 3px 20px 3px 0;">
                    {{ $visit['project']['currency'] === 'PEN' ? 'S/.' : 'US$.' }} {{ number_format(  $value['closet']['price'] , 2) }}
                </td>
            </tr>
        @endforeach

    @endif

    <tr>
        <td style="border-bottom: 1px solid; text-align:left;padding-left: 20px;"> Subtotal</td>
        <td colspan="5" style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;"></td>
        <td style="border-bottom: 1px solid;text-align:right; padding: 3px 20px 3px 0;">
            {{ $visit['project']['currency'] === 'PEN' ? 'S/.' : 'US$.' }} {{ number_format($total_closet_price + $total_apartment_price + $total_parking_price, 2) }}
        </td>
    </tr>

    @if($discount !== 0)
        <tr>
            <td style="border-bottom: 1px solid #696969;text-align:left; color:#da1a00;padding: 3px 0 3px 20px;" colspan="2"> {{ $discount_name }}</td>
            <td colspan="4" style="border-bottom: 1px solid;padding: 3px 0;border-right: 1px solid;"></td>
            <td style="border-bottom: 1px solid;text-align:right; padding: 3px 20px 3px 0;">
                {{ $visit['project']['currency'] === 'PEN' ? 'S/.' : 'US$.' }} {{ number_format($discountAmount, 2) }}
            </td>
        </tr>
    @endif

    <tr style="font-weight: bold;">
        <td style="text-align:left;padding-left: 20px;"> Total a pagar</td>
        <td colspan="5"></td>
        <td style="text-align:right; padding: 3px 20px 3px 0;">{{ $visit['project']['currency'] === 'PEN' ? 'S/.' : 'US$.' }} {{ number_format($total_closet_price + $totalApartmentPriceWithDiscount + $total_parking_price, 2) }}</td>
    </tr>

    </tbody>
</table>

@if(!is_null($visit['type_financing']))
    <table width="100%" style="color: #696969;font-family: Helvetica,serif;margin-bottom: 10px;">
        <tbody>

        <tr>
            <td>
                <span style="color: #0c5b8b;font-family: Helvetica,serif;font-size: 14px;font-weight: bold;">Forma de pago:</span>
                <span style="font-size: 14px;color: #696969;font-family: Helvetica,serif;">{{ $visit['type_financing'] }}</span>
            </td>
        </tr>

        </tbody>
    </table>
@endif

<table width="100%" style="color: #696969;font-family: Helvetica,serif;margin-bottom: 10px;">
    <tbody>
    <tr>
        <td>
            <span style="color: #0c5b8b;font-family: Helvetica,serif;font-size: 14px;font-weight: bold;">Datos del Sectorista:</span>
        </td>
    </tr>
    <tr>
        <td style="font-size: 14px;"><span style="font-weight: bold;">Banco Financiador:</span> {{ $visit['project']['bank']['description'] }}</td>
    </tr>
    @if(!is_null($visit['project']['bank']['contact_name']))
        <tr>
            <td style="font-size: 14px;"><span style="font-weight: bold;">Nombre:</span> {{ $visit['project']['bank']['contact_name'] }}</td>
        </tr>
    @endif
    @if(!is_null($visit['project']['bank']['contact_phone']))
        <tr>
            <td style="font-size: 14px;"><span style="font-weight: bold;">Teléfono:</span> {{ $visit['project']['bank']['contact_phone'] }}</td>
        </tr>
    @endif
    @if(!is_null($visit['project']['bank']['contact_email']))
        <tr>
            <td style="font-size: 14px;"><span style="font-weight: bold;">Correo:</span> {{ $visit['project']['bank']['contact_email'] }}</td>
        </tr>
    @endif
    </tbody>
</table>

<table style="color: #696969;font-family: Helvetica,serif;margin-bottom: 10px;">
    <tbody>
    <tr>
        <td>
            <span style="color: #0c5b8b;font-family: Helvetica,serif;font-size: 14px;font-weight: bold;">Datos del Asesor:</span>
        </td>
    </tr>
    <tr>
        <td style="font-size: 14px;"><span style="font-weight: bold;">Nombre:</span> {{ auth()->user()->name }}</td>
    </tr>
    <tr>
        <td style="font-size: 14px;"><span style="font-weight: bold;">Teléfono:</span> {{ auth()->user()->phone }}</td>
    </tr>
    <tr>
        <td style="font-size: 14px;"><span style="font-weight: bold;">Correo:</span> {{ auth()->user()->email }}</td>
    </tr>
    </tbody>
</table>

<span style="color: #0c5b8b;font-family: Helvetica,serif;font-size: 14px;font-weight: bold; margin-bottom: 10px;">Legales</span>
<p style="color: #696969;font-family: Helvetica,serif;font-size: 12px;margin: 0 auto;">{{ $visit['project']['legal'] }}</p>

</body>
</html>
