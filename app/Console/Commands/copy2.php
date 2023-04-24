<?php

namespace App\Console\Commands;

use Faker\Core\File;
use Illuminate\Console\Command;

class copy2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:copy2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command copy 2304apiLaravel/app/Http/Controllers/HistoryController.php to 2304apiLaravel/app/Http/Controllers/History__ + ( дата время ) + __Controller.php';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sourceFile = app_path('Http/Controllers/HistoryController.php');
        $destinationFile = app_path('Http/Controllers/History__'.date('Y-m-d_H_i_s').'__ControllerCopy.php');

        if (file_exists($destinationFile)) {
            $this->error('The destination file already exists!');
            return;
        }

        if (copy($sourceFile, $destinationFile)) {
            $this->info('The controller has been copied!');
        } else {
            $this->error('The copy operation failed!');
        }
    }
}
