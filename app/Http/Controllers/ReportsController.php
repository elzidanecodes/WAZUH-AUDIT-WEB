<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PredictedLog;
use App\Models\Statistics;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Jobs\ConvertLogToCsv;
use MongoDB\BSON\Regex;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $query = PredictedLog::query();

        if ($request->has('search')) {
            $search = str_replace(' ', '_', $request->input('search'));
            $regex = new Regex($search, 'i');

            $query->where(function ($q) use ($regex) {
                $q->where('description', 'regex', $regex)
                ->orWhere('predicted_label', 'regex', $regex);
            });
        }

        $logs = $query->orderBy('timestamp', 'desc')->paginate(10);
        $stat = Statistics::orderBy('_id', 'desc')->first();

        return view('reports.reports', compact('logs', 'stat'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:2',
            'files.*' => 'file|mimetypes:text/plain|max:10240',
        ]);

        $logPath = storage_path('app/python/data');
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0755, true);
        }

        File::cleanDirectory($logPath); // Bersihkan file lama

        foreach ($request->file('files') as $uploadedFile) {
            $name = strtolower($uploadedFile->getClientOriginalName());
            if (Str::contains($name, 'auth')) {
                $uploadedFile->move($logPath, 'auth.log');
            } elseif (Str::contains($name, 'syslog')) {
                $uploadedFile->move($logPath, 'syslog');
            }
        }

        // Kirim ke antrian Laravel Queue
        Log::info("Memanggil job...");
        ConvertLogToCsv::dispatch();

        return redirect()->route('reports')->with('success', 'File berhasil diupload. Sedang diproses di background.');
    }
}