<?php

namespace App\Http\Controllers\V1\Reports;


use App\Http\Controllers\V1\Controller;
use App\Services\Reports\BalancesheetReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    protected $balanceSheetService;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->balanceSheetService = new BalancesheetReportService();
    }

    public function generate(Request $request, string $id)
    {
        $defaultReportDate = new Carbon();

        $balanceDate = $request->input('balance_date', $defaultReportDate->toDateTimeString());
        $generatePDF= $request->input('export_pdf', false);
        $reportEndDate = new Carbon($balanceDate);
        $reportStartDate = $reportEndDate->copy()->subYear();

        $report = $this->balanceSheetService->generate($id, $reportStartDate, $reportEndDate, $generatePDF);

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