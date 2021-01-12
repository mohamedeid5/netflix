<?php

namespace App\Jobs;

use App\Movie;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class StreamMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $movie;

    /**
     * Create a new job instance.
     *
     * @param Movie $movie
     */
    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lowBitrate = (new X264('aac'))->setKiloBitrate(100);
        $midBitrate = (new X264('aac'))->setKiloBitrate(200);
        $highBitrate = (new X264('aac'))->setKiloBitrate(500);

        FFMpeg::fromDisk('local')
            ->open($this->movie->path)
            ->exportForHLS()
            ->onProgress(function ($percent){
                $this->movie->update([
                    'percent' => $percent
                ]);
            })
            ->setSegmentLength(10) // optional
            ->setKeyFrameInterval(48) // optional
            ->addFormat($lowBitrate)
            ->addFormat($midBitrate)
            ->addFormat($highBitrate)
            ->save("public/movies/{$this->movie->id}/{$this->movie->id}.m3u8");
    }
}
