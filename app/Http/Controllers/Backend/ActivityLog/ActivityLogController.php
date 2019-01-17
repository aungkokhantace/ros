<?php
namespace App\Http\Controllers\Backend\ActivityLog;

use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function index()
    {
        $direction = storage_path('logs');
        $files   = scandir($direction);
        $logs = [];
        foreach ($files as $file) {
          if (0 === strpos($file, 'custom-laravel-')){
              $logDateRaw = str_replace('custom-laravel-',"",$file);
              $logDate = str_replace('.log',"",$logDateRaw);
              $logfileNameWithPath = $direction . "/" . $file;
              $activities = file($logfileNameWithPath, FILE_IGNORE_NEW_LINES);

              //reverse array (order by time in descending order)
              $activities = array_reverse($activities);;

              $logs[$logDate] = $activities;
          }
        }
        krsort($logs);
        return view('Backend.activity_log.ActivityLog', compact('logs'));
    }
}
