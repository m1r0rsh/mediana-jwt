<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

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

    public function createNews(StoreNewsRequest $request)
    {
        $request->validated();

        $title = $request->input('title');

        $news = News::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => auth()->user()->id
        ]);

        return response()->json([
            'message'=> "Added new News the $title",
            'status' => 201,
            'data' => new NewsResource($news)
        ]);
    }

    public function updateNews($id, StoreNewsRequest $request)
    {
        $title = $request->input('title');

        $update = News::find($id);
        $update->update($request->validated());

        return response()->json([
            'message'=> "Change new News the $title",
            'status' => 201,
            'data' => new NewsResource($update)
        ]);
    }

    public function newsId($id)
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

    public function deleteNews($id)
    {
        $news = News::find($id);
dd($news);
        if (!$news) {
            return response()->json([
                'error' => 'Not found',
                'status' => 404
            ]);
        }

        $news->delete();

        return response()->json([
            'message' => "$id id is deleted",
            'data' => new NewsResource($news)
        ]);
    }
}
