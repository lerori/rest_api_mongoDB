<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all($param) 
    {
        // 
        $result = null;
        global $target; 
        $target  = substr(strrchr($param, "="),1); //Check if a date was entered

        if ($target) {
            $param = strstr($param, "=", true);    //Separate selection
        }

        switch ($param) {
            /**
             * Display a task by id.
             *
             * @return \Illuminate\Http\Response
             */
            case 'id':
                $result = \Cache::remember('index', 15/60, function () {
                    global $target;
                    return Task::find($target);
                });
                break;
            /**
             * Display a listing of the all tasks.
             *
             * @return \Illuminate\Http\Response
             */
            case 'all':
                $result = \Cache::remember('index', 15/60, function () {
                    return Task::orderBy('_id', 'ASC')->simplePaginate(5);
                });
                break;
            /**
             * Display a listing of tasks, filter by completed.
             *
             * @return \Illuminate\Http\ResponseTask::orderBy
             */        
            case 'completed':
                $result = \Cache::remember('tascom', 15/60, function () {
                    return Task::orderBy('_id', 'ASC')
                                ->where('completed','=', 'true')
                                ->simplePaginate(5);
                });
                break;
            /**
             * Display a listing of tasks, filter by uncompleted.
             *
             * @return \Illuminate\Http\Response
             */    
            case 'uncompleted':
                $result = \Cache::remember('tascom', 15/60, function () {
                    return Task::orderBy('_id', 'ASC')
                                ->where('completed','=', 'false')
                                ->simplePaginate(5);
                });
                break;
             /**
             * Display a listing of tasks, filter by due_date.
             *
             * @return \Illuminate\Http\Response
             */    
            case 'due':
                $result = \Cache::remember('tasdue', 15/60, function () {
                    global $target;
                    return Task::orderBy('_id', 'ASC')
                                ->where('due_date','=', $target)
                                ->simplePaginate(5);
                });   
                break; 
             /**
             * Display a listing of tasks, filter by created_at.
             *
             *$js = '2018-09-08'; @return \Illuminate\Http\Response
             */    
            case 'created':
                $result = \Cache::remember('tascrea', 15/60, function () {
                    global $target;
                    return Task::orderBy('_id', 'ASC')
                                ->where('created_at','=', $target)
                            //    ->where('created_at', 'like', $target.'%')
                                ->simplePaginate(5);
                });
                break;
             /**
             * Display a listing of tasks, filter by updated_at.
             *
             * @return \Illuminate\Http\Response
             */    
            case 'updated':
                $result = \Cache::remember('tasupd', 15/60, function () {
                    global $target;
                    return Task::orderBy('_id', 'ASC')
                                ->where('updated_at','=', $target)
                                ->simplePaginate(5);
                });      
                break;
        }
                  
        if ($result) {
            return response()->json(['status'=>'ok','data'=>$result], 200);
            }
        else {     
            return response()->json(['errors'=>array(
                ['code'=>400,'message'=>' The request is malformed '])],400); 
            } 

    } 

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request\Cache::Put(     
     * @return \I)lluminate\Http\Response
     */
    public function saveTask(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',            
            'description' => '',
            'due_date' => 'required',
            'completed' => ''
        ]);

        //with inyection
        //$task = Task::create($request->all());
        //without inyection  
        $task = new Task();
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        //////////////// Updated ISO8601 ////////////////////
        $task->due_date = $this->toIsoDate8601($request->get('due_date'));
        /////////////////////// Updated Boolean ////////////////////////
        $task->completed = $this->toBoolean($request->get('completed'));   

        $task->save();

        $this->forgetCache();

        return response()->json($task, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showTask(Task $task)
    {
        //
        
        return $task;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updateTask(Request $request, Task $task)
    {
        //
        $this->validate($request, [
            'title' => 'required',            
            'description' => '',
            'due_date' => 'required',
            'completed' => ''
        ]);

        //with inyection
        //$task->update($request->all());
        //without inyection  
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        //////////////// Updated ISO8601 ////////////////////
        $task->due_date = $this->toIsoDate8601($request->get('due_date')); 
        /////////////////////// Updated Boolean ////////////////////////
        $task->completed = $this->toBoolean($request->get('completed'));   

        $task->save();
        //
        $this->forgetCache(); 

        return response()->json($task, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function deleteTask(Task $task)
    {
        //
        $task->delete();

        $this->forgetCache();

        return response()->json(null, 204);
    }

    /**
     * Convert string date a ISODate8601 (mongo datetime)
     *
     * @return ISODate8601
     */
    public function toIsoDate8601($date)
    {
        $datetime = new \DateTime($date);
        
        return $datetime->format(\DateTime::ATOM);
    }

    /**
     * Convert to boolean var
     *
     * @return boolean
     */
    public function toBoolean($bool)
    {
       if ($bool == 1 Or $bool == true Or $bool == 'true')
            {
                $bool = true;
            } else {
                   $bool = false;
            } 
        return (bool)$bool;
    }


    /**
     * Inicialize cached variables.
     *
     * @return none
     */
    public function forgetCache(){
        if (\Cache::has('index')) {
            \Cache::forget('index'); 
        }
        if (\Cache::has('tascom')) {
            \Cache::forget('tascom'); 
        }
        if (\Cache::has('tasuncom')) {
            \Cache::forget('tasuncom'); 
        }
    }

    /**
     * *** *** *** *** *** *** *** *
     * Methods with web UI    *
     * *** *** *** *** *** *** *** *
     * @return views
     */
    public function create()
    {
        return view('taskcreate');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',            
            'due_date' => 'required'
        ]);     
        //with inyection
        //$task = Task::create($request->all());
        //without inyection  
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        //////////////// Updated ISO8601 ////////////////////
        $task->due_date = $this->toIsoDate8601($request->get('due_date'));
        /////////////////////// Updated Boolean ////////////////////////
        $task->completed = $this->toBoolean($request->get('completed'));         

        $task->save();

        return redirect('task')->with('success', 'Task has been successfully added');
    }

    public function index()
    {
        $tasks=Task::all();
        
        return view('taskindex',compact('tasks'));
    }

    public function edit($id)
    {
        $task = Task::find($id);
        return view('taskedit',compact('task','id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'due_date' => 'required',
        ]);
        $task= Task::find($id);
        //with inyection
        //$task->update($request->all());
        //without inyection  
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        //////////////// Updated ISO8601 ////////////////////
        $task->due_date = $this->toIsoDate8601($request->get('due_date')); 
        /////////////////////// Updated Boolean ////////////////////////
        $task->completed = $this->toBoolean($request->get('completed')); 

        $task->save();
        
        return redirect('task')->with('success', 'Task has been successfully update');
    }
    
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect('task')->with('success','Task has been  deleted');
    }

 /**
     * Run the database seeds.
     *
     * @return void
     */
    public function seed()
    {
        //
        
        for ($i=0; $i<50; $i++)
        {
            $task = new Task();
            $task->title = 'Title'.(string)$i;
            $task->description = 'description'.(string)$i;
            //////////////// Updated ISO8601 ////////////////////
            $task->due_date = $this->toIsoDate8601('2018-08-11');
            /////////////////////////////////////////////////////       
            $task->completed = false;   

            $task->save();
        }

        return response()->json(['status'=>'ok','data'=>$task], 200);
    }

}
