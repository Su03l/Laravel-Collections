<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SnippetController extends Controller
{
    public function index()
    {
        // 1. نجيب كل الأقسام مع الأكواد التابعة لها
        // 2. نقسمها برمجياً حسب نوعها (frontend, backend, database)
        $groupedCategories = Category::with('snippets')->get()->groupBy('type');

        // نرسل البيانات لصفحة الـ welcome اللي بنسوي فيها واجهة السايبربانك
        return view('welcome', compact('groupedCategories'));
    }
}
