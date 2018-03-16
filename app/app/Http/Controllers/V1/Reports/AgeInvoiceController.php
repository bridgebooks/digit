<?php

namespace App\Http\Controllers\V1\Reports;


use App\Http\Controllers\V1\Controller;
use App\Services\Reports\AgedInvoiceReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgeInvoiceController extends Controller
{
    protected $agedInvoiceReportService;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->agedInvoiceReportService = new AgedInvoiceReportService();
    }

    public function generate(Request $request, string $id)
    {
        $defaultReportDate = new Carbon();
        $type = $request->input('type', 'acc_rec');
        $date = $request->input('date', $defaultReportDate->toDateTimeString());
        $generatePDF= $request->input('export_pdf', false);

        $reportDate = new Carbon($date);

        $report = $this->agedInvoiceReportService->generate($id, $type, $reportDate, $generatePDF);

        if (!$generatePDF) {
            return response()->json([
                'status' => 'success',
                'data' => $report
            ]);
        } else {
            return $report;
        }
    }
}