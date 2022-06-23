<?php

namespace App\Console\Commands;


use App\Models\Video;
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
    protected $signature = 'video-upload:process {video}';

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
        $this->video = Video::find(base64_decode($this->argument('video')));

        $highBitRate = (new X264('aac'))->setKiloBitrate(1058);

        $video = FFMpeg::open('public/uploads/' . $this->video->video)
            ->exportForHLS()
            ->addFormat($highBitRate)
            ->onProgress(function ($percentage) {
                $this->video->setProgress($percentage);
            })
            ->toDisk('public')
            ->save('/videos/' . explode('.', $this->video->video)[0] . '/' . explode('.', $this->video->video)[0] . '.m3u8');

        unlink(storage_path('app/public/uploads/' . $this->video->video));

        $this->video->setDone('storage/videos/' . explode('.', $this->video->video)[0] . '/' . explode('.', $this->video->video)[0] . '.m3u8');
    }
}
