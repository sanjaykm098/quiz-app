<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categorizes = Category::select('id', 'name')->get();
        foreach ($categorizes as $category) {
            $category->uuid = base64_encode($category->id);
        }
        return Inertia::render('Home', compact('categorizes'));
    }
}
