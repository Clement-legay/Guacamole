<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;

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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    }
}
