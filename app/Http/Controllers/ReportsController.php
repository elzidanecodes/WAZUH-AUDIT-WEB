<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PredictedLog;
use App\Models\Statistics;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ReportsController extends Controller
{
    public function index()
    {
        $logs = PredictedLog::orderBy('timestamp', 'desc')->paginate(10);
        $stat = Statistics::orderBy('_id', 'desc')->first();

        return view('reports.reports', compact('logs', 'stat'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        // Simpan file CSV ke folder Python input
        $filename = 'uploaded.csv';
        $destinationPath = storage_path('app/python/inputs');
        $request->file('file')->move($destinationPath, $filename);

        // Jalankan Python script prediksi dan mttd_mttr
        $process = new Process(['python', base_path('python/predict_rf.py')]);
        $process->setTimeout(180); // 3 menit
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return redirect()->route('reports')->with('success', 'Data berhasil diprediksi dan MTTD/MTTR dihitung.');
    }
}