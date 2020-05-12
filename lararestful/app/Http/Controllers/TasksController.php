<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\TasksResource;
use App\Tasks;
use App\Http\Requests;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp = Tasks::all();
        return TasksResource::collection($emp);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $emp = new Tasks;
        $emp->task = $request->input('task');
        $emp->description = $request->input('description');
        $emp->status = $request->input('status');
        $emp->save();
        return new TasksResource($emp);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $article = Tasks::find($id); //id comes from route
        if( $article ){
            return new TasksResource($article);
        }
        return "Tasks Not found"; // temporary error
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
        $emp = Tasks::find($id);
        $emp->task = $request->input('task');
        $emp->description = $request->input('description');
        $emp->status = $request->input('status');
        $emp->save();
        return new TasksResource($emp);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = Tasks::findOrfail($id);
        if($emp->delete()){
            return  new TasksResource($emp);
        }
        return "Error while deleting";
    }
}