<?php

namespace App\Http\Controllers;

use App\Models\adminModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class adminController extends Controller
{
    public function index()
    {
        $data = adminModel::get();
        return view('user.index', ['data' => $data]);
    }

    public function create()
    {
        return view('user.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name"   => "required|min:3",
            "email"  => "required|email|unique:admin",
            "password" => ["required", Password::min(6)->mixedCase()]
        ]);
        $data['password'] = bcrypt($data['password']);
        $op = adminModel::create($data);
        if ($op) {
            $message = 'Row Inserted';
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('users'));
    }

    public function update($id)
    {
        $data = adminModel::find($id);
        return view('user.update', ['data' => $data]);
    }

    public function save(Request $request, $id)
    {
        $data = $request->validate([
            "name"   => "required|min:3",
            "email"  => "required|email"
        ]);
        $op = adminModel::where('id', $id)->update($data);
        if ($op) {
            $message = 'Row Updated';
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('users'));
    }

    public function delete($id)
    {
        $op = adminModel::where('id', $id)->delete();
        if ($op) {
            $message = 'Row Deleted';
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('message', $message);
        return redirect(url('users'));
    }

    public function login()
    {
        return view('user.login');
    }

    public function loging(Request $request)
    {
        $data = $request->validate([
            "email"   => "required|email",
            "password" => ["required",Password::min(6)->letters()]
        ]);
        if (auth()->attempt($data)) {
            return redirect(url('users'));
        } else{
            session()->flash('message', 'Worng Email or Password');
            return redirect(url('login'));
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect(url('login'));
    }
}
