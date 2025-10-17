<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class AdminBackupController extends Controller
{


public function download()
{
    // 1. Backup Database
    $tables = DB::select('SHOW TABLES');
    $databaseName = env('DB_DATABASE');
    $sqlContent = "-- Database Backup: $databaseName\n-- Date: ".now()."\n\n";

    foreach ($tables as $tableObj) {
        $tableName = array_values((array)$tableObj)[0];

        // Table structure
        $createTableStmt = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
        $sqlContent .= "-- ----------------------------\n";
        $sqlContent .= "-- Table structure for `$tableName`\n";
        $sqlContent .= "-- ----------------------------\n";
        $sqlContent .= $createTableStmt . ";\n\n";

        // Table data
        $rows = DB::table($tableName)->get();
        if ($rows->count() > 0) {
            $sqlContent .= "-- ----------------------------\n";
            $sqlContent .= "-- Data for table `$tableName`\n";
            $sqlContent .= "-- ----------------------------\n";
            foreach ($rows as $row) {
                $columns = array_map(fn($col) => "`$col`", array_keys((array)$row));
                $values = array_map(fn($val) => $val === null ? "NULL" : "'".str_replace("'", "''", $val)."'", (array)$row);
                $sqlContent .= "INSERT INTO `$tableName` (".implode(',', $columns).") VALUES (".implode(',', $values).");\n";
            }
            $sqlContent .= "\n";
        }
    }

    // 2. Prepare Zip
    $zipFileName = "full_backup_" . now()->format('Y_m_d_H_i_s') . ".zip";
    $zip = new ZipArchive;
    $zipPath = storage_path($zipFileName);

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Add SQL to zip
        $zip->addFromString('database_backup.sql', $sqlContent);

        // Add storage files (uploads)
        $storagePath = storage_path('app/public'); // adjust if needed
        if (is_dir($storagePath)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($storagePath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = 'storage/' . substr($filePath, strlen($storagePath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        $zip->close();
    } else {
        return back()->with('error', 'Could not create backup zip file.');
    }

    // 3. Download zip
    return response()->download($zipPath)->deleteFileAfterSend(true);
}


}
