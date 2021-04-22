<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ $data['title'] }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .page-break {
            page-break-after: always;
        }

        @page {

        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            color: black;
            text-align: left;
            line-height: 35px;
        }
    </style>
</head>
<body>

<main>
    <div>
        <p style="font-family: Helvetica,serif;font-size: 16px;text-align: center;line-height: 20px;font-weight: 600;margin: 15px 0 0;">Convenio de Separación de Bien Inmueble</p>
        <p style="font-family: Helvetica,serif;font-size: 16px;text-align: center;line-height: 20px;font-weight: 600;margin: 0 0 30px;">Fecha: {{ now()->format('d/m/Y') }}</p>
    </div>

    <div class="content-anexo" style="width: 100%;margin: 28px 0;font-family: Helvetica,serif;font-size: 15px;text-align: justify;line-height: 20px;">
        @php
            $str = '';

            switch($data['buyer']['type']) {
                    case 'Soltero(a)':
                        $str = ucwords(trim($data['buyer']['info'][0]['first_name'])) . ' ' . ucwords(trim($data['buyer']['info'][0]['last_name']));
                        $str .= ' con Documento Nacional de Identidad N° ' . $data['buyer']['info'][0]['dni'];
                    break;

                    case 'Sociedad Conyugal':
                        $str = ucwords(trim($data['buyer']['info'][0]['first_name'])) . ' ' . ucwords(trim($data['buyer']['info'][0]['last_name']));
                        $str .= ' con Documento Nacional de Identidad N° ' . $data['buyer']['info'][0]['dni'];
                        $str .= ' y su cónyuge ' . ucwords(trim($data['buyer']['info'][1]['first_name'])) . ' ' . ucwords(trim($data['buyer']['info'][1]['last_name']));
                        $str .= ' con Documento Nacional de Identidad N° ' . $data['buyer']['info'][1]['dni'];
                    break;

                    case 'Copropietario':
                        $str = ucwords(trim($data['buyer']['info'][0]['first_name'])) . ' ' . ucwords(trim($data['buyer']['info'][0]['last_name']));
                        $str .= ' Con Documento Nacional de Identidad N° ' . $data['buyer']['info'][0]['dni'];
                        $str .= ' y ' . ucwords(trim($data['buyer']['info'][1]['first_name'])) . ' ' . ucwords(trim($data['buyer']['info'][1]['last_name']));
                        $str .= ' con Documento Nacional de Identidad N° ' . $data['buyer']['info'][1]['dni'];
                    break;

                    case 'Empresa':
                        $str = ucwords(trim($data['buyer']['info'][1]['name'])) . ' con RUC N° ' . ucwords(trim($data['buyer']['info'][1]['tax_nro']));
                        $str .= ' representado por ' . ucwords(trim($data['buyer']['info'][0]['first_name'])) . ' ' . ucwords(trim($data['buyer']['info'][0]['last_name']));
                        $str .= ' con número de partida N° ' . $data['buyer']['info'][0]['document_nro'];
                    break;
                }

            $data['agreement'] = str_replace('{PROYECTO}', $data['pull-apart']['visit']['project']['name'], $data['agreement']);
        @endphp

        <p>
            {!! str_replace('{DATOS_COMPRADOR}', $str, $data['agreement']) !!}
        </p>
    </div>

    <div class="page-break"></div>

    <div style="width: 100%;text-align: center;margin: 28px 0;">
        <h1 style="font-size: 15px;font-family: Helvetica,serif;">Anexo I</h1>
        <h2 style="font-size: 13px;font-family: Helvetica,serif;margin-bottom: 0;">PROYECTO {{ $data['pull-apart']['visit']['project']['name'] }}</h2>
        <h3 style="font-size: 13px;font-family: Helvetica,serif; margin-top: 0;">ESPECIFICACIONES GENERALES</h3>
    </div>

    <!-- 1. DATOS DEL COMPRADOR -->
    <!-- Se deben mostrar los elementos dependiendo del tipo de comprador seleccionado en la separación -->
    <div style="display: inline-block; background-color: #d0d0d0;color: #333;width: 99%;margin: 0 auto;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 14px;">
        @if(in_array($data['buyer']['type'], ['Sociedad Conyugal', 'Copropietario', 'Empresa']))
            1. DATOS DEL EL(LA)(LOS) COMPRADOR(A)(ES)
        @else
            1. DATOS DEL COMPRADOR
        @endif
    </div>

    <!-- Si el Tipo de Comprador es Soltero -->
    @if($data['buyer']['type'] === 'Copropietario')
        <div style="margin: 5px">&nbsp;</div>
        <div style="color: #333;width: 100%;margin: 0 auto;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 15px;"><br/>COMPRADOR 1</div>
        <div style="margin: 2px">&nbsp;</div>
    @endif

    @if($data['buyer']['type'] !== 'Empresa')
        <table width="100%" cellspacing="0" style="color: #696969;margin: 30px auto 30px;font-family: Helvetica,serif;font-size: 15px;border: 1px solid;">
            <tbody>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nombres y Apellidos:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">
                    {{ ucwords(trim($data['buyer']['info'][0]['first_name'])) }} {{ ucwords(trim($data['buyer']['info'][0]['last_name'])) }}
                </span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Tipo de documento:</span>
                </td>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ __('DNI') }}</span>
                </td>
                <td style="width: 6%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nro.</span>
                </td>
                <td style="width: 25%;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['dni'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Estado Civil:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['single'] ? 'Soltero' : 'Casado' }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Domicilio:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['address'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Correo Electrónico:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['email'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Teléfonos:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['phone'] }}</span>
                </td>
            </tr>
            </tbody>
        </table>

        @if($data['buyer']['type'] === 'Sociedad Conyugal')
            <div style="margin: 5px">&nbsp;</div>
            <div style="display: inline-block; color: #333;width: 100%;margin: 0 auto 5px;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 15px;">
                DATOS DEL CÓNYUGE/CONVIVIENTE
            </div>
            <div style="margin: 2px">&nbsp;</div>

            <table width="100%" cellspacing="0" style="color: #696969;margin: 10px auto 30px;border: 1px solid;font-family: Helvetica,serif;font-size: 15px;">
                <tbody>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nombres y Apellidos:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">
                    {{ ucwords(trim($data['buyer']['info'][1]['first_name'])) }} {{ ucwords(trim($data['buyer']['info'][1]['last_name'])) }}
                </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Tipo y N° de documento de identidad:</span>
                    </td>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ __('DNI') }}</span>
                    </td>
                    <td style="width: 6%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nro.</span>
                    </td>
                    <td style="width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['dni'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Estado Civil:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['single'] ? 'Soltero' : 'Casado' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Domicilio:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['address'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Correo Electrónico:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['email'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Teléfonos:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['phone'] }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        @endif

        @if($data['buyer']['type'] === 'Copropietario')
            <div style="margin: 5px">&nbsp;</div>
            <div style="color: #333;width: 100%;margin: 0 auto;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 15px;">COMPRADOR 2</div>
            <div style="margin: 2px">&nbsp;</div>

            <table width="100%" cellspacing="0" style="color: #696969;margin: 10px auto 30px;border: 1px solid;font-family: Helvetica,serif;font-size: 15px;">
                <tbody>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nombres y Apellidos:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">
                    {{ ucwords(trim($data['buyer']['info'][1]['first_name'])) }} {{ ucwords(trim($data['buyer']['info'][1]['last_name'])) }}
                </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Tipo y N° de documento de identidad:</span>
                    </td>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{__('DNI') }}</span>
                    </td>
                    <td style="width: 6%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nro.</span>
                    </td>
                    <td style="width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['dni'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Estado Civil:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['single'] ? 'Soltero' : 'Casado' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Domicilio:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['address'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Correo Electrónico:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['email'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Teléfonos:</span>
                    </td>
                    <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['phone'] }}</span>
                    </td>
                </tr>
                </tbody>
            </table>

            <table width="100%" cellspacing="0" style="color: #696969;margin: 15px auto 30px;border: 1px solid;font-family: Helvetica,serif;font-size: 15px;">
                <tbody>
                <tr>
                    <td style="width: 95%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Relación entre COMPRADOR 1 y COMPRADOR 2</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 95%;border-bottom: 0 solid;border-right: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">
                        {{ $data['buyer']['type'] }}
                    </span>
                    </td>
                </tr>
                </tbody>
            </table>

            <table width="100%" cellspacing="0" style="color: #696969;margin: 15px auto 30px;border: 1px solid;font-family: Helvetica,serif;font-size: 15px;">
                <tbody>
                <tr>
                    <td style="width: 20%;border-bottom: 1px solid;border-right:1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;"></span>
                    </td>
                    <td style="width: 20%;border-bottom: 1px solid;border-right: 0 solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">% DE ACCIONES Y DERECHOS QUE ADQUIRIRA DE LOS INMUEBLES (*)</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">COMPRADOR 1</span>
                    </td>
                    <td style="width: 20%;border-bottom: 1px solid;border-right: 0 solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">
                        {{ $data['buyer']['info'][0]['related'][0]['part_one'] }}%
                    </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;border-bottom: 0 solid;border-right: 1px solid;">
                        <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">COMPRADOR 2</span>
                    </td>
                    <td style="width: 20%;border-bottom: 0 solid;border-right: 0 solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">
                        {{ $data['buyer']['info'][0]['related'][0]['part_two'] }}%
                    </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <p style="font-family: Helvetica,serif;color: #696969;">(*) (EL)(LA)(LOS) COMPRADOR(A)(ES) en calidad de copropietarios de los INMUEBLES se obligan a responder solidariamente por las
                obligaciones de dar, hacer o no hacer expresas o derivadas que sean necesarias para el fiel cumplimiento del objeto del presente documento.</p>
    @endif
