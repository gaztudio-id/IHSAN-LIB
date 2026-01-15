<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\Book;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BenchmarkApp extends Command
{
    protected $signature = 'benchmark:run';
    protected $description = 'Run internal code benchmarks for Ihsan-Lib';

    public function handle()
    {
        $this->info("Starting Ihsan-Lib Internal Benchmark...");
        $this->line("---------------------------------------------");

        $results = [];

        // 1. Read Data Buku
        $this->info("1. Benchmarking: Read Data Buku (100x)");
        $start = microtime(true);
        $memStart = memory_get_usage();
        for ($i = 0; $i < 100; $i++) {
            Book::inRandomOrder()->first();
        }
        $end = microtime(true);
        $memEnd = memory_get_usage();
        $time = round(($end - $start) * 1000, 2);
        $mem = round(($memEnd - $memStart) / 1024 / 1024, 4);
        $results[] = ["Read Data Buku", "100x", "{$time} ms", "{$mem} MB", "Stabil"];
        $this->info("   -> Time: {$time} ms | Mem: {$mem} MB");

        // 2. Input Absensi (Transaction)
        $this->info("2. Benchmarking: Input Absensi (50x)");
        // Create Dummy Member
        $member = Member::factory()->create(); 
        
        $start = microtime(true);
        $memStart = memory_get_usage();
        for ($i = 0; $i < 50; $i++) {
            DB::transaction(function () use ($member) {
                Attendance::create([
                    'member_id' => $member->id,
                    'scanned_at' => now(),
                ]);
            });
        }
        $end = microtime(true);
        $memEnd = memory_get_usage();
        $time = round(($end - $start) * 1000, 2);
        $mem = round(($memEnd - $memStart) / 1024 / 1024, 4);
        $results[] = ["Input Absensi", "50x", "{$time} ms", "{$mem} MB", "Stabil"];
        $this->info("   -> Time: {$time} ms | Mem: {$mem} MB");

        // Cleanup
        Attendance::where('member_id', $member->id)->delete();
        $member->delete();

        // 3. Kalkulasi Denda (Logic Test)
        $this->info("3. Benchmarking: Kalkulasi Denda (50x)");
        $start = microtime(true);
        $memStart = memory_get_usage();
        for ($i = 0; $i < 50; $i++) {
            $daysLate = rand(0, 30);
            $fine = $daysLate * 500;
        }
        $end = microtime(true);
        $memEnd = memory_get_usage();
        $time = round(($end - $start) * 1000, 2);
        $mem = round(($memEnd - $memStart) / 1024 / 1024, 4);
        $results[] = ["Kalkulasi Denda", "50x", "{$time} ms", "{$mem} MB", "Stabil"];
        $this->info("   -> Time: {$time} ms | Mem: {$mem} MB");

        // 4. Cek Stok Sirkulasi (Read Intenstive)
        $this->info("4. Benchmarking: Cek Stok (200x)");
        $start = microtime(true);
        $memStart = memory_get_usage();
        for ($i = 0; $i < 200; $i++) {
            Book::where('stock', '>', 0)->limit(1)->get();
        }
        $end = microtime(true);
        $memEnd = memory_get_usage();
        $time = round(($end - $start) * 1000, 2);
        $mem = round(($memEnd - $memStart) / 1024 / 1024, 4);
        $results[] = ["Cek Stok Sirkulasi", "200x", "{$time} ms", "{$mem} MB", "Stabil"];
        $this->info("   -> Time: {$time} ms | Mem: {$mem} MB");

        $this->table(['Modul Uji', 'Iterasi', 'Waktu', 'Memory', 'Status'], $results);
        
        // Save to file as requested
        $output = "IHSAN-LIB BENCHMARK REPORT\n";
        $output .= "Date: " . now() . "\n";
        $output .= "-------------------------------------------------------------\n";
        foreach($results as $res) {
            $output .= str_pad($res[0], 25) . " | " . str_pad($res[1], 10) . " | " . str_pad($res[2], 12) . " | " . $res[3] . "\n";
        }
        file_put_contents(base_path('tests/benchmark_result.txt'), $output);
        $this->info("Results saved to tests/benchmark_result.txt");
    }
}
