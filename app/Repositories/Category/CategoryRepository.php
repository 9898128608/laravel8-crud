<?php

namespace App\Repositories\Category;

use App\Models\category\Category;
use App\Repositories\BaseRepository;


class CategoryRepository extends BaseRepository
{
    protected $categoryModel;
    public function __construct(Category $categoryModel)
    {
        parent::__construct($categoryModel);
        $this->categoryModel = $categoryModel;
    }

    
}
