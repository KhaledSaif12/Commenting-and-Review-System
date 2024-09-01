<?php

namespace App\Http\Controllers;
use App\Models\comments;
use App\Models\contents;
use App\Models\likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentReviews extends Controller
{
    //
   


    public function show(Request $request, $id)
    {
        $content = contents::findOrFail($id);

        $sortBy = $request->input('sort_by', 'date-desc');
        $filterRating = $request->input('filter_rating', 'all');

        $query = comments::where('content_id', $id)->with('user');

        if ($filterRating != 'all') {
            $query->where('rating', '>=', $filterRating);
        }

        switch ($sortBy) {
            case 'date-asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating-asc':
                $query->orderBy('rating', 'asc');
                break;
            case 'rating-desc':
                $query->orderBy('rating', 'desc');
                break;
            case 'date-desc':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $comments = $query->paginate(10);

        $averageRating = $comments->isNotEmpty() ? $comments->avg('rating') : 0;

        return view('Content_Reviews', [
            'content' => $content,
            'comments' => $comments,
            'averageRating' => $averageRating,
            'sortBy' => $sortBy,
            'filterRating' => $filterRating,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content_id' => 'required|exists:contents,id',
            'comment_text' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment = new comments();
        $comment->content_id = $validatedData['content_id'];
        $comment->comment_text = $validatedData['comment_text'];
        $comment->rating = $validatedData['rating'];
        $comment->user_id = Auth::id();

        if ($comment->save()) {
            return redirect()->route('content.show', $validatedData['content_id'])
                ->with('success', 'Review submitted successfully!');
        }

        return redirect()->back()->with('error', 'Failed to submit review.');
    }

    public function edit($id)
    {
        $comment = comments::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('content.show', $comment->content_id)
                ->with('error', 'Unauthorized action.');
        }

        return view('edit_comment', ['comment' => $comment]);
    }

    public function update(Request $request, $id)
    {
        $comment = comments::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('content.show', $comment->content_id)
                ->with('error', 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'comment_text' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment->comment_text = $validatedData['comment_text'];
        $comment->rating = $validatedData['rating'];
        $comment->save();

        return redirect()->route('content.show', $comment->content_id)
            ->with('success', 'Review updated successfully!');
    }
    public function destroy($id)
    {
        $comment = comments::findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('content.show', $comment->content_id)
                ->with('error', 'Unauthorized action.');
        }

        // حذف Likes المرتبطة بالتعليق
        likes::where('comment_id', $id)->delete();

        $comment->delete();

        return redirect()->route('content.show', $comment->content_id)
            ->with('success', 'Review deleted successfully!');
    }

}
