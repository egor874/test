<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function getIndex(Request $request) {
        $this->validate($request, [
            'groups' => 'array',
            'groups.*' => 'in:source_id,publishedAt,subject'
        ]);

        $query = News::with('source');

        if($request->has('groups')){
            foreach($request->get('groups') as $val){
                $query->groupBy($val);
            }
        }

        return $query->paginate();
    }
}
