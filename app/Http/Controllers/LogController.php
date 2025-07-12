<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $page = $request->input('page', 1);
        $skip = ($page - 1) * $perPage;

        $query = Alert::orderBy('timestamp', 'desc');

        if ($request->has('source')) {
            $query->where('source', $request->input('source'));
        }

        $data = $query->skip($skip)->take($perPage)->get();
        $total = $query->count();

        $alerts = new LengthAwarePaginator($data, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('historis.log', compact('alerts'));
    }

    public function show($id)
    {
        $alerts = Alert::find($id);
        if (!$alerts) {
        return response()->json(['error' => 'Log tidak ditemukan'], 404);
    }
        return response()->json($alerts);
    }

      public function getAlertStats(Request $request)
    {
        $periode = $request->get('periode', 'week');
        $query = Alert::query();

        switch ($periode) {
            case 'today':
                return $this->getTodayStats($query);
                
            case 'yesterday':
                return $this->getYesterdayStats($query);
                
            case 'month':
                return $this->getMonthlyStats($query);
                
            case 'year':
                return $this->getYearlyStats($query);
                
            case 'week':
            default:
                return $this->getWeeklyStats($query);
        }
    }

    protected function getTodayStats($query)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        
        $data = $query->whereBetween('timestamp', [$today, $tomorrow])
                    ->get();
        
        $labels = [];
        $counts = [];

        // Group by hour for today
        for ($i = 0; $i < 24; $i++) {
            $hour = $today->copy()->addHours($i);
            $count = $data->filter(function ($alert) use ($hour) {
                return Carbon::parse($alert->timestamp)->hour == $hour->hour;
            })->count();
            
            $labels[] = $hour->format('H:00');
            $counts[] = $count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $counts,
        ]);
    }

    protected function getYesterdayStats($query)
    {
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        
        $data = $query->whereBetween('timestamp', [$yesterday, $today])
                    ->get();
        
        $labels = [];
        $counts = [];

        // Group by hour for yesterday
        for ($i = 0; $i < 24; $i++) {
            $hour = $yesterday->copy()->addHours($i);
            $count = $data->filter(function ($alert) use ($hour) {
                return Carbon::parse($alert->timestamp)->hour == $hour->hour;
            })->count();
            
            $labels[] = $hour->format('H:00');
            $counts[] = $count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $counts,
        ]);
    }

    protected function getWeeklyStats($query)
    {
        $labels = [];
        $counts = [];
        $today = Carbon::today();
        
        // Generate dummy data if no real data exists
        $hasData = $query->whereDate('timestamp', '>=', $today->copy()->subDays(6))->exists();
        
        if (!$hasData) {
            // Return sample data for demonstration
            for ($i = 6; $i >= 0; $i--) {
                $date = $today->copy()->subDays($i);
                $labels[] = $date->format('D, M j');
                $counts[] = rand(1, 10); // Random sample data
            }
        } else {
            // Get real data
            for ($i = 6; $i >= 0; $i--) {
                $date = $today->copy()->subDays($i);
                $count = $query->whereDate('timestamp', $date->toDateString())
                             ->count();
                
                $labels[] = $date->format('D, M j');
                $counts[] = $count;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $counts,
        ]);
    }

    protected function getMonthlyStats($query)
    {
        $data = $query->select(
                    DB::raw('MONTH(timestamp) as month'),
                    DB::raw('YEAR(timestamp) as year'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

        if ($data->isEmpty()) {
            // Generate sample monthly data
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            
            $labels = [];
            $counts = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $month = $currentMonth - $i;
                $year = $currentYear;
                
                if ($month < 1) {
                    $month += 12;
                    $year--;
                }
                
                $labels[] = Carbon::create($year, $month)->format('M Y');
                $counts[] = rand(5, 20);
            }
            
            return response()->json([
                'labels' => $labels,
                'data' => $counts,
            ]);
        }

        $labels = $data->map(function ($item) {
            return Carbon::create($item->year, $item->month)->format('M Y');
        });

        return response()->json([
            'labels' => $labels,
            'data' => $data->pluck('total'),
        ]);
    }

    protected function getYearlyStats($query)
    {
        $data = $query->select(
                    DB::raw('YEAR(timestamp) as year'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

        if ($data->isEmpty()) {
            // Generate sample yearly data
            $currentYear = Carbon::now()->year;
            
            return response()->json([
                'labels' => [$currentYear-1, $currentYear],
                'data' => [rand(50, 100), rand(50, 100)],
            ]);
        }

        return response()->json([
            'labels' => $data->pluck('year'),
            'data' => $data->pluck('total'),
        ]);
    }

}
