<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class personController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Person::get();
        return view('person.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('person.create');
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:persons',
            'password' => ['required', Password::min(6)->mixedCase()]
        ]);
        $data['password'] = bcrypt($data['password']);
        $op = Person::create($data);
        if ($op) {
            $message = 'Row Inserted';
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('person'));
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
        $data = Person::find($id);
        return view('person.edit', ['data' => $data]);
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
            'name' => 'required|min:3',
            'email' => 'required|email',
        ]);
        $op = Person::where('id', $id)->update($data);
        if ($op) {
            $message = 'Row Updated';
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('person'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $op = Person::where('id',$id)->delete();
        if($op){
            $message = "Raw Removed";
            return redirect(url('person'));
        }else{
            $message = "Error Try Again";
        }
        session()->flash('message', $message);
        return redirect(url('person'));
    }

    public function login()
    {
        return view('person.login');
    }

    public function loging(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (auth()->attempt($data)) {
            return redirect(url('person'));
            auth()->attempt($request->all());
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('login'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect(url('login'));
    }
}
