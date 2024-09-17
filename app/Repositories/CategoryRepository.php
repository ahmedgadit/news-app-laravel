<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;

/**
 * Class PageRepository.
 */
class CategoryRepository extends BaseRepository implements CategoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Category::class;
    }
}
