<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Categories\Category;
class HomeController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cats = Category::all();
        // $cat1 = $this->categoryRepo->findCategoryById(4);
        // $cat2 = $this->categoryRepo->findCategoryById(5);
        
        foreach($cats as $key=>$cat)
        {
           
            if ($key === 1) {
                $cat1 = $this->categoryRepo->findCategoryById($key);
            }
            else if ( $key === 2) {
                $cat2 = $this->categoryRepo->findCategoryById($key);
            }
        }
        
        return view('front.index', compact('cat1','cat2'));
    }
}