@endif

@if($data['buyer']['type'] === 'Empresa')
        <!-- Si el Tipo de Comprador es Empresa -->
        <!-- Se deben mostrar los datos de la Empresa + los Datos del Representante Legal de la Empresa-->
        <!-- Datos de la Empresa -->
        <div style="margin: 5px">&nbsp;</div>
        <div style="color: #333;width: 100%;margin: 0 auto;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 15px;">DATOS DE LA EMPRESA</div>
        <div style="margin: 2px">&nbsp;</div>
        <table width="100%" cellspacing="0" style="color: #696969;margin: 10px auto 30px;border: 1px solid;font-family: Helvetica,serif;font-size: 15px;">
            <tbody>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Razón Social:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['name'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Tipo y N° de documento de identidad:</span>
                </td>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ __('RUC') }}</span>
                </td>
                <td style="width: 6%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nro.</span>
                </td>
                <td style="width: 25%;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['tax_nro'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Domicilio:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['address'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Correo Electrónico:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['email'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Teléfonos:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][1]['phone'] }}</span>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Datos del Representante Legal -->
        <div style="color: #333;width: 100%;margin: 0 auto;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 15px;">DATOS DEL REPRESENTANTE LEGAL</div>
            <div style="margin: 5px">&nbsp;</div>
        <table width="100%" cellspacing="0" style="color: #696969;margin: 10px auto 30px;border: 1px solid;font-family: Helvetica,serif;font-size: 15px;">
            <tbody>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Cargo:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['position'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nombres y Apellidos:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">
                    {{ ucwords(trim($data['buyer']['info'][0]['first_name'])) }} {{ ucwords(trim($data['buyer']['info'][0]['last_name'])) }}
                </span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Tipo y N° de documento de identidad:</span>
                </td>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ __('DNI') }}</span>
                </td>
                <td style="width: 6%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Nro.</span>
                </td>
                <td style="width: 25%;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['dni'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Estado Civil:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['single'] ? 'Soltero' : 'Casado' }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Domicilio:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['address'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Correo Electrónico:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['email'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Teléfonos:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['phone'] }}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">N° de Partida:</span>
                </td>
                <td colspan="3" style="font-family: Helvetica,serif;font-size: 15px;">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['buyer']['info'][0]['document_nro'] }}</span>
                </td>
            </tr>
            </tbody>
        </table>
