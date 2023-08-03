<?php

namespace App\Repositories;

use App\Models\Media;

class MediaRepository extends BaseRepository
{
    public function __construct(readonly Media $model)
    {
        parent::__construct($this->model);
    }
}
