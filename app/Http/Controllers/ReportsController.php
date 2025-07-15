<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PredictedLog;
use App\Models\Statistics;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
            'files' => 'required|array|min:2',
            'files.*' => 'file|mimetypes:text/plain'
        ]);

        $logPath = storage_path('app/python/data');
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0755, true);
        }

        // Reset isi sebelumnya (opsional)
        File::cleanDirectory($logPath);

        foreach ($request->file('files') as $uploadedFile) {
            $name = $uploadedFile->getClientOriginalName();

            $lowerName = strtolower($name);
            if (Str::contains($lowerName, 'auth')) {
                $uploadedFile->move($logPath, 'auth.log');
            } elseif (Str::contains($lowerName, 'syslog')) {
                $uploadedFile->move($logPath, 'syslog');
            }
        }
        // Jalankan script konversi ke CSV
        $convert = new Process(['python', base_path('python/convert_to_csv.py')]);
        $convert->setTimeout(180);
        $convert->run();

        if (!$convert->isSuccessful()) {
            throw new ProcessFailedException($convert);
        }

        // Jalankan script prediksi Random Forest
        $predict = new Process(['python', base_path('python/predict_rf.py')]);
        $predict->setTimeout(180);
        $predict->run();

        if (!$predict->isSuccessful()) {
            throw new ProcessFailedException($predict);
        }

        return redirect()->route('reports')->with('success', 'File berhasil diproses dan diprediksi.');
    }
}