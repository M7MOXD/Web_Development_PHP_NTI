<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class taskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Task::join('persons', 'persons.id', '=', 'tasks.add_by');
        return view('task.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|max:50',
            'image' => 'required|image',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:tomorrow'
        ]);
        $data['add_by'] = auth()->user()->id;
        $data['start_date'] = strtotime($data['start_date']);
        $data['end_date'] = strtotime($data['end_date']);
        $data['image'] = time().rand().'.'.$request->image->extension();
        $op = Task::create($data);
        if ($op) {
            $message = 'Row Inserted';
            $request->image->move(public_path('/uploads'), $data['image']);
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('task'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Task::find($id);
        return view('task.edit', ['data' => $data]);
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
        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|max:50',
            'image' => 'nullable|image',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:tomorrow'
        ]);
        $row = Task::find($id);
        if ($request->hasFile('image')) {
            $data['image'] = time().rand().'.'.$request->image->extension();
            if ($request->image->move(public_path('/uploads'), $data['image'])) {
                unlink(public_path('uploads/'.$row->image));
            }
        }
        $data['start_date'] = strtotime($data['start_date']);
        $data['end_date'] = strtotime($data['end_date']);
        $op = Task::where('id', $id)->update($data);
        if ($op) {
            $message = 'Row Updated';
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('task'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $op = Task::where('id',$id)->delete();
        if($op){
            $message = "Raw Removed";
        }else{
            $message = "Error Try Again";
        }
         session()->flash('message', $message);
         return redirect(url('task'));
    }
}
