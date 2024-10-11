<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RepairsImport;

class ImportRepairMonitorData extends Command
{
    protected $signature = 'import:csv {file} {table}';
    protected $description = 'Import a CSV file into the database';

    public function handle()
    {
        ini_set('memory_limit', '2048M');
        $file = $this->argument('file');
        $table = $this->argument('table');

        if (!file_exists($file)) {
            $this->error("File {$file} does not exist!!");
            return;
        }
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

        if ($fileExtension !== 'xls' && $fileExtension !== 'xlsx') {
            $this->error("File {$file} is not an Excel file!!");
            return;
        }
        $importer = new RepairsImport($table);
        DB::statement('PRAGMA foreign_keys = OFF');
        Model::unguard();

        DB::transaction(function () use ($importer, $file) {
            Excel::import($importer, $file);
        });
        DB::statement('PRAGMA foreign_keys = ON');
        Model::reguard();
    }
}
