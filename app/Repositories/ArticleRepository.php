<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleInterface;

/**
 * Class ArticleRepository.
 */
class ArticleRepository extends BaseRepository implements ArticleInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Article::class;
    }
}
