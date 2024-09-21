<?php

namespace App\Services;

use Guardian\GuardianAPI;
use Illuminate\Support\Facades\Http;

class Guardian {

    private $guardianClient;

    public function __construct()
    {
        $this->guardianClient = new GuardianAPI(config('news_constant.guardian_api_key'));
    }

    public function getTopHeadlines($country = 'us', $category = 'general', $pageSize = 100)
    {

    }

    /**
     * This function use to get tags from guardian api
     */
    public function getCategories()
    {
        return $this->guardianClient->sections()
        ->fetch();
    }
}