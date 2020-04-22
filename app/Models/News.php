<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class News extends Model
{
    protected $fillable = [
        'subject',
        'source_id',
        'author',
        'title',
        'url',
        'urlToImage',
        'publishedAt',
        'content',
    ];

    protected $dates = ['publishedAt'];

    public static function storeWithSource($arr){
        $source = Source::firstOrCreate(['from_api_id' => $arr['source']['id'], 'name' => $arr['source']['name']]);

        News::create([
                'source_id' => $source->id,
                'publishedAt' => new Carbon($arr['publishedAt'])
            ] + $arr);
    }

    public function source(){
        return $this->belongsTo(Source::class);
    }
}
