<?php

namespace App\Repositories;

use App\Models\Source;
use App\Repositories\Interfaces\SourceInterface;

/**
 * Class SourceRepository.
 */
class SourceRepository extends BaseRepository implements SourceInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Source::class;
    }
}
