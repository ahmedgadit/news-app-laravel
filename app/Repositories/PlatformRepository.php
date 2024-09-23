<?php

namespace App\Repositories;

use App\Models\Platform;
use App\Repositories\Interfaces\PlatformInterface;

/**
 * Class PlatformRepository.
 */
class PlatformRepository extends BaseRepository implements PlatformInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Platform::class;
    }
}
