<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blogController extends Controller
{
    public function blog(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|max:50',
            'image' => 'required|image'
        ]);
        $image = $request->file('image');
        $imgName = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/uploads');
        $image->move($destinationPath, $imgName);
        $_SESSION['blog'] = $request->all();
        $_SESSION['blog']['imgName'] = $imgName;
        return view('vBlog');
    }
}
