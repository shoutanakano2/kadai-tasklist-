<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
use App\User;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            
            return view('tasks.index', $data);
        }
        else{
            return view('welcome',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks= new Task;
        return view('tasks.create',['task'=>$tasks,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'status'=>'required|max:10',
            ]);
        $this->validate($request,[
            'content'=>'required',
            ]);
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        return redirect('/');
        
        
        /*$this->validate($request,[
            'status'=>'required|max:10',
            ]);
        $this->validate($request,[
            'content'=>'required',
            ]);
        $task=new Task;
        $task->content=$request->content;
        $task->status=$request->status;
        $task->user_id=$request->user_id;
        $task->save();
        return redirect('/');*/
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $task=\App\Task::find($id);
        if(\Auth::id() ===$task->user_id){
        $task = Task::find($id);

        $data = [
            'task' => $task,
        ];


        return view('tasks.show', $data);}
        else{
            return view('welcome',$data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task=\App\Task::find($id);
        if(\Auth::id() ===$task->user_id){        
        $task=Task::find($id);
        return redirect('/');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $task=\App\Task::find($id);
        if(\Auth::id() ===$task->user_id){
       
        $this->validate($request,[
            'status'=>'required|max:10',
            ]);
        $this->validate($request,[
            'content'=>'required',
            ]);
        $task=Task::find($id);
        $task->content=$request->content;
        $task->status=$request->status;
        
  
        $task->save();
        return redirect('/');
        
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task=\App\Task::find($id);
        if(\Auth::id() ===$task->user_id){
            $task->delete();
        }
        return redirect('/');
    }
}
