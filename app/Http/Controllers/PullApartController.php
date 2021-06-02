<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\ProjectApartment;
use App\Models\ProjectCloset;
use App\Models\ProjectParkingLot;
use App\Models\PullApart;
use App\Models\Visit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class PullApartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('pull-apart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $visit = Visit::find(request('visitId'));

        return view('pull-apart.create')->with('visit', $visit);
    }

    /**
     * Generate agreement for the pull apart
     *
     * @param int $id
     * @return mixed
     */
    public function generate(int $id)
    {

        $pullApart = PullApart::with('fees', 'bank', 'visit', 'visit.project', 'visit.project.addresses', 'visit.apartment',
            'visit.apartment.apartmentType', 'visit.closets', 'visit.closets.closet', 'visit.parkingLots',
            'visit.parkingLots.parkingLot', 'visit.parkingLots.parkingLot.address', 'visit.customer',
            'visit.customer.related', 'visit.exchange')
            ->whereId($id)
            ->first();

        $customer = [];

        if ($pullApart->buyer_type !== 'Empresa') {
            /** @noinspection NullPointerExceptionInspection */
            $customer[] = $pullApart->visit->customer()->with('related')->first()->toArray();

            if (in_array($pullApart->buyer_type, ['Sociedad Conyugal', 'Copropietario'])) {
                $customer[] = Customer::whereId($pullApart->visit->customer->related()->whereCustomerId($pullApart->visit->customer->id)->first()->customer_related_id)->first()->toArray();
            }
        } else {
            $customer[] = $pullApart->visit->customer->toArray();
            $customer[] = Company::whereId($pullApart->visit->customer->company_id)->first()->toArray();
        }

        $agreementFromDb = $pullApart->visit->project->agreementModels;

        if (is_null($agreementFromDb)) {
            $agreementFromDb = $this->getModeloAgreement();
        } else {
            $agreementFromDb = $agreementFromDb->content;
        }

        //$agreementText = $this->getModeloAgreement();
        $agreementText = Str::replace('{AGREEMENT_MODEL}', $this->getModel('model'), $agreementFromDb);

        $data = [
            'data' => [
                'pull-apart' => $pullApart->toArray(),
                'buyer' => [
                    'type' => $pullApart->buyer_type,
                    'partner_type' => $pullApart->visit->customer->related()->count() > 0
                        ? $pullApart->visit->customer->related()->whereCustomerId($pullApart->visit->customer->id)->first()->partner_type
                        : null,
                    'info' => $customer
                ],
                'agreement' => $agreementText,
                'title' => 'separation-' . now()->format('d/m/Y')
            ]
        ];

        $fileName = 'separation-' . $pullApart->visit->id . '-' . now()->format('dmYHis') . '.pdf';

        $pdf = \PDF::loadview('pull-apart.agreement', $data)
            ->save(storage_path('app/public/pull-aparts/' . $fileName));

        $updated = PullApart::findOrFail($pullApart->id);

        $updated->update([
            'agreement' => 'pull-aparts/' . $fileName
        ]);

        ProjectApartment::findOrFail($updated->visit->project_apartment_id)->update([
            'availability' => 'Separado'
        ]);

        foreach ($updated->visit->parkingLots as $parkingLot) {
            ProjectParkingLot::findOrFail($parkingLot->project_parking_lot_id)->update([
                'availability' => 'Separado'
            ]);
        }

        foreach ($updated->visit->closets as $closet) {
            ProjectCloset::findOrFail($closet->project_closet_id)->update([
                'availability' => 'Separado'
            ]);
        }

        return $pdf->stream($fileName);
    }

    /**
     * Agreement Model
     *
     * @return string
     */
    public function getModeloAgreement(): string
    {
        return <<<HTML
<p>Conste por el presente documento, el Convenio de Separaci&oacute;n de Bien Inmueble, que celebran&nbsp;&nbsp; &nbsp;de una parte como &nbsp;<strong>LA VENDEDORA &nbsp;INVERSIONES &nbsp;RIVER &nbsp;GROUP &nbsp;SAC</strong> con RUC N&deg; 20601794820 y domicilio en &nbsp;Av. Mariscal &nbsp;Jos&eacute; de la &nbsp;Mar N&ordm; 1120 Of. 202, Urbanizaci&oacute;n &nbsp;Santa Cruz, &nbsp;Distrito de Miraflores, Provincia y Departamento de Lima, representada por su Gerente General don Mat&iacute;as Efron, identificado con Documento Nacional de Identidad N&ordm;47375053, &nbsp;debidamente facultado seg&uacute;n &nbsp;poderes inscritos en la Partida N&deg;13721847 &nbsp;del Registro de Personas Jur&iacute;dicas de Lima y de la otra parte <strong>EL (LA)(LOS) COMPRADOR(A)(ES) {DATOS_COMPRADOR}</strong>&nbsp;plenamente identificados en el numeral 1 de las Especificaciones Generales (Anexo I), bajo los t&eacute;rminos y condiciones siguientes:</p>

<p><strong>PRIMERA.-</strong> <strong>LA VENDEDORA</strong> es propietaria de un terreno de 1005.00 m2 producto de la acumulaci&oacute;n de 2 lotes, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; con frente al Jir&oacute;n Faustino S&aacute;nchez Carri&oacute;n N&deg;154 y N&deg;160-164,&nbsp; los mismos que fueron acumulados en la Partida Registral N&deg; 13939934.</p>

<p>Sobre dicho <strong>TERRENO</strong>, <strong>LA VENDEDORA</strong> se encuentra construyendo un proyecto inmobiliario denominado &ldquo;{PROYECTO}&rdquo;. El proyecto comprende la construcci&oacute;n de un edificio de 14 niveles de altura m&aacute;s azotea, con 97 departamentos de vivienda (88 tipo Flat y 9 tipo D&uacute;plex). Adem&aacute;s contar&aacute; con 5 estacionamientos dobles, 92 estacionamientos simples, 15 dep&oacute;sitos y 9 closets.</p>

<p>&ldquo;{PROYECTO}&rdquo;, se desarrollar&aacute; de acuerdo a los planos y cuadros de acabados que <strong>EL(LA)(LOS) COMPRADOR(A)(ES)</strong>&nbsp; declara(n) conocer y que formaran parte de la minuta.</p>

<p>El &aacute;rea, linderos y medidas perim&eacute;tricas definitivas de los Departamentos, Estacionamientos Simples/Dobles y Dep&oacute;sitos, as&iacute; como la participaci&oacute;n de los mismos en las &aacute;reas comunes se determinar&aacute;n en la Declaratoria de F&aacute;brica, Independizaci&oacute;n y Reglamento Interno que en su oportunidad otorgar&aacute; <strong>LA VENDEDORA</strong>, debiendo cumplir &eacute;sta con la inscripci&oacute;n en el Registro de Predios de Lima.</p>

<p><strong>EL (LA)(LOS) COMPRADOR(A)(ES</strong>) declaran conocer que el terreno se encuentra hipotecado a favor del Scotiabank y &nbsp;por ello, reconocen todos y cada uno de los derechos que de esa hipoteca emanaran a favor de dicho banco.</p>

<p><strong>SEGUNDA.-</strong> <strong>EL (LA)(LOS) COMPRADOR(A)(ES</strong>) han mostrado inter&eacute;s en adquirir las unidades inmobiliarias, en adelante los <strong>INMUEBLES, </strong>que se indican en el numeral 2 del Anexo I y que se ubican en el Proyecto Inmobiliario indicado en la cl&aacute;usula que antecede. El precio libremente pactado por la transferencia en propiedad de los referidos <strong>INMUEBLES</strong> es el consignado en el numeral 3 del Anexo I y ser&aacute;n pagados en la forma que se indique en el numeral 5 del anexo I.</p>

<p><strong>TERCERA.-</strong> Con la finalidad de separar los <strong>INMUEBLES</strong>,&nbsp; <strong>EL (LA)(LOS) COMPRADOR(A)(ES</strong>) se compromete(n), en un plazo no mayor de dos (02) d&iacute;as &uacute;tiles a partir de la fecha de este documento, a cancelar mediante dep&oacute;sito en la cuenta corriente MN N&ordm; 000- 4309260 que <strong>LA VENDEDORA</strong> mantiene&nbsp; en el Scotiabank la suma consignada en el numeral 4 del Anexo I. Dicho importe as&iacute; como otros abonos que pudiese hacer <strong>EL(LA)(LOS)COMPRADOR(A)(ES)</strong>&nbsp; en calidad de separaci&oacute;n, no generar&aacute; intereses. De concretarse la compra-venta se imputar&aacute;n al pago de la cuota inicial.</p>

<p><strong>CUARTA</strong>.-&nbsp; {AGREEMENT_MODEL}</p>

<p><strong>QUINTA.-&nbsp; </strong>Las partes declaran que sus domicilios son los que figuran en la introducci&oacute;n del presente Contrato y que ninguna variaci&oacute;n en los mismos surtir&aacute; efectos si no es comunicada notarialmente a la contraparte dentro de los cinco (05) d&iacute;as de producido el cambio, debiendo quedar ubicado el nuevo domicilio necesariamente en la ciudad de Lima.</p>

<p>Los otorgantes renuncian al fuero de sus domicilios y se someten a la Jurisdicci&oacute;n y Competencia de los Jueces y Tribunales del Distrito Judicial del Cercado de Lima.</p>

<p><em>Las partes declaran que lo manifestado en las cl&aacute;usulas que anteceden es el fiel reflejo de su libre voluntad, renunciando a cualquier acci&oacute;n que por cualquier concepto les pudiera corresponder para invalidar el m&eacute;rito y efectos de este documento, en fe de lo cual firman al pie.</em></p>

<p>&nbsp;</p>

<p>&nbsp;___________________________&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; _____________________________</p>

<p><strong>INVERSIONES RIVER GROUP SAC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EL(LA)(LOS)COMPRADOR(A)(ES)</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

HTML;

    }

    public function getModel($model): string
    {
        if ($model === 'Modelo A') {
            return "De no suscribirse la minuta hasta la fecha indicada en el numeral 6 del Anexo I, el presente Convenio quedar&aacute; sin efecto, quedando en beneficio de <strong>LA VENDEDORA</strong> el importe total que <strong>EL(LA)(LOS)COMPRADOR(A)(ES)</strong> hayan abonado a la fecha, por concepto de gastos administrativos";
        }

        return "En caso que <strong>EL(LA)(LOS)COMPRADOR(A)(ES)</strong> hubiese(n) solicitado un cr&eacute;dito bancario para la cancelaci&oacute;n del saldo de precio y, habiendo presentado toda la documentaci&oacute;n requerida por el banco para tal efecto, su solicitud fuera rechazada, <strong>LA VENDEDORA</strong> reintegrar&aacute;, en un plazo m&aacute;ximo de 5 d&iacute;as h&aacute;biles, el &iacute;ntegro del monto recibido hasta ese momento menos S/300 (Trescientos con 00/100 soles) por concepto de gastos administrativos y dejando sin efecto este convenio. El rechazo del cr&eacute;dito quedara en evidencia cuando se reciba una comunicaci&oacute;n escrita o correo electr&oacute;nico de la entidad bancaria respectiva indicando lo anterior como m&aacute;ximo hasta la fecha de firma de la presente minuta.</p><p>En cualquier otro caso o de no suscribirse la minuta hasta la fecha indicada en el numeral 6 del Anexo I, el presente Convenio quedar&aacute; sin efecto, quedando en beneficio de <strong>LA VENDEDORA</strong> el importe total que <strong>EL(LA)(LOS)COMPRADOR(A)(ES)</strong> hayan abonado a la fecha, por concepto de gastos administrativos.";
    }
}
