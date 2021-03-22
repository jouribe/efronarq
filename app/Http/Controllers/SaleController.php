<?php

namespace App\Http\Controllers;

use App\Models\PullApart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|Application
     */
    public function index()
    {
        return view('sales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View|Application
     */
    public function create()
    {
        $pullApart = PullApart::find(request('pullApartId'));

        return view('sales.create')->with('pullApart', $pullApart);
    }

    /**
     * Generate sale bill
     * @return BinaryFileResponse
     */
    public function bill(): BinaryFileResponse
    {
        $phpWord = new PhpWord();

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();

        // Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
        );

        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */

        // Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
            array('name' => 'Tahoma', 'size' => 10)
        );

        // Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );

        $section->addText(
            '"The greatest accomplishment is not in never falling, '
            . 'but in rising again after you fall." '
            . '(Vince Lombardi)',
            $fontStyleName
        );

        // Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);

        try {
            $objWriter = IOFactory::createWriter($phpWord);
            $objWriter->save('helloWorld.docx');
            return response()->download(public_path('helloWorld.docx'));
        } catch (Exception $e) {
            ray($e);
        }
    }
}
