<?php

namespace App\Services;

use Carbon\Carbon;
use jcobhams\NewsApi\NewsApi;

class NewsOrg extends Platforms
{
    private $newsApi;
    protected $keys = [
        'source',
        'author',
        'id',
        'name',
        'title',
        'description',
        'short_description',
        'url',
        'image_url',
        'published_date',
    ];

    protected $mapKeys = [
        'description' => 'short_description',
        'content' => 'description',
        'urlToImage' => 'image_url',
        'publishedAt' => 'published_date',
    ];

    public function __construct()
    {
        $this->newsApi = new NewsApi(config('news_constant.news_api_key'));
    }

    public function getTopHeadlines($country = 'us', $category = 'general', $pageSize = 100)
    {
        $response = $this->newsApi->getTopHeadlines(null, null, 'us', page_size: $pageSize);
        return $this->createResponse($response->articles);
    }

    public function getSources() {
        $sources = $this->newsApi->getSources();
        if($sources->status === 'ok') {
            return $sources->sources;
        }
        return [];
    }
}