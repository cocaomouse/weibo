<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'content' => 'required|max:140'
        ]);

        //当前用户实例引用User模型中到statuses()方法,在Status模型中生成新数据
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success','发布成功!');
        return redirect()->back();
    }


    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除!');
        return redirect()->back();
    }
}
