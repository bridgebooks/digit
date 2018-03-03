<?php

namespace App\Http\Controllers\V1\Reports;

use Carbon\Carbon;
use App\Http\Controllers\V1\Controller;
use App\Services\Reports\ProfitLostService;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    protected $profitLossReportService;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->profitLossReportService = new ProfitLostService();
    }

    public function generate(Request $request, string $id)
    {
        $defaultStart = new Carbon();
        $defaultEnd = $defaultStart->copy()->subMonth()->startOfMonth();

        $startDate = $request->input('start', $defaultStart->toDateTimeString());
        $endDate = $request->input('end', $defaultEnd->toDateTimeString());

        $reportStartDate = new Carbon($startDate);
        $reportEndDate = new Carbon($endDate);

        $report = $this->profitLossReportService->generate($id, $reportStartDate, $reportEndDate);

        return response()->json([
            'status' => 'success',
            'data' => $report
        ]);
    }
}