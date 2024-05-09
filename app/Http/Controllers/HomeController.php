<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\URL;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $result = [];
        $categoryId = null;
        if ($request->has('q') && !empty($request->get('q'))) {
            $term = $request->get('q');
            $result['query'] = $term;
            $products = Product::query()
                ->where('title', 'like', '%' . $term . '%')
                ->get();
        } else if ($request->has('c') && !empty($request->get('c'))) {
            $categoryId = $request->get('c');
            $products = Product::query()
                ->where('category_id', $categoryId)
                ->get();
        } else {
            $products = Product::all();
        }
        $result['products'] = $products;

        $categories = Category::all();
        $result['categories'] = $categories;

        $result['menu'][] = [
            'title' => 'خانه',
            'url' => $request->url(),
            'active' => $request->url() == $request->fullUrl()
        ];

        foreach ($categories as $category) {
            $result['menu'][] = [
                'title' => $category->title,
                'url' => $request->url() . '?c=' . $category->id,
                'active' => $categoryId == $category->id
            ];
        }

        return view('index', $result);
    }
}