@endif

<!-- 2. INFORMACIÓN GENERAL DEL INMUEBLE MATERIA DE COMPRAVENTA FUTURA -->
    <!-- Se deben mostrar los datos del departamento seleccionado, para los Estacionamientos y Depósitos de deben mostrar las filas según los que se han registrado en la cotización/separación -->
    <div style="display:inline-block;background-color: #d0d0d0;color: #333;width: 99%;margin: 0 auto 10px;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 14px;">
        2. INFORMACIÓN GENERAL DEL INMUEBLE MATERIA DE COMPRAVENTA FUTURA
    </div>

    <table width="100%" cellspacing="0" style="color: #696969;margin: 40px auto 30px;border: 1px solid;border-bottom: 0; font-family: Helvetica,serif;font-size: 15px;">
        <thead>
        <tr>
            <th style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Unidad Inmobiliaria</span>
            </th>
            <th style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">N° Municipal</span>
            </th>
            <th style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">N° interno</span>
            </th>
            <th style="text-align: left;border-bottom: 1px solid;">
                <span style="font-weight: bold;display: inline-block;width: auto; margin: 5px;">Metros Cuadrados</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">Departamento</span>
            </td>
            <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
            <span style="display: inline-block;width: auto;margin: 5px;">
                @foreach($data['pull-apart']['visit']['project']['addresses'] as $key => $value)
                    @if($value['type'] === 'Principal')
                        {{ $value['address'] }}
                    @endif
                @endforeach
            </span>
            </td>
            <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['pull-apart']['visit']['apartment']['name'] }}</span>
            </td>
            <td style="text-align: left;border-bottom: 1px solid;">
            <span style="display: inline-block;width: auto;margin: 5px;">
                {{ $data['pull-apart']['visit']['apartment']['apartment_type']['roofed_area'] + $data['pull-apart']['visit']['apartment']['apartment_type']['free_area'] }} mt
            </span>
            </td>
        </tr>
        @if(!is_null($data['pull-apart']['visit']['parking_lots']))
            @foreach($data['pull-apart']['visit']['parking_lots'] as $key => $value)
                <tr>
                    <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">Estacionamiento {{ $key + 1 }}</span>
                    </td>
                    <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $value['parking_lot']['address']['address'] }}</span>
                    </td>
                    <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $value['parking_lot']['parking_lot'] }}</span>
                    </td>
                    <td style="text-align: left;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">
                        {{ $value['parking_lot']['roofed_area'] +  $value['parking_lot']['free_area'] }} mt
                    </span>
                    </td>
                </tr>
            @endforeach
        @endif
        @if(!is_null($data['pull-apart']['visit']['closets']))
            @foreach($data['pull-apart']['visit']['closets'] as $key => $value)
                <tr>
                    <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">Depósito {{ $key + 1 }}</span>
                    </td>
                    <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">
                        @foreach($data['pull-apart']['visit']['project']['addresses'] as $key => $address)
                            @if($address['type'] === 'Principal')
                                {{ $address['address'] }}
                            @endif
                        @endforeach
                    </span>
                    </td>
                    <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $value['closet']['closet'] }}</span>
                    </td>
                    <td style="text-align: left;border-bottom: 1px solid;">
                    <span style="display: inline-block;width: auto;margin: 5px;">
                        {{ $value['closet']['roofed_area'] }} mt
                    </span>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <!-- 3. PRECIO DEL INMUEBLE MATERIA DE COMPRA VENTA -->
    <!-- Se deben mostrar los datos del departamento seleccionado, para los Estacionamientos y Depositos de deben mostrar las filas según los que se han registrado en la cotización/separación -->
    <div style="display: inline-block; background-color: #d0d0d0;color: #333;width: 99%;margin: 0 auto 10px;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 13px;">
        3. PRECIO DEL INMUEBLE MATERIA DE COMPRA VENTA
    </div>

    <table width="100%" cellspacing="0" style="color: #696969;margin: 40px auto 30px;border: 1px solid;border-bottom: 0;font-family: Helvetica,serif;font-size: 15px;">
        <tbody>
        <tr>
            <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;width: 25%;">
                <span style="display: inline-block;width: auto;margin: 5px;font-weight: bold;">Precio total (US$ incl. IGV):</span>
            </td>
            <td colspan="2" style="text-align: left;border-bottom: 1px solid;">
                <span style=" display: inline-block;width: auto;margin: 5px;">US$ {{ number_format($data['pull-apart']['final_price'], 2) }}</span>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;border-right: 1px solid; width: 25%; border-bottom: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;font-weight: bold;">Detalle del Precio (incl. IGV):</span>
            </td>
            <td style="text-align: left;border-right: 1px solid;width: 25%;border-bottom: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">Departamento</span></td>
            <td style="text-align: left;width: 25%;border-bottom: 1px solid;">
                <span style="display: inline-block;width: auto;margin: 5px;">
                    @php
                        $discount = $data['pull-apart']['visit']['apartment']['price'] * ($data['pull-apart']['discount'] / 100);

                        if($data['pull-apart']['discount_type'] === 1) {
                            $discount = $data['pull-apart']['discount'];
                        }
                    @endphp
                    US$ {{ number_format($data['pull-apart']['visit']['apartment']['price'] - $discount , 2) }}
                </span>
            </td>
        </tr>
        @if(!is_null($data['pull-apart']['visit']['parking_lots']))
            @foreach($data['pull-apart']['visit']['parking_lots'] as $key => $value)
                <tr>
                    <td style="text-align: left;border-right: 1px solid; width: 25%; border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;font-weight: bold;"></span>
                    </td>
                    <td style="text-align: left;border-right: 1px solid;width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">Estacionamiento {{ $key + 1 }}</span></td>
                    <td style="text-align: left;width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">US$ {{ number_format($value['parking_lot']['price'], 2) }}</span>
                    </td>
                </tr>
            @endforeach
        @endif
        @if(!is_null($data['pull-apart']['visit']['closets']))
            @foreach($data['pull-apart']['visit']['closets'] as $key => $value)
                <tr>
                    <td style="text-align: left;border-right: 1px solid; width: 25%; border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;font-weight: bold;"></span>
                    </td>
                    <td style="text-align: left;border-right: 1px solid;width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">Depósito {{ $key + 1 }}</span></td>
                    <td style="text-align: left;width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">US$ {{ number_format($value['closet']['price'], 2) }}</span>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <!-- 4. MONTO DE SEPARACIÓN (S/.) -->
    <div
        style="background-color: #d0d0d0;color: #333;width: 98%;font-family: Helvetica,serif;font-weight: bold;font-size: 14px;height: 18px;margin: 0 auto 30px;padding: 5px 10px 5px 5px;">
        <span style="display:inline-block;width: 50%;">4. MONTO DE SEPARACIÓN (US$)</span>
        <span style="display:inline-block;width: 49%;text-align: right;">
        @foreach($data['pull-apart']['fees'] as $key => $value)
                @if($value['type'] === 'Monto Separación')
                    US$ {{ number_format($value['fee'], 2) }}
                @endif
            @endforeach
    </span>
    </div>

    <!-- 5. FORMA DE PAGO (S/.) -->
    <!-- Se debe mostrar la forma de pago seleccionada en la separación -->
    <div style="display: inline-block; background-color: #d0d0d0;color: #333;width: 99%;margin: 0 auto 10px;font-family: Helvetica,serif;font-weight: bold;padding: 5px;font-size: 14px;">
        5. FORMA DE PAGO (US$)
    </div>

