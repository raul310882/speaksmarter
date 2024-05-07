<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Category;
use App\Models\Lesson;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        'lessons.is_free', 'levels.name as level')->join('levels', 'levels.id', '=', 'lessons.level_id')->with('categories')
        -> orderBy('lessons.id')
        -> paginate(self::NUMBER_OF_ITEMS_PER_PAGE);

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
        //dd ($request);
        $lesson = new Lesson;

        $lesson->pdf_uri = time().'.'.$request->pdf->extension();   //nombre de archivo PDF unico

        $lesson->image_uri = time().'.'.$request->image->extension();   //nombre de archivo IMAGEN unico

        $lesson->content_uri = time().'.'.$request->content->extension();   //nombre de archivo ZIP unico
        
        $request->pdf->storeAs('public/pdf_lessons', $lesson->pdf_uri);   //guardado del PDF en storage de la aplicacion
        $request->image->storeAs('public/image_lessons', $lesson->image_uri);   //guardado de la IMAGEN en storage de la aplicacion
        $request->content->storeAs('public/content_lessons', $lesson->content_uri);  //guardado de CONTENT en storage de la aplicacion

        $lesson->name = $request->name;                             //guardado de datos de la lesson
        $lesson->description = $request->description;
        $lesson->level_id = $request->level_id;
        $lesson->is_free = $request->is_free;
        $lesson->save();

        $lesson->categories()->attach(array_column($request->categories,'id'));  //guardado en la tabla pivot category_lesson

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
    public function edit(Lesson $lesson)
    {
        $levels = Level::all();
        $categories = Category::all();
        $lesson->level;
        $lesson->categories;
        return inertia('Lessons/Edit', ['lesson' => $lesson, 'levels' => $levels, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, $lesson_id)
    {
        $lesson = Lesson::find($lesson_id);
        $lesson->name = $request->name;                             //guardado de datos de la lesson
        $lesson->description = $request->description;
        $lesson->content_uri = $request->content_uri;
        $lesson->level_id = $request->level_id;
        $lesson->is_free = $request->is_free;
        $lesson->save();

        $lesson->categories()->sync(array_column($request->categories, 'id'));
        return redirect()->route('lessons.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson_files = Lesson::find($lesson);  // buscar registro a eliminar
        Storage::delete('public/image_lessons/'.$lesson_files[0]->image_uri);   //eliminar imagen
        Storage::delete('public/pdf_lessons/'.$lesson_files[0]->pdf_uri);   //eliminar pdf
     
        $lesson -> categories() -> detach();    //eliminar registros de la tabla pivote
        $lesson->delete();                      //eliminar registro de la tabla lesson
        return redirect()->route('lessons.index');
    }
}
