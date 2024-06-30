<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;

class PostRepository extends BaseRepository
{

    protected function setModel()
    {
        $this->model = new Post();
    }

    public function getAllDummyIds(): array
    {
        return  $this->model::query()
            ->select('dummy_post_id')
            ->paginate(2)
            ->toArray();
    }

    public function store(int $dummyPostId, int $userId): void
    {
        $this->model::query()->create([
            'dummy_post_id' => $dummyPostId,
            'user_id' => $userId,
        ]);
    }

    public function update(Post $post): void
    {
        $post->update(['updated_at' => Carbon::now()]);
    }

    public function destroy(Post $post): void
    {
        $post->delete();
    }
}
