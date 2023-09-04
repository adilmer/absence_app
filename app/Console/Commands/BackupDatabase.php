<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'db:backup';
    protected $description = 'Backup the database to the specified location';



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // اسم ملف النسخة الاحتياطية
        $backupFileName = 'backup-' . date('Y-m-d_H-i-s') . '.sql';

        // مسار النسخة الاحتياطية على قرص D
        $backupPath = 'D:/app-backup/' . $backupFileName;

        // مسار mysqldump
        $mysqldumpPath = 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump.exe'; // قد يكون المسار مختلفًا على نظام التشغيل الخاص بك
       // $mysqldumpPath = 'D:/app-backup/mysqldump'; // قد يكون المسار مختلفًا على نظام التشغيل الخاص بك

        // معلومات قاعدة البيانات من ملف .env
        $databaseHost = env('DB_HOST');
        $databaseName = env('DB_DATABASE');
        $databaseUsername = env('DB_USERNAME');
        $databasePassword = env('DB_PASSWORD');

        // بناء الأمر لنسخ قاعدة البيانات
        $command = "{$mysqldumpPath} -h {$databaseHost} -u {$databaseUsername} -p{$databasePassword} {$databaseName} > {$backupPath}";

        // تنفيذ الأمر
        exec($command);

        // تحميل ملف النسخة الاحتياطية إلى التخزين السحابي إذا كنت بحاجة لذلك
        Storage::disk('local')->put($backupFileName, file_get_contents($backupPath));

        // حذف الملف المؤقت من قرص D
        unlink($backupPath);

        $this->info('Database backup completed successfully.');
        return 0;
    }
}
