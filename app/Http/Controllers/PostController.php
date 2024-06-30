<?php

namespace App\Http\Controllers;

use App\DTO\PostStoreData;
use App\DTO\PostUpdateData;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\Dummy\PostService;

class PostController extends Controller
{
    protected PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function index()
    {
        $data = (new PostService())->index();

        return response()->json(['data' => $data]);
    }

    public function store(PostRequest $request)
    {
        $data = PostStoreData::from($request->validated());

        $dummyData = (new PostService($data->toArray()))->store();

        $this->postRepository->store($dummyData->id, $dummyData->userId);

        return response()->json($dummyData);
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = PostUpdateData::from($request->validated());
        $dummyData = (new PostService($data->toArray()))->update($post);

        return response()->json($dummyData);
    }

    public function destroy(Post $post)
    {
        (new PostService())->destroy($post);

        return response()->json(['data' => [
            'success' => true,
            'message' => 'Post deleted successfully!'
        ]]);
    }

}
