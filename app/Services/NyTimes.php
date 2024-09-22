<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NyTimes extends Platforms {

    private $nyTimeClient;
    private $ignoreSources = ['admin', 'en espa<C3><B1>ol', 'home page', 'today<E2><80><99>s paper'];
    protected $keys = [
        'source_uuid',
        'source',
        'category',
        'sub_category',
        'author',
        'title',
        'description',
        'content',
        'url',
        'uri',
        'type',
        'multimedia',
        'width',
        'height',
        'sub_title',
        'published_date',
        'created_date',
        'updated_date',
    ];
   
    protected $mapKeys = [
        'slug_name' => 'source_uuid',
        'title' => 'title',
        'subheadline' => 'sub_title',
        'abstract' => 'description',
        'section' => 'category',
        'subsection' => 'sub_category',
        'language' => 'language',
        'item_type' => 'type',
        'byline' => 'author',
        'country' => 'country',
        'status' => 'status',
        'source' => 'source',
        'url' => 'url',
        'uri' => 'uri',
        'published_date' => 'published_date',
        'created_date' => 'created_date',
        'updated_date' => 'updated_date'
    ];


    public function __construct()
    {
        $this->nyTimeClient = Http::withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function getAll($limit = 500, $offset = 0) 
    {
        $url = config('news_constant.ny_times_endpoint') . '/news/v3/content/all/all.json?limit='. $limit .'&offset='. $offset .'&api-key=' . config('news_constant.ny_times_api_key');
        $response = $this->nyTimeClient->get($url);

        if ($response->successful()) {
            return $this->createResponse(json_decode($response->body(), true)['results'], true);
        } else {
            return $response->status();
        }
    }


    public function getCategories()
    {
        $url = config('news_constant.ny_times_endpoint') . '/news/v3/content/section-list.json?api-key=' . config('news_constant.ny_times_api_key');
        $response = $this->nyTimeClient->get($url);

        if ($response->successful()) {
            return json_decode($response->body(), true)['results'];
        } else {
            return $response->status();
        }
    }
}