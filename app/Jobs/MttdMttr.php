<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use App\Jobs\PredictLogLabels;

class MttdMttr implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        try {
            Log::info("Mulai Menghitung MTTR dan MTTD...");

            $process = Process::fromShellCommandline('python ' . base_path('python/mttd_mttr.py'));
            $process->setTimeout(300);
            $process->run(function ($type, $buffer) {
                Log::info("[PYTHON mttd_mttr.py] " . $buffer);
            });

            if (!$process->isSuccessful()) {
                throw new \RuntimeException('❌ predict_rf.py gagal: ' . $process->getErrorOutput());
            }

            Log::info("MTTR dan MTTD selesai dihitung....");


        } catch (\Exception $e) {
            Log::error("Gagal saat menjalankan convert_to_csv.py: " . $e->getMessage());
        }
    }
}
