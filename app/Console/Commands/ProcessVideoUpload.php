<?php

namespace App\Console\Commands;


use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;


class ProcessVideoUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video-upload:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $lowFormat = (new X264('aac'))->setKiloBitrate(500);
        $highFormat = (new X264('aac'))->setKiloBitrate(1000);

        $this->info('Starting video processing...');

        FFMpeg::fromDisk('public')
            ->open('uploads/videoTest.mp4')
            ->exportForHLS()
            ->addFormat($lowFormat, function (HLSVideoFilters $filters) {
                $filters->resize(1280, 720);
            })
            ->addFormat($highFormat, function (HLSVideoFilters $filters) {
                $filters->resize(1920, 1080);
            })
            ->toDisk('public')
            ->save('videos/videoTest.m3u8');

        $this->info('Video processing finished.');
    }
}
