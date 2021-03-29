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

    public function destroy($id)
    {
        PullApart::findOrFail($id)->update(['is_sale' => 0]);

        return view('sales.index');
    }
}
