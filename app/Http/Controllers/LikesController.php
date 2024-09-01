<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\comments;
use App\Models\contents;
use App\Models\likes;
use Illuminate\Http\Request;
class LikesController extends Controller
{
    //
     // عرض جميع الإعجابات
     public function index()
     {
         $likes = Likes::all();
         return view('likes.index', compact('likes'));
     }

     // عرض الإعجاب حسب المعرف
     public function show($id)
     {
         $like = Likes::find($id);

         if (!$like) {
             return redirect()->route('likes.index')->with('error', 'Like not found');
         }

         return view('likes.show', compact('like'));
     }

     // إضافة إعجاب جديد
     public function store(Request $request)
     {
         $request->validate([
             'comment_id' => 'required|exists:comments,id',
             'user_id' => 'required|exists:users,id',
             'type' => 'required|string',
             'content_id' => 'required|exists:contents,id',
         ]);

         Likes::create([
             'comment_id' => $request->input('comment_id'),
             'user_id' => $request->input('user_id'),
             'type' => $request->input('type'),
         ]);

         return redirect()->route('content.show', ['id' => $request->input('content_id')]);
     }

     // تحديث إعجاب موجود
     public function update(Request $request, $id)
     {
         $request->validate([
             'comment_id' => 'sometimes|required|exists:comments,id',
             'user_id' => 'sometimes|required|exists:users,id',
             'type' => 'sometimes|required|string',
         ]);

         $like = Likes::find($id);

         if (!$like) {
             return redirect()->route('likes.index')->with('error', 'Like not found');
         }

         $like->update($request->all());

         return redirect()->route('likes.index')->with('success', 'Like updated successfully');
     }

     // حذف إعجاب
     public function destroy($id)
     {
         $like = Likes::find($id);

         if (!$like) {
             return redirect()->route('likes.index')->with('error', 'Like not found');
         }

         $like->delete();

         return redirect()->route('likes.index')->with('success', 'Like deleted successfully');
     }

     // الإعجاب وعدم الإعجاب
     public function toggleLike(Request $request, $commentId)
     {
         $userId = Auth::id();
         $contentId = $request->input('content_id');

         // التحقق من وجود إعجاب أو عدم إعجاب موجود
         $existingLike = Likes::where('comment_id', $commentId)
                               ->where('user_id', $userId)
                               ->where('type', 'like')
                               ->first();

         if ($existingLike) {
             // إزالة الإعجاب إذا كان موجودا
             $existingLike->delete();
         } else {
             // إزالة عدم الإعجاب إذا كان موجودا
             Likes::where('comment_id', $commentId)
                  ->where('user_id', $userId)
                  ->where('type', 'dislike')
                  ->delete();

             // إضافة الإعجاب
             Likes::updateOrCreate(
                 ['comment_id' => $commentId, 'user_id' => $userId],
                 ['type' => 'like']
             );
         }

         return redirect()->route('content.show', ['id' => $contentId])->with('message', 'Like toggled');
     }

     public function toggleDislike(Request $request, $commentId)
     {
         $userId = Auth::id();
         $contentId = $request->input('content_id');

         // التحقق من وجود عدم إعجاب موجود
         $existingDislike = Likes::where('comment_id', $commentId)
                                 ->where('user_id', $userId)
                                 ->where('type', 'dislike')
                                 ->first();

         if ($existingDislike) {
             // إزالة عدم الإعجاب إذا كان موجودا
             $existingDislike->delete();
         } else {
             // إزالة الإعجاب إذا كان موجودا
             Likes::where('comment_id', $commentId)
                  ->where('user_id', $userId)
                  ->where('type', 'like')
                  ->delete();

             // إضافة عدم الإعجاب
             Likes::updateOrCreate(
                 ['comment_id' => $commentId, 'user_id' => $userId],
                 ['type' => 'dislike']
             );
         }

         return redirect()->route('content.show', ['id' => $contentId])->with('message', 'Dislike toggled');
     }

}
