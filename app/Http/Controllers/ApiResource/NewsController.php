<?php

namespace App\Http\Controllers\ApiResource;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Tymon\JWTAuth\Facades\JWTFactory;

class NewsController extends Controller
{
    public function listNews()
    {
        $news = News::all();

        if(empty($news)) {
            return response()->json([
                'error' => 'List News empty',
                'status' => 404
            ]);
        }

        return NewsResource::collection($news);
    }


    public function showNews($id)
    {
        $news = News::where('id', $id)->get();
        $checkArray = $news->toArray();

        if(empty($checkArray)) {
            return response()->json([
                'error' => 'Not Found',
                'status' => 404
            ]);
        }

        return NewsResource::collection($news);
    }

    public function privateList()
    {
        $privateListNews = News::select('title','body', 'user_id')
                                ->where('user_id', auth()->user()->id)
                                ->get();

        return response()->json(['data' => $privateListNews]);
    }

    public function myprofile()
    {
        $my = auth()->user();

        return response()->json(['data'=>$my]);
    }
}
