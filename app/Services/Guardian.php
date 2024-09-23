<?php

namespace App\Services;

use Guardian\GuardianAPI;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Guardian extends Platforms
{

    private $guardianClient;
    protected $keys = [
        'article_uuid',
        'category',
        'author',
        'title',
        'url',
        'api_url',
        'type',
        'published_date',
    ];
    protected $mapKeys = [
        'id' => 'article_uuid',
        'webTitle' => 'title',
        'sectionName' => 'category',
        'type' => 'type',
        'webUrl' => 'url',
        'apiUrl' => 'api_url',
        'webPublicationDate' => 'published_date',
    ];

    public function __construct()
    {
        $this->guardianClient = new GuardianAPI(config('news_constant.guardian_api_key'));
    }

    public function getTopHeadlines($country = 'us', $category = 'general', $pageSize = 100) {}

    /**
     * This function use to get tags from guardian api
     */
    public function getCategories()
    {
        return $this->guardianClient->sections()
            ->fetch();
    }

    /**
     * This function use to get tags from guardian api
     */
    public function getNewsByDate($fromDate = '1/09/2024', $pageSize = 20, $page = 1)
    {
        $response = $this->guardianClient->content()
            ->setFromDate(new \DateTimeImmutable($fromDate))
            ->setToDate(new \DateTimeImmutable())
            ->setPageSize($pageSize)
            ->setPage($page)
            ->fetch();
        // dd($response);
        return $this->createResponse($response->response->results);
    }
}
