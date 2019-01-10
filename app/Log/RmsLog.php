<?php
namespace App\Log;

use Carbon\Carbon;
class RmsLog
{
	public static function create($logMessage){
		$today_date       = Carbon::now();
		$date             = date("Y-m-d",strtotime($today_date));
		$message          = $logMessage;
        $fileName         = "custom-laravel-" . $date . '.log';
        $dir              = storage_path('logs');
        $fileNameWithPath = $dir . '/' . $fileName;
        $rawFiles         = scandir($dir);
        $files            = array();
        foreach($rawFiles as $rawFile){
            if (0 === strpos($rawFile, 'custom-laravel-')) {
                array_push($files,$rawFile);
            }
        }

        if(count($files)>0){
        	if(in_array($fileName, $files)){
                // Open the file to get existing content
                $current = file_get_contents($fileNameWithPath);
                // Append a new person to the file
                $current .= $message;
                // Write the contents back to the file
                file_put_contents($fileNameWithPath, $current);

            }
            else{
                //$this::writeFile($fileName,$message);
                $myfile = fopen($fileNameWithPath, "w") or die("Unable to open file!");
                fwrite($myfile, $message);
                fclose($myfile);

            }
        }
        else{
            // $this::writeFile($fileName,$message);
            $myfile = fopen($fileNameWithPath, "w") or die("Unable to open file!");
            fwrite($myfile, $message);
            fclose($myfile);
        }
	}

	public static function deleteLogFileAutomatically(){

        try {

            // $configRepo = new ConfigRepository();
            // $LogMaxFiles = $configRepo->getLogMaxFiles();
        	$LogMaxFiles 			= 60;
            $date = strtotime(date('Y-m-d'));
            $date2 = date('Y-m-d H:i:s');
            $dateCount = '-' . $LogMaxFiles . ' days';
            $logStartDate = date('Y-m-d', strtotime($dateCount, $date));
            $fileName = "custom-laravel-frondend-" . $date . '.log';
            $dir = storage_path('logs');
            $rawFiles = scandir($dir);
            foreach ($rawFiles as $rawFile) {
                if (0 === strpos($rawFile, 'custom-laravel-frondend-')) {
                    echo $rawFile . " == ";
                    $fileNameWithPath = $dir . "/" . $rawFile;
                    $rawTempLogFileDate = substr($rawFile, 24, 10);
                    $rawTempLogFileDate = date("Y-m-d", strtotime($rawTempLogFileDate));
                    if ($rawTempLogFileDate < $logStartDate) {
                        if(!unlink($fileNameWithPath)) {

                            $errorLogfileNameWithPath = $dir . "/" . "custom-error.log";
                            $messageError = "[" . $date2 . "] " . $fileNameWithPath . " can not delete automatically by system !" . PHP_EOL;

                            if (file_exists($errorLogfileNameWithPath)) {
                                // Open the file to get existing content
                                $current = file_get_contents($errorLogfileNameWithPath);
                                // Append a new person to the file
                                $current .= $messageError;
                                // Write the contents back to the file
                                file_put_contents($errorLogfileNameWithPath, $current);
                            } else {
                                //$this::writeFile($fileName,$message);
                                if ($myfile = fopen($errorLogfileNameWithPath, "w")) {
                                    fwrite($myfile, $messageError);
                                    fclose($myfile);
                                } else {

                                }

                            }
                        }
                    }
                }
            }

        }
        catch(\Exception $e){

        }
    }
}