<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NyTimes {

    private $nyTimeClient;
    private $ignoreSources = ['admin', 'en espa<C3><B1>ol', 'home page', 'today<E2><80><99>s paper'];


    public function __construct()
    {
        $this->nyTimeClient = Http::withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function getAll() 
    {
        $url = config('news_constant.ny_times_endpoint') . '/news/v3/content/all/all.json?api-key=' . config('news_constant.ny_times_api_key');
        $response = $this->nyTimeClient->get($url);

        if ($response->successful()) {
            return $response->body();
        } else {
            return $response->status();
        }
    }


    public function getCategories()
    {
        $url = config('news_constant.ny_times_endpoint') . '/news/v3/content/section-list.json?api-key=' . config('news_constant.ny_times_api_key');
        $response = $this->nyTimeClient->get($url);

        if ($response->successful()) {
            return $response->body();
        } else {
            return $response->status();
        }
    }
}