<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ImageSyncCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "SyncImage";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync Image from ORACLE to API Server";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Storage::disk('ftp')->files();

        foreach ($files as $file)
        {
            $filename = $file;
            $student = basename(substr($file,3),'.JPG');

            $roll = (int)($student);

            if($roll > 0)
            {
                $image = "student_profile_photo_{$roll}.jpg";

                if(!Storage::disk('image_path')->exists($image))
                {
                    $get_image = Storage::disk('ftp')->get($file);

                    Storage::disk('image_path')->put($image, $get_image);

                    $this->info('Image Saved to API Server '.$image);
                }
            }
        }
    }
}
