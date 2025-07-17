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
use Illuminate\Support\Facades\Log;

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
        // Validasi file yang diupload
        $request->validate([
            'files' => 'required|array|min:2',
            'files.*' => 'file|mimetypes:text/plain|max:10240',
        ]);

        // Menyimpan file di direktori yang sudah ditentukan
        $logPath = storage_path('app/python/data');
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0755, true);  // Membuat direktori jika belum ada
        }

        // Reset isi sebelumnya (opsional)
        File::cleanDirectory($logPath);

        // Mengupload setiap file dan menyimpannya di direktori
        $uploadedFiles = [];
        foreach ($request->file('files') as $uploadedFile) {
            $name = $uploadedFile->getClientOriginalName();
            $lowerName = strtolower($name);
            
            // Menentukan nama file berdasarkan tipe log
            if (Str::contains($lowerName, 'auth')) {
                $uploadedFile->move($logPath, 'auth.log');
                $uploadedFiles[] = 'auth.log';  // Simpan nama file yang diupload
            } elseif (Str::contains($lowerName, 'syslog')) {
                $uploadedFile->move($logPath, 'syslog');
                $uploadedFiles[] = 'syslog';  // Simpan nama file yang diupload
            }
        }

        // Pastikan ada minimal dua file (auth.log dan syslog)
        if (count($uploadedFiles) < 2) {
            return redirect()->back()->with('error', 'Minimal dua file log (auth.log dan syslog) diperlukan.');
        }

        // Langkah 1: Konversi log ke CSV menggunakan convert_to_csv.py
        $logFiles = implode(' ', $uploadedFiles);  // Gabungkan file yang diupload
        $convertCommand = ['python', base_path('python/convert_to_csv.py'), $logFiles];
        $convertProcess = new Process($convertCommand);
        $convertProcess->setTimeout(180);
        $convertProcess->run();  // Menjalankan konversi

        // Memeriksa apakah konversi berhasil
        if ($convertProcess->getExitCode() !== 0) {
            $errorOutput = $convertProcess->getErrorOutput();
            Log::error("CSV conversion failed: " . $errorOutput);
            return redirect()->back()->with('error', 'Gagal mengonversi file log ke CSV.');
        }

        Log::info("File logs berhasil dikonversi menjadi CSV.");

        // Langkah 2: Prediksi menggunakan predict_rf.py
        $csvFilePath = storage_path('app/python/outputs/alerts_for_labeling.csv');  // Path ke file CSV hasil konversi
        $predictCommand = ['python', base_path('python/predict_rf.py'), $csvFilePath];
        $predictProcess = new Process($predictCommand);
        $predictProcess->setTimeout(180);
        $predictProcess->run();  // Menjalankan prediksi

        // Memeriksa apakah prediksi berhasil
        if ($predictProcess->getExitCode() === 0) {
            $output = $predictProcess->getOutput();
            Log::info("Python script executed successfully: " . $output);
        } else {
            $errorOutput = $predictProcess->getErrorOutput();
            Log::error("Python script failed: " . $errorOutput);
            return redirect()->back()->with('error', 'Gagal menjalankan prediksi.');
        }

        return redirect()->route('reports')->with('success', 'File berhasil diproses, dikonversi, dan diprediksi.');
    }
}