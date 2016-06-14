<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sale;
use App\Budget;
use App\DeskDetail;

use Illuminate\Http\Request;

class PdfController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function sale($id)
	{
		$sale = Sale::find($id);
		$view =  \View::make('pdf.venta',compact('sale'))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('inicio');
	}

	public function budget($id)
	{
		$budget = Budget::find($id);
		$view =  \View::make('pdf.budget',compact('budget'))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('inicio');
	}

	public function saleDesk($id)
	{
		$deskDetail = DeskDetail::find($id);

		$sale = $deskDetail->Sale;
		$view =  \View::make('pdf.venta_caja',compact('sale','deskDetail'))->render();

    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);

    return $pdf->stream('inicio');
	}

}
