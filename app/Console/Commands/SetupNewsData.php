<?php

namespace App\Console\Commands;

use App\Repositories\CategoryRepository;
use App\Repositories\SourceRepository;
use App\Services\Guardian;
use App\Services\News;
use App\Services\NyTimes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        try {
            $this->addSources();
            $this->addCategories();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    /**
     * This function use to add sources from news-api sources
     *
     * @return void
     */
    public function addSources() 
    {
        try {
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
                $categoryData = ['name' => strtolower($source->category)];
                $categoryRepository->createOrUpdate($categoryData, $categoryData);
                $sourceRepository->createOrUpdate(['source_uuid' => $source->id], $sourceData);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
        
    }

    /**
     * This function use to add categories from different news sources
     *
     * @return void
     */
    public function addCategories() 
    {
        try {
            $nyTimes = new NyTimes();
            $nyCats = $nyTimes->getCategories();
            $nyCats = json_decode($nyCats, true);

            $guardian = new Guardian();
            $gCats = $guardian->getCategories();
            $result = $gCats->response->results;
            $categories = [...$nyCats['results'], ...$result];
            foreach ($categories as $category) {
                $categoryData = [
                    'name' => $category['section'] ?? $category['id'],
                    'display_name' => $category['display_name'] ?? $category['webTitle'],
                    'apiUrl' => $category['apiUrl'] ?? null,
                    'status' => 1,
                ];
                $categoryRepository = new CategoryRepository();
                $categoryRepository->createOrUpdate(['name' => $categoryData['name'], 'apiUrl'=> $categoryData['apiUrl']], $categoryData);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }
}
