<?php

namespace App\Http\Controllers;
use App\Models\comments;
use Illuminate\Http\Request;
use App\Models\contents;
class HomeController extends Controller
{
    //
    public function index()
    {
        $contents = contents::withCount(['likes as likes_count' => function ($query) {
            $query->where('type', 'like');
        }, 'likes as dislikes_count' => function ($query) {
            $query->where('type', 'dislike');
        }])->get();

        return view('index', compact('contents'));
    }


}
