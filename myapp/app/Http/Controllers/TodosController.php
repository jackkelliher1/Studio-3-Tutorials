<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('created_at','desc')->paginate(8);
            return view('todos.index',[
                'todos' => $todos,
            ]);
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
    $rules = [
        'title' => 'required|string|unique:todos,title|min:2|max:191',
        'body'  => 'required|string|min:5|max:1000',
    ];
    //custom validation error messages
    $messages = [
        'title.unique' => 'Todo title should be unique', //syntax: field_name.rule
    ];
    //First Validate the form data
    $request->validate($rules,$messages);
    //Create a Todo
    $todo = new Todo;
    $todo->title = $request->title;
    $todo->body = $request->body;
    $todo->save(); // save it to the database.
    //Redirect to a specified route with flash message.
    return redirect()
        ->route('todos.index')
        ->with('status','Created a new Todo!');
}

    public function show($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todos.show',[
            'todo' => $todo,
        ]);
    }

    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todos.edit',[
            'todo' => $todo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => "required|string|unique:todos,title,{$id}|min:2|max:191", //Using double quotes
            'body'  => 'required|string|min:5|max:1000',
        ];
        //custom validation error messages
        $messages = [
            'title.unique' => 'Todo title should be unique',
        ];
        //First Validate the form data
        $request->validate($rules,$messages);
        //Update the Todo
        $todo        = Todo::findOrFail($id);
        $todo->title = $request->title;
        $todo->body  = $request->body;
        $todo->save(); //Can be used for both creating and updating
        //Redirect to a specified route with flash message.
        return redirect()
            ->route('todos.show',$id)
            ->with('status','Updated the selected Todo!');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        //Redirect to a specified route with flash message.
        return redirect()
            ->route('todos.index')
            ->with('status','Deleted the selected Todo!');
    }
}