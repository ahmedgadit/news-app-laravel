<?php

namespace App\Services;

use jcobhams\NewsApi\NewsApi;

class News 
{
    private $newsApi;

    public function __construct()
    {
        $this->newsApi = new NewsApi(config('news_constant.news_api_key'));
    }

    public function getTopHeadlines($country = 'us', $category = 'general', $pageSize = 100)
    {
        return $this->newsApi->getTopHeadlines(null, null, $country, $category, $pageSize);
    }

    public function getSources() {
        $sources = $this->newsApi->getSources();
        if($sources->status === 'ok') {
            return $sources->sources;
        }
        return [];
    }
}