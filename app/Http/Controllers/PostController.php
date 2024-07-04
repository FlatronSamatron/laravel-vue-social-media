<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        /** @var UploadedFile[] $files */
        $files = $data['attachments'] ?? [];

        DB::beginTransaction();
        $allFilePath = [];
        try {
            $postData = array_filter($data, function($k) {
                return $k !== 'attachments';
            }, ARRAY_FILTER_USE_KEY);

            $post = Post::create($postData);

            foreach ($files as $file){
                $path = $file->store('attachments/'.$post->id, 'public');
                $allFilePath[] = $path;
                PostAttachment::create([
                        'post_id' => $post->id,
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'created_by' => $user->id
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            foreach ($allFilePath as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw $e;
        }


        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $id = Auth::id();
        if($post->user_id !== $id){
            return response("ypu don't have permission to delete this post", 403);
        }

        $post->delete();

        return back();
    }
}
