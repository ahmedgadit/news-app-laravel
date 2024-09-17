<?php

namespace App\Repositories;

use App\Models\Sources;
use App\Repositories\Interfaces\SourceInterface;

/**
 * Class PageRepository.
 */
class SourceRepository extends BaseRepository implements SourceInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Sources::class;
    }
}