@if($data['pull-apart']['payment_type'])
    <!-- Financiamiento Directo -->
        <table width="100%" cellspacing="0" style="color: #696969;border: 1px solid;margin: 40px auto 30px;font-family: Helvetica,serif;font-size: 15px;">
            <tbody>
            <tr>
                <td style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;width: 25%;">
                    <span style="display: inline-block;width: auto;margin: 5px;font-weight: bold;">Tipo de Financiamiento:</span>
                </td>
                <td style="text-align: left;border-bottom: 1px solid; @if($data['pull-apart']['payment_type'] !== 'Directo') border-right: 1px solid; @endif">
                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['pull-apart']['payment_type'] }}</span>
                </td>
                @if($data['pull-apart']['payment_type'] !== 'Directo')
                    <td style="text-align: left;border-right: 1px solid;width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;font-weight: bold;">Banco:</span>
                    </td>
                    <td style="text-align: left;width: 25%;border-bottom: 1px solid;">
                        <span style="display: inline-block;width: auto;margin: 5px;">{{ $data['pull-apart']['bank']['description'] }}</span>
                    </td>
                @endif
            </tr>
            <tr>
                <td style="width: 25%;border-right: 1px solid;">
                    <span style="font-weight: bold;display: inline-block;width: auto;margin: 5px;">Detalle de Pago:</span>
                </td>
                <td @if($data['pull-apart']['payment_type'] !== 'Directo') colspan="3" @endif>
                    <table width="100%" cellspacing="0" cellpadding="0" style="color: #696969;margin: 0 auto;font-family: Helvetica,serif;font-size: 15px;">
                        <thead>
                        <tr>
                            <th style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;width: 25%;background: #DDD;">
                                <span style="display: inline-block;width: auto;margin: 5px;">Concepto</span>
                            </th>
                            <th style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;width: 25%;background: #DDD;">
                                <span style="display: inline-block;width: auto;margin: 5px;">Monto</span>
                            </th>
                            <th style="text-align: left;border-bottom: 1px solid;border-right: 1px solid;width: 25%;background: #DDD;">
                                <span style="display: inline-block;width: auto;margin: 5px;">Fecha de Pago</span>
                            </th>
                            <th style="text-align: left;border-bottom: 1px solid;width: 25%;background: #DDD;">
                                <span style="display: inline-block;width: auto;margin: 5px;">Hito</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['pull-apart']['fees'] as $key => $value)
                            <tr>
                                <td>
                                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $value['type'] }}</span>
                                </td>
                                <td>
                                    <span style="display: inline-block;width: auto;margin: 5px;">US$ {{ number_format($value['fee'],2) }}</span>
                                </td>
                                <td>
                                    <span style="display: inline-block;width: auto;margin: 5px;">{{ \Carbon\Carbon::parse($value['fee_at'])->format('m/d/Y') }}</span>
                                </td>
                                <td>
                                    <span style="display: inline-block;width: auto;margin: 5px;">{{ $value['milestone'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
@endif

<!-- 6.  FECHA LÍMITE DE FIRMA DE MINUTA -->
    <div
        style="line-height: 1.5; display: inline-block; background-color: #d0d0d0;color: #333;width: 98%;font-family: Helvetica,serif;font-weight: bold;font-size: 14px;height: 18px;margin: 0 auto 30px;padding: 5px 10px 5px 5px;">
        <span style="display:inline-block;width: 50%;">6. FECHA LÍMITE DE FIRMA DE MINUTA</span>
        <span style="display:inline-block;width: 49%;text-align: right;">{{ \Carbon\Carbon::parse($data['pull-apart']['signature_minute_at'])->format('d/m/Y') }}</span>
    </div>
</main>

<footer>
    <span style="display: inline-block;margin: 5px; width: 98%;font-family: Helvetica,serif;font-size: 14px;height: 18px;">
        [Convenio {{ $data['pull-apart']['visit']['project']['name'] }} {{ ucwords(trim($data['buyer']['info'][0]['first_name'])) . ' ' . ucwords(trim($data['buyer']['info'][0]['last_name'])) }}]

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(551, 795, "$PAGE_NUM", $font, 10);
                ');
            }
        </script>
    </span>
</footer>

</body>
</html>
