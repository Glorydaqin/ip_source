<?php

namespace App\Http\Controllers\Admin;

use App\CatchSource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class CatchSourceController extends Controller
{
    //新建ip来源
    public function insert(Request $request)
    {
        if(isset($_REQUEST['submit'])){
            $data = $request->all(['url','description','match_preg']);

            if(CatchSource::insert($data)){
                return redirect()->action("Admin\CatchSourceController@store")->with(['status'=>"添加成功"]);
            }else{
                return redirect()->action("Admin\CatchSourceController@store")->with(['status'=>"添加失败"]);
            }
        }else{
            return view("admin.CatchSource.insert");
        }
    }

    //ip来源列表
    public function store()
    {

        $handle = CatchSource::query();
        if(!empty(Input::get("url"))){
            $like = trim(Input::get('url'));
            $handle->where("url",'like',"%{$like}%");
        }

        $list = $handle->paginate(20);
        return view('admin.CatchSource.store',compact('list'));
    }

    //更新
    public function update(Request $request)
    {
        $id = $request->get("id");
        if($id){

            if(isset($_REQUEST['submit'])){
                //提交
//                dd(Input::get(['name','url','flag','min_num','status']));
                $data = $request->all(['url','description','match_preg','status']);
                $data['updated_at'] = date("Y-m-d H:i:s");
                if( CatchSource::where("id",$id)->update($data) ){
                    return redirect()->action("Admin\CatchSourceController@store")->with(['status'=>"success"]);
                }else{
                    return redirect()->action("Admin\CatchSourceController@store")->with(['status'=>"error"]);
                }

            }else{
                //展示
                $catchSource = CatchSource::where("id",$id)->first();
                return view("admin.CatchSource.update",compact('catchSource'));
            }
        }else{
            return redirect()->action("Admin\CatchSourceController@store")->with(['status'=>"id为空"]);
        }
    }
}
