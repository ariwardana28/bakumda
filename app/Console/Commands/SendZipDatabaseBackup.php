<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\BackupZipDatabaseMail;
use ZipArchive;

class SendZipDatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:send-zip-database-backup';
    protected $signature = 'db:backup-zip-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan dump database MySQL, mengompres ke format ZIP, dan mengirimkannya ke email admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses backup database...');

        // Perbaikan mengambil config database
        $dbName = config('database.connections.mysql.database');
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        $timestamp = date('Y-m-d_H-i-s');
        $sqlFileName = "backup-{$dbName}-{$timestamp}.sql";
        $zipFileName = "backup-{$dbName}-{$timestamp}.zip";

        $sqlPath = storage_path("app/{$sqlFileName}");
        $zipPath = storage_path("app/{$zipFileName}");

        // Sesuaikan path mysqldump ini jika Anda testing di lokal (Windows)
        // Contoh menggunakan Laragon / XAMPP:
        $mysqldumpPath = 'mysqldump'; // Ubah ke path lengkap misal: '"C:/laragon/bin/mysql/mysql-8.0.30-winx64/bin/mysqldump.exe"' jika di Windows lokal

        // 1. Jalankan mysqldump
        $command = "{$mysqldumpPath} --user={$dbUser} --password={$dbPass} --host={$dbHost} --port={$dbPort} {$dbName} > \"{$sqlPath}\"";

        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0 || !file_exists($sqlPath)) {
            $this->error('Gagal melakukan mysqldump database. Pastikan path mysqldump sudah benar.');
            return 1;
        }

        // 2. Kompres file .sql menjadi .zip
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($sqlPath, $sqlFileName);
            $zip->close();

            if (file_exists($sqlPath)) {
                unlink($sqlPath);
            }
        } else {
            $this->error('Gagal membuat file ZIP.');
            return 1;
        }

        // 3. Kirim Email beserta lampiran file ZIP
        $adminEmail = 'ariwardana114@gmail.com';

        try {
            $this->info('Mengirim email backup...');
            Mail::to($adminEmail)->send(new BackupZipDatabaseMail($zipPath));
            $this->info("Backup ZIP berhasil dikirim ke {$adminEmail}");
        } catch (\Exception $e) {
            $this->error('Gagal mengirim email: ' . $e->getMessage());
        } finally {
            if (file_exists($zipPath)) {
                unlink($zipPath);
                $this->info('File ZIP sementara di server berhasil dibersihkan.');
            }
        }

        return 0;
    }
}
