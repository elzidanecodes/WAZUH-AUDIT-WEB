<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Carbon\Carbon;


class DashboardController extends Controller
{
    
    public function index()
    {
        // Total log saat ini
        $alertCount = Alert::count();

        // Jumlah log minggu lalu (7–14 hari lalu)
        $alertCountLastWeek = Alert::whereBetween('timestamp', [
            Carbon::now()->subDays(14),
            Carbon::now()->subDays(7)
        ])->count();

        // Hitung persentase kenaikan/penurunan
        $percentageChange = $alertCountLastWeek > 0
            ? (($alertCount - $alertCountLastWeek) / $alertCountLastWeek) * 100
            : 0;

        // Format output count
        $alertCountFormatted = $this->formatLargeNumber($alertCount);

        return view('dashboard.dashboard', compact(
            'alertCountFormatted',
            'percentageChange'
        ));
    }

    private function formatLargeNumber($num)
    {
        if ($num >= 1000000000) {
            return number_format($num / 1000000000, 2) . 'B';
        } elseif ($num >= 1000000) {
            return number_format($num / 1000000, 2) . 'M';
        } elseif ($num >= 1000) {
            return number_format($num / 1000, 2) . 'k';
        }
        return number_format($num);
    }
}
