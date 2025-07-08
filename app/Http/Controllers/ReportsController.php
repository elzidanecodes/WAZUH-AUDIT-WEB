<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function index()
    {
        // 🔸 Contoh data dummy
        $data = [
            'jumlah' => [
                'brute_force' => 120,
                'ddos' => 90,
                'normal' => 200,
            ],
            'metric' => [
                'precision' => 0.91,
                'recall' => 0.87,
                'f1_score' => 0.89,
                'mttd' => '2.4s',
                'mttr' => '7.6s'
            ]
        ];

        return view('reports.index', compact('data'));
    }

    public function exportCsv()
    {
        $filename = 'laporan_serangan.csv';
        $headers = ['Content-Type' => 'text/csv'];
        $content = implode(",", ['Serangan', 'Jumlah']) . "\n";
        $content .= "Brute Force,120\nDDoS,90\nNormal,200\n";

        return Response::make($content, 200, array_merge($headers, [
            'Content-Disposition' => "attachment; filename=$filename",
        ]));
    }

}
