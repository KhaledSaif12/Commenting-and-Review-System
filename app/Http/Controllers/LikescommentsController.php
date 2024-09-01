<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\comments;
use App\Models\contents;
use Illuminate\Http\Request;
use App\Models\likescomments;

class LikescommentsController extends Controller
{
    //
    // Add a new like/dislike
    public function store(Request $request)
    {
        $request->validate([
            'content_id' => 'required|exists:contents,id',
            'type' => 'required|in:like,dislike',
        ]);

        $userId = Auth::id();

        // Check if the user has already liked/disliked this content
        $existingLike = likescomments::where('content_id', $request->input('content_id'))
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            return redirect()->back()->with('error', 'You have already rated this content.');
        }

        likescomments::create([
            'user_id' => $userId,
            'content_id' => $request->input('content_id'),
            'type' => $request->input('type'),
        ]);

        return redirect()->back()->with('success', 'Your rating has been added.');
    }

    // Update an existing like/dislike
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        $like = likescomments::find($id);

        if (!$like) {
            return redirect()->back()->with('error', 'Rating not found.');
        }

        $like->update([
            'type' => $request->input('type'),
        ]);

        return redirect()->back()->with('success', 'Your rating has been updated.');
    }

    // Delete a like/dislike
    public function destroy($id)
    {
        $like = likescomments::find($id);

        if (!$like) {
            return redirect()->back()->with('error', 'Rating not found.');
        }

        $like->delete();

        return redirect()->back()->with('success', 'Your rating has been removed.');
    }

    public function toggleLike(Request $request, $contentId)
    {
        $userId = Auth::id();
        $existingLike = likescomments::where('content_id', $contentId)
                               ->where('user_id', $userId)
                               ->where('type', 'like')
                               ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            likescomments::where('content_id', $contentId)
                 ->where('user_id', $userId)
                 ->where('type', 'dislike')
                 ->delete();

                 likescomments::updateOrCreate(
                ['content_id' => $contentId, 'user_id' => $userId],
                ['type' => 'like']
            );
        }

        return redirect()->back();
    }

    public function toggleDislike(Request $request, $contentId)
    {
        $userId = Auth::id();
        $existingDislike = likescomments::where('content_id', $contentId)
                                 ->where('user_id', $userId)
                                 ->where('type', 'dislike')
                                 ->first();

        if ($existingDislike) {
            $existingDislike->delete();
        } else {
            likescomments::where('content_id', $contentId)
                 ->where('user_id', $userId)
                 ->where('type', 'like')
                 ->delete();

                 likescomments::updateOrCreate(
                ['content_id' => $contentId, 'user_id' => $userId],
                ['type' => 'dislike']
            );
        }

        return redirect()->back();
    }

    // Get total likes for a content
    public function getTotalLikes($contentId)
    {
        $likesCount = likescomments::where('content_id', $contentId)
            ->where('type', 'like')
            ->count();

        return $likesCount;
    }

    // Get total dislikes for a content
    public function getTotalDislikes($contentId)
    {
        $dislikesCount = likescomments::where('content_id', $contentId)
            ->where('type', 'dislike')
            ->count();

        return $dislikesCount;
    }
}
