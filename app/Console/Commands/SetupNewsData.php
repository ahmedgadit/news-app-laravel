<?php

namespace App\Console\Commands;

use App\Enums\SourceEnum;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PlatformRepository;
use App\Repositories\SourceRepository;
use App\Services\Guardian;
use App\Services\NewsOrg;
use App\Services\NyTimes;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
            // $this->addSources();
            // $this->addCategories();
            $this->addNews();
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
            $newsOrg = new NewsOrg();
            $sources = $newsOrg->getSources();

            $this->info('Adding sources...');
            $progressBar = $this->output->createProgressBar(count($sources));

            foreach ($sources as $source) {
                $sourceData = [
                    'name' => $source->name,
                    'source_uuid' => $source->id,
                    'description' => $source->description,
                    'language' => $source->language,
                    'url' => $source->url,
                    'country' => $source->country,
                    'category_id' => null,
                    'status' => 1,
                ];
                $sourceRepository = new SourceRepository();
                $categoryRepository = new CategoryRepository();
                $categoryData = ['name' => strtolower($source->category)];
                $categoryRepository->createOrUpdate($categoryData, $categoryData);
                $sourceData['category_id'] = $categoryRepository->getByColumn($source->category, 'name')->id;
                $sourceRepository->createOrUpdate(['source_uuid' => $source->id, 'name' => $source->name], $sourceData);

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->info("\nSources added successfully.");
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

            $guardian = new Guardian();
            $gCats = $guardian->getCategories();
            $result = $gCats->response->results;
            $categories = array_merge($nyCats, $result);

            $this->info('Adding categories...');
            $progressBar = $this->output->createProgressBar(count($categories));

            foreach ($categories as $category) {
                $checkIsObject = !is_object($category);
                $catName = $checkIsObject ? $category['section'] : $category->id;
                $catDisplayName = $checkIsObject ? $category['display_name'] : $category->webTitle;
                $apiUrl = $checkIsObject ? null : $category->apiUrl;
                $categoryData = [
                    'name' => $catName,
                    'display_name' => $catDisplayName,
                    'apiUrl' => $apiUrl ?? null,
                    'status' => 1,
                ];
                $categoryRepository = new CategoryRepository();
                $categoryRepository->createOrUpdate(['name' => $catName, 'apiUrl' => $apiUrl], $categoryData);

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->info("\nCategories added successfully.");
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function addNews() 
    {
        try {
            $allNews = [];

            // Fetch news from Guardian
            $this->info('Fetching news from Guardian...');
            $guardian = new Guardian();
            $currentMonthFirstDate = Carbon::now()->firstOfMonth()->format('d/m/Y');
            $pageSize = 100;
            $page = 1;
            $totalPages = 380;
            $guardianProgressBar = $this->output->createProgressBar($totalPages);

            do {
                $guardianResp = $guardian->getNewsByDate($currentMonthFirstDate, $pageSize, $page);
                $results = $guardianResp;

                // Process or store the results as needed
                $allNews = array_merge($allNews, $results);

                $page++;
                $guardianProgressBar->advance();
            } while ($page <= $totalPages);

            $guardianProgressBar->finish();
            $this->info("\nGuardian news fetched successfully.");

            // Fetch news from New York Times
            $this->info('Fetching news from New York Times...');
            $nyTimes = new NyTimes();
            $limit = 500;
            $offset = 0;
            $totalNyTimesPages = 1; // Assuming 1 page for simplicity, adjust as needed
            $nyTimesProgressBar = $this->output->createProgressBar($totalNyTimesPages);

            do {
                $nyTimesResp = $nyTimes->getAll($limit, $offset);
                $results = $nyTimesResp;

                // Process or store the results as needed
                $allNews = array_merge($allNews, $results);

                $offset += $limit;
                $nyTimesProgressBar->advance();
            } while (count($results) > 0 && $offset <= 500);

            $nyTimesProgressBar->finish();
            $this->info("\nNew York Times news fetched successfully.");

            // Fetch top headlines from NewsOrg
            $this->info('Fetching top headlines from NewsOrg...');
            $newsOrg = new NewsOrg();
            $newsOrgResp = $newsOrg->getTopHeadlines();
            // dd($newsOrgResp);
            $allNews = array_merge($allNews, $newsOrgResp);
            $this->info("NewsOrg headlines fetched successfully.");

            // Insert news into articles table
            $this->info('Inserting news into articles table...');
            $this->insertArticles($allNews);
            $this->info('News data has been successfully fetched and stored.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }


    /**
     * Insert articles into the database.
     *
     * @param array $articles
     * @return void
     */
    private function insertArticles(array $articles)
    {
        $progressBar = $this->output->createProgressBar(count($articles));
        $articleRepository = new ArticleRepository();
        $sourceRepository = new SourceRepository();
        $platformRepository = new PlatformRepository();
        $categoryRepository = new CategoryRepository();

        foreach ($articles as $article) {
            if(is_object($article)) {
                $sourceUUID = isset($article->api_url) ? SourceEnum::GuardianUUID : $article->source->id;
                $articleUUID = isset($article->api_url) ? $article->article_uuid : $article->url;
                $platformUUID = isset($article->api_url) ? SourceEnum::GuardianUUID : SourceEnum::NewsOrgUUID;
                $platform = $platformRepository->getByColumn($platformUUID, 'platform_uuid');
                $source = $sourceRepository->getByColumn($sourceUUID, 'source_uuid');
                $category = isset($article->category) ? $categoryRepository->getByColumn($article->category, 'name') : null;
                if(!$source) {
                    $source = $sourceRepository->with('category')->getByColumn($article->source->name, 'name');
                    $category = $source->category ?? null;
                }
                $article->source_id = $source->id ?? null;
                $article->platform_id = $platform->id ?? null;
                $article->category_id = $category->id ?? null;
                $article = collect($article)->except('source')->toArray();
                $article['source_payload'] = json_encode($article);

                $articleRepository->createOrUpdate(['article_uuid' => $articleUUID], $article);
            } else {
                $source = $sourceRepository->getByColumn(SourceEnum::NewYorkTimesUUID, 'source_uuid');
                $platform = $platformRepository->getByColumn(SourceEnum::NewYorkTimesUUID, 'platform_uuid');
                $category = $categoryRepository->getByColumn($article['category'], 'name');
                
                $article['platform_id'] = $platform->id ?? null;
                $article['source_id'] = $source->id ?? null;
                $article['category_id'] = $category->id ?? null;
                $article = collect($article)->toArray();
                $article['source_payload'] = json_encode($article);
                $article['image_payload'] = json_encode($article['image_payload']);

                $articleRepository->createOrUpdate(['article_uuid' => $article['article_uuid']], $article);
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
