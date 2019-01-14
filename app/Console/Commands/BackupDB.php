<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;
use App\RMS\Config\Config;

class BackupDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database every two hours';

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
     * @return mixed
     */
    public function handle()
    {
      $current_timestamp     = date('Y-m-d-H-i-s');

      $config = Config::first();

      $process = new Process('mysqldump -u root '.$config->db_name.' >'.$config->backup_url.$current_timestamp.'.sql');
     
  		$process->run();
  		if (!$process->isSuccessful()) {
  		    throw new ProcessFailedException($process);
  		}
    	echo $process->getOutput();
    }
}
