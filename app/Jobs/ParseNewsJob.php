<?php

namespace App\Jobs;

use App\Models\News;
use DB;
use Log;

class ParseNewsJob extends Job
{

    private $subjects = [
        'bitcoin',
        'litecoin',
        'ripple',
        'dash',
        'ethereum',
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $staticQueryArgs = [
            'sortBy' => 'publishedAt',
            'pageSize' => 1,
            'apiKey' => env('NEWSAPI_KEY'),
        ];

        $news = News::select(DB::raw('MIN(publishedAt) as publishedAt'), 'subject')->groupBy('subject')->get();

        foreach($this->subjects as $subject){
            try {
                $item = $news->where('subject', $subject)->first();

                $query = http_build_query(
                    $staticQueryArgs + [
                        'q' => $subject, 'to' => $item ? $item->publishedAt->subSecond()->format('c') : null
                    ]
                );
                $response = json_decode(
                    file_get_contents('https://newsapi.org/v2/everything?' . $query),
                    true
                );

                News::storeWithSource($response['articles'][0] + ['subject' => $subject]);
            } catch(\Exception $ex) {
                Log::error("Error from parse $subject message: " . $ex->getMessage());
            }
        }
    }
}
