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

    protected $video;

    /**
     * Create a new job instance.
     *
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $highBitRate = (new X264('aac'))->setKiloBitrate(2000);
//        $mediumBitRate = (new X264('aac'))->setKiloBitrate(1000);
//        $lowBitRate = (new X264('aac'))->setKiloBitrate(500);


        $video = FFMpeg::open('public/uploads/' . $this->video->video)
            ->exportForHLS()
            ->addFormat($highBitRate)
//            ->addFormat($mediumBitRate)
//            ->addFormat($lowBitRate)
            ->onProgress(function ($progress) {
                $this->video->setProgress($progress);
            })
            ->toDisk('public')
            ->save('/videos/' . explode('.', $this->video->video)[0] . '/' . explode('.', $this->video->video)[0] . '.m3u8');

        unlink(storage_path('app/public/uploads/' . $this->video->video));

        if ($video->ready()) {
            $this->video->setDone('storage/videos/' . explode('.', $this->video->video)[0] . '/' . explode('.', $this->video->video)[0] . '.m3u8', 'online');
        } else {
            $this->video->setDone('storage/videos/' . explode('.', $this->video->video)[0] . '/' . explode('.', $this->video->video)[0] . '.m3u8', 'processed');
        }
    }
}
