<?php

namespace App\Console\Commands;

use App\Repositories\CategoryRepository;
use App\Repositories\SourceRepository;
use App\Services\News;
use App\Services\NyTimes;
use Illuminate\Console\Command;

class SetupNewsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-news-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->addSources();
        $this->addCategories();
    }

    public function addSources() 
    {
        $news = new News();
        $sources = $news->getSources();
        foreach ($sources as $source) {
            $sourceData = [
                'name' => $source->name,
                'source_uuid' => $source->id,
                'description' => $source->description,
                'category' => $source->category,
                'language' => $source->language,
                'url' => $source->url,
                'country' => $source->country,
                'status' => 1,
            ];
            $sourceRepository = new SourceRepository();
            $categoryRepository = new CategoryRepository();
            $categoryData = ['name' => strtolower($source['category'])];
            $categoryRepository->createOrUpdate($categoryData, $categoryData);
            $sourceRepository->createOrUpdate(['source_uuid' => $source['id']],$sourceData);
        }
    }

    public function addCategories () 
    {
        $news = new NyTimes();
        $categories = $news->getCategories();
        $categories = json_decode($categories, true);
    }
}
