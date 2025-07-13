<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime; 


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

    public function getAlertStats(Request $request)
    {
        $periode = $request->get('periode', 'last_7_days');

        $today = Carbon::today();
        $startThisWeek = Carbon::now()->subDays(7)->startOfDay();
        $startLastWeek = Carbon::now()->subDays(14)->startOfDay();
        $endLastWeek = $startThisWeek->copy()->subDay()->endOfDay();

        $format = match ($periode) {
            'today', 'yesterday' => '%H:00',
            default => '%Y-%m-%d'
        };

        $startUtc = new UTCDateTime($startThisWeek->getTimestamp() * 1000);

        $pipeline = [
            ['$match' => ['timestamp' => ['$gte' => $startUtc]]],
            ['$group' => [
                '_id' => [
                    '$dateToString' => [
                        'format' => $format,
                        'date' => '$timestamp'
                    ]
                ],
                'count' => ['$sum' => 1]
            ]],
            ['$sort' => ['_id' => 1]]
        ];

        $result = Alert::raw(function ($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        });

        $labels = [];
        $data = [];
        $totalThisWeek = 0;

        // Inisialisasi tanggal 7 hari terakhir
        $dates = [];
        for ($i = 0; $i <= 7; $i++) {
            $date = Carbon::today()->subDays(7 - $i)->format('Y-m-d');
            $dates[$date] = 0;
        }

        // Masukkan hasil agregasi ke array tanggal
        foreach ($result as $entry) {
            $dates[$entry->_id] = $entry->count;
        }

        // Ubah ke array final
        $labels = array_keys($dates);
        $data = array_values($dates);
        $totalThisWeek = array_sum($data);

        $totalLastWeek = Alert::where('timestamp', '>=', $startLastWeek)
                            ->where('timestamp', '<=', $endLastWeek)
                            ->count();

        $percentageChange = 0;
        if ($totalLastWeek > 0) {
            $percentageChange = (($totalThisWeek - $totalLastWeek) / $totalLastWeek) * 100;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'total' => $totalThisWeek,
            'percentageChange' => round($percentageChange, 2)
        ]);
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
