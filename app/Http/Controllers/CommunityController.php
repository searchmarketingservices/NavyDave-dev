<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Image;
use App\Models\Video;
use App\Models\Comment;
use App\Events\PostCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\NewCommentAdded;
use App\Events\NewLikeAdded;
use App\Notifications\PostCreatedNotification;
use App\Models\User;
use App\Events\PostCreateNoti;
use App\Notifications\PostLikedNotification;
use App\Notifications\PostCommentedNotification;
use App\Notifications\CommentRepliedNotification;
use App\Notifications\LikeOnCommentNotification;
use Illuminate\Support\Facades\Storage;
use App\Events\PostDelete;
use App\Notifications\PostDeleteNotification;

class CommunityController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.community.index');
    }

    public function postGet(Request $request)
    {
        $filter = $request->input('filter', 'latest'); // Default to latest posts if no filter is specified

        $postsQuery = Post::with('user', 'likes', 'comments.user', 'images', 'videos');

        // Apply filtering based on the filter value
        switch ($filter) {
            case 'popular':
                // Popular filter: posts with the most likes
                $postsQuery->withCount('likes', 'comments')->orderByDesc('likes_count')->orderByDesc('comments_count');
                break;

            case 'hot':
                // Hot filter: posts that have received recent engagement (likes or comments) in a specific timeframe
                $postsQuery->where('created_at', '>=', now()->subDays(2)) // Consider recent posts within the last 2 days
                    ->withCount('likes', 'comments')
                    ->orderByDesc('likes_count')
                    ->orderByDesc('comments_count');
                break;

            default:
                // Default: latest posts
                $postsQuery->latest('created_at');
                break;
        }

        $posts = $postsQuery->paginate(10);

        $posts->getCollection()->transform(function ($post) {
            $post->hasLiked = $post->likes->where('user_id', auth()->id())->isNotEmpty();
            $post->likeCount = $post->likes->count();
            return $post;
        });

        foreach ($posts as $post) {
            foreach ($post->comments as $comment) {
                $comment->replyCount = $comment->replies->count();
                $comment->commentHasLiked = $comment->likes->where('user_id', auth()->id())->isNotEmpty();
                $comment->commentLikeCount = $comment->likes->count();
            }
        }

        return response()->json($posts);
    }

    public function commentGet(Request $request)
    {
        // Fetch the post with comments (including all nested replies) and other related data
        $posts = Post::where('id', $request->id)
            ->with([
                'user',
                'likes',
                'comments' => function ($query) {
                    // Only fetch top-level comments (comments where parent_id is NULL)
                    $query->whereNull('parent_id')->with([
                        'user',
                        'replies' => function ($replyQuery) {
                        // Fetch replies and their nested replies recursively
                        $replyQuery->with([
                            'user',
                            'replies' => function ($nestedReplyQuery) {
                            // Recursively load all levels of nested replies
                            $nestedReplyQuery->with([
                                'user',
                                'replies' => function ($deepNestedReplyQuery) {
                                // Continue loading all levels of nested replies as needed
                                $deepNestedReplyQuery->with([
                                    'user',
                                    'replies' => function ($deepestNestedReplyQuery) {
                                    // Continue loading all levels of nested replies as needed
                                    $deepestNestedReplyQuery->with([
                                        'user',
                                        'replies' => function ($deepestDeepestNestedReplyQuery) {
                                        // Continue loading all levels of nested replies as needed
                                        $deepestDeepestNestedReplyQuery->with([
                                            'user',
                                            'replies' => function ($deepestDeepestDeepestNestedReplyQuery) {
                                            // Continue loading all levels of nested replies as needed
                                            $deepestDeepestDeepestNestedReplyQuery->with([
                                                'user',
                                                'replies' => function ($deepestDeepestDeepestDeepestNestedReplyQuery) {
                                                // Continue loading all levels of nested replies as needed
                                                $deepestDeepestDeepestDeepestNestedReplyQuery->with(['user', 'replies.user']);
                                            }
                                            ]);
                                        }
                                        ]);
                                    }
                                    ]);
                                }
                                ]);
                            }
                            ]);
                        }
                        ]);
                    }
                    ]);
                },
                'images',
                'videos'
            ])
            ->latest('created_at')
            ->paginate(10);

        // Transform the collection to include like status and counts
        $posts->getCollection()->transform(function ($post) {
            // Check if the authenticated user has liked the post
            $post->hasLiked = $post->likes->where('user_id', auth()->id())->isNotEmpty();
            $post->likeCount = $post->likes->count();

            // Iterate over the comments to attach like and reply-related data
            $post->comments->transform(function ($comment) {

                // Check if the authenticated user has liked the comment
                $comment->hasLiked = $comment->likes->where('user_id', auth()->id())->isNotEmpty();
                $comment->likeCount = $comment->likes->count();

                $comment->replyCount = $comment->replies->count();
                return $comment;
            });

            return $post;
        });

        return response()->json($posts);
    }

    public function likeComment(Request $request)
    {
        $comment = Comment::findOrFail($request->comment_id);
        $post = Post::with('user', 'likes', 'comments', 'images', 'videos')->find($comment->post_id);
        $user = auth()->user();

        // Toggle like/unlike
        if ($comment->likes()->where('user_id', $user->id)->exists()) {
            $comment->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $comment->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        // Get the updated like count
        $likeCount = $comment->likes()->count();

        $likes = (object) ['count' => $likeCount, 'liked' => $liked, 'commentId' => $request->comment_id];

        if ($liked == true) {
            // Notify the post owner
            if ($comment->user_id != auth()->id()) {
                $comment->user->notify(new LikeOnCommentNotification($post));
                event(new PostCreateNoti($post));
            }
        }

        event(new NewLikeAdded($likes));

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likeCount' => $likeCount
        ]);
    }

    public function post(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:5000',
            'files.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,avi,mov,|max:20480'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Get the authenticated user's ID
        $userId = auth()->id();

        // Initialize variables to store image and video paths
        $imagePath = null;
        $videoPath = null;

        // Create a new post
        $post = Post::create([
            'user_id' => $userId,
            'content' => $request->input('content', ''),
            'image_id' => $imagePath,
            'video_id' => $videoPath
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'webp',])) {
                    // Store images in 'community/images' folder
                    $imagePath = $file->store('community/images', 'public');
                    Image::create([
                        'path' => $imagePath,
                        'post_id' => $post->id
                    ]);
                } elseif (in_array($file->getClientOriginalExtension(), ['mp4', 'avi', 'mov'])) {
                    // Store videos in 'community/videos' folder
                    $videoPath = $file->store('community/videos', 'public');
                    Video::create([
                        'path' => $videoPath,
                        'post_id' => $post->id
                    ]);
                }
            }
        }

        $post = Post::with('user', 'likes', 'comments', 'images', 'videos')->find($post->id);
        // Check if the authenticated user has liked the post
        $post->hasLiked = $post->likes->where('user_id', auth()->id())->isNotEmpty();
        $post->likeCount = $post->likes->count();

        event(new PostCreated($post));

        // Notify all users
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new PostCreatedNotification($post));
        }
        event(new PostCreateNoti($post));


        return response()->json(['message' => 'Post submitted successfully!', 'post' => $post]);
    }

    public function fetchReplies($postId)
    {
        $comment = Comment::with('user')->where('post_id', '=', $postId)->get();
        return response()->json(['comments' => $comment]);
    }

    public function commentPost(Request $request, $postId)
    {
        $post = Post::with('user', 'likes', 'comments', 'images', 'videos')->findOrFail($postId);

        $comment = new Comment();
        $comment->comment = $request->input('content');
        $comment->user_id = auth()->id();
        $comment->post_id = $postId;
        $comment->save();

        $newComment = Comment::with('user', 'likes', 'replies')->find($comment->id);


        // Count the comments for the given post
        $count = Comment::where('post_id', '=', $postId)->count();

        // Convert the new comment to an array and add the count
        $newCommentArray = $newComment->toArray();
        $newCommentArray['count'] = $count;

        $newComment = (object) $newCommentArray;

        event(new NewCommentAdded($newComment));

        // Notify the post owner
        if ($post->user_id != auth()->id()) {
            $post->user->notify(new PostCommentedNotification($comment));
            event(new PostCreateNoti($post));
        }

        $count = Comment::where('post_id', '=', $postId)->count();
        return response()->json(['message' => 'Comment submitted successfully!', 'comment' => $newComment, 'count' => $count]);
    }

    // Adding a reply (or a regular comment)
    public function addComment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'parent_id' => $request->parent_id, // Will be null for top-level comments
        ]);

        $comment->load('user', 'replies.user');

        $count = Comment::where('post_id', '=', $request->post_id)->count();
        $replyCount = Comment::where('parent_id', '=', $request->parent_id)->count();

        $commentData = (object) [
            'id' => $comment->id,
            'post_id' => $comment->post_id,
            'user_id' => $comment->user_id,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at,
            'user_name' => $comment->user->name,
            'count' => $count,
            'replyCount' => $replyCount,
            'isReply' => true,
            'user' => $comment->user,
            'replies' => $comment->replies,
            'parent_id' => $request->parent_id
        ];

        // Notify the post owner
        $post = Post::find($request->post_id);
        if ($post->user_id != auth()->id()) {
            $post->user->notify(new PostCommentedNotification($comment)); // Notify post owner
        }

        // Notify the original comment owner if it's a reply
        if ($request->parent_id) {
            $parentComment = Comment::with('user')->find($request->parent_id);
            if ($parentComment && $parentComment->user_id != auth()->id()) {
                $parentComment->user->notify(new CommentRepliedNotification($comment)); // Notify the original comment owner
            }
        }

        event(new PostCreateNoti($post));

        event(new NewCommentAdded($commentData));

        return response()->json(['message' => 'Comment submitted successfully!', 'comment' => $comment, 'count' => $count]);
    }

    public function like(Request $request, $postId)
    {
        $post = Post::with('user', 'likes', 'comments')->findOrFail($postId);

        // Check if the user has already liked the post
        $existingLike = $post->likes()->where('user_id', auth()->id())->first();
        if ($existingLike) {
            // Remove the like
            $existingLike->delete();

            // Get the updated like count
            $likesCount = $post->likes()->count();

            // Create an object with both the like count and postId
            $likes = (object) ['count' => $likesCount, 'postId' => $postId, 'liked' => false];

            event(new NewLikeAdded($likes));
            return response()->json(['message' => 'Post unliked successfully!', 'likes' => $post->likes()->count(), 'liked' => false]);
        }

        // Add a new like
        $post->likes()->create(['user_id' => auth()->id()]);

        // Get the updated like count
        $likesCount = $post->likes()->count();

        // Create an object with both the like count and postId
        $likes = (object) ['count' => $likesCount, 'postId' => $postId, 'liked' => true];

        // Notify the post owner
        if ($post->user_id != auth()->id()) {
            $post->user->notify(new PostLikedNotification($post));
            event(new PostCreateNoti($post));
        }

        event(new NewLikeAdded($likes));

        return response()->json(['message' => 'Post liked successfully!', 'likes' => $likes, 'liked' => true]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string|max:500', // Adjust validation rules as needed
        ]);

        // Find the comment by ID
        $comment = Comment::findOrFail($id); // Automatically returns a 404 if not found

        // Update the comment's content
        $comment->comment = $request->input('content');
        $comment->save();

        // Return a success response
        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment]);
    }


    // comment delete
    public function deleteComment($id)
    {
        // Find the comment by ID
        $comment = Comment::findOrFail($id);

        // Get the current authenticated user
        $user = auth()->user();
        // User is allowed to delete the comment

        // Check if the comment has replies
        if ($comment->replies()->exists()) {
            // Delete all replies associated with the comment
            $comment->replies()->delete();
        }

        // Delete the main comment
        $comment->delete();

        // Get the count of remaining comments for the post
        $count = Comment::where('post_id', '=', $comment->post_id)->count();
        $post = Post::find($comment->post_id);

        // if($count)

        return response()->json(['message' => 'Comment and its replies deleted successfully.', 'count' => $count, 'post' => $post], 200);
    }

    public function getNotification()
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications;
        $count = $user->unreadNotifications->count();
        return response()->json(['message' => 'Notification fetched successfully!', 'notifications' => $notifications, 'count' => $count]);
    }

    public function markNotification(Request $request, $notificationId)
    {
        $notification = auth()->user()->unreadNotifications->find($notificationId);
        $notification->markAsRead();
        $userRemainingNotification = auth()->user()->unreadNotifications;
        $userRemainingNotificationCount = auth()->user()->unreadNotifications->count();
        return response()->json(['message' => 'Notification marked as read successfully!', 'userRemainingNotification' => $userRemainingNotification, 'userRemainingNotificationCount' => $userRemainingNotificationCount]);
    }

    public function markAllNotification(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'All notifications marked as read successfully!']);
    }

    public function deletePost(Request $request)
    {
        $post = Post::find($request->post_id);

        if ($post) {
            // Capture the post details before deletion
            $postData = [
                'title' => $post->title,
                'content' => $post->content,
                'user_name' => $post->user->name,
                'id' => $post->id,
            ];

            // Delete associated images and videos
            foreach ($post->images as $image) {
                $imagePath = $image->path;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $image->delete();
            }

            foreach ($post->videos as $video) {
                $videoPath = $video->path;
                if (Storage::disk('public')->exists($videoPath)) {
                    Storage::disk('public')->delete($videoPath);
                }
                $video->delete();
            }

            // Delete likes, comments, and the post itself
            $post->likes()->delete();
            $post->comments()->delete();
            $post->delete();

            // Send notification to post owner if they are not the one deleting it
            if ($post->user_id != auth()->id()) {
                $post->user->notify(new PostDeleteNotification($postData)); // Pass captured post data
                event(new PostCreateNoti($postData)); // Pass captured post data to event
            }

            // Broadcast the post delete event
            event(new PostDelete($post->id));

            return response()->json(['message' => 'Post and related data deleted successfully!']);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }


}
