<?php

namespace App\Services\Dummy;

use App\DTO\PostGetData;
use App\Models\Post;
use App\Repositories\PostRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;

class PostService
{
    //todo в будущем при наличие дополнительных сервисов, сделаем BaseService который будет инициализировать запрос
    protected array $options;
    protected Client $client;
    protected PostRepository $postRepository;

    public function __construct(array $data = [])
    {
        $this->client = new Client();

        $this->options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => $data,
        ];

        $this->postRepository = new PostRepository();
    }

    /*
    * так как создание поста, только симулирует создание на dummy сервере, то при попытке вытащить созданные
    * нами посты, мы непременно столкнёмся с ошибкой 404
    * для теста можно передавать айдишник 1
    * */
    public function index(): array
    {
        $dummyIds = $this->postRepository->getAllDummyIds()['data'];
        $res = [];
        foreach ($dummyIds as $dummyId) {
            $response = $this->client->get(config('app.api_url.dummy') . $dummyId);
            $responseData = json_decode($response->getBody()->getContents(), true);

            $res[] = $responseData;
        }

        return PostGetData::collect($res);
    }


    public function store(): PostGetData
    {
        $response = $this->client->post(config('app.api_url.dummy') . 'add', $this->options);

        $responseData = json_decode($response->getBody()->getContents(), true);

        return PostGetData::from($responseData);
    }

    public function update(Post $post): PostGetData
    {

        if ($post->user_id != Auth::id())
            throw new ValidationException('You are trying to update a post that is not yours!');

        $this->postRepository->update($post);

        $response = $this->client->put(config('app.api_url.dummy') . $post->dummy_post_id, $this->options);

        $responseData = json_decode($response->getBody()->getContents(), true);

        return PostGetData::from($responseData);
    }

    public function destroy(Post $post): void
    {
        if ($post->user_id != Auth::id())
            throw new ValidationException('You are trying to delete a post that is not yours!');

        $this->postRepository->destroy($post);

        $response = $this->client
            ->delete(config('app.api_url.dummy') . $post->dummy_post_id, $this->options);

        json_decode($response->getBody()->getContents(), true);
    }
}
