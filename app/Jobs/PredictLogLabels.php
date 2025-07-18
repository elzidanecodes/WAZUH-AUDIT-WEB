<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class PredictLogLabels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        try {
            Log::info("Mulai prediksi...");

            Process::fromShellCommandline('python ' . base_path('python/predict_rf.py'))
                ->setTimeout(300)
                ->mustRun();

            Log::info("Prediksi selesai dan hasil disimpan ke MongoDB.");
            MttdMttr::dispatch();

        } catch (\Exception $e) {
            Log::error("Gagal saat menjalankan mttd_mttr.py: " . $e->getMessage());
        }
    }
}