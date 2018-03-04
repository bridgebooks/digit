<?php

namespace App\Http\Controllers\V1\Reports;

use Carbon\Carbon;
use App\Http\Controllers\V1\Controller;
use App\Services\Reports\ProfitLostReportService;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    protected $profitLossReportService;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->profitLossReportService = new ProfitLostReportService();
    }

    public function generate(Request $request, string $id)
    {
        $defaultStart = new Carbon();
        $defaultEnd = $defaultStart->copy()->subMonth()->startOfMonth();

        $startDate = $request->input('start_date', $defaultStart->toDateTimeString());
        $endDate = $request->input('end_date', $defaultEnd->toDateTimeString());
        $generatePDF= $request->input('export_pdf', false);

        $reportStartDate = new Carbon($startDate);
        $reportEndDate = new Carbon($endDate);

        $report = $this->profitLossReportService->generate($id, $reportStartDate, $reportEndDate, $generatePDF);

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