<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Response;

class LessonController extends Controller
{
    const NUMBER_OF_ITEMS_PER_PAGE = 10;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::select('lessons.id', 'lessons.name', 'lessons.description', 'lessons.image_uri', 'lessons.content_uri', 'lessons.pdf_uri', 'lessons.level_id',
        'lessons.is_free', 'levels.name as level')->join('levels', 'levels.id', '=', 'lessons.level_id')->orderBy('lessons.id')
        ->paginate(self::NUMBER_OF_ITEMS_PER_PAGE);
        return inertia('Lessons/Index', ['lessons' => $lessons]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $levels = Level::all();
        return inertia('Lessons/Create', ['categories' => $categories, 'levels' => $levels]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        Lesson::create($request->validated())   //guardado de la lesson
        ->categories()->attach(array_column($request->categories,'id'));   //guardado en la tabla pivote category_lesson
        return redirect()->route('lessons.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson -> categories() -> detach();
        $lesson->delete();
        return redirect()->route('lessons.index');
    }
}
