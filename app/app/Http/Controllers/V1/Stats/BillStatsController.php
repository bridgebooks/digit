<?php

namespace App\Http\Controllers\V1\Stats;

use App\Http\Controllers\V1\Controller;
use App\Services\Stats\BillStatsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillStatsController extends Controller
{
    protected $stats;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->stats = new BillStatsService();
    }

    public function generate(Request $request, string $id)
    {
        $defaultStart = new Carbon();
        $start_date = $request->input('start', $defaultStart->toDateTimeString());
        $end_date = $request->input('end', $defaultStart->copy()->subWeek()->toDateTimeString());

        $start = new Carbon($start_date);
        $end = new Carbon($end_date);

        $stats = $this->stats->fetch($id, $start, $end);

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
}