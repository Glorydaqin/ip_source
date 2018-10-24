<?php

namespace App\Http\Controllers\Admin;

use App\Competitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CompetitorController extends Controller
{
    //新建
    public function insert(Request $request)
    {
        if(isset($_REQUEST['submit'])){
            $data = $request->all(['name','url','flag','min_num']);

            if(Competitor::insert($data)){
                return redirect()->action("Admin\CompetitorController@store")->with(['status'=>"添加成功"]);
            }else{
               return redirect()->action("Admin\CompetitorController@store")->with(['status'=>"添加失败"]);
            }
        }else{
            return view("admin.Competitor.insert");
        }
    }

    //验证网站列表
    public function store()
    {
        $handle = Competitor::query();
        if(!empty(Input::get("url"))){
            $like = trim(Input::get('url'));
            $handle->where("url",'like',"%{$like}%");
        }

        $list = $handle->paginate(20);
        return view('admin.Competitor.store',compact('list'));
    }

    //更新
    public function update(Request $request)
    {
        $id = $request->get("id");
        if($id){

            if(isset($_REQUEST['submit'])){
                //提交
//                dd(Input::get(['name','url','flag','min_num','status']));
                $data = $request->all(['name','url','flag','min_num','status']);
                $data['updated_at'] = date("Y-m-d H:i:s");
                if( Competitor::where("id",$id)->update($data) ){
                    return redirect()->action("Admin\CompetitorController@store")->with(['status'=>"success"]);
                }else{
                    return redirect()->action("Admin\CompetitorController@store")->with(['status'=>"error"]);
                }

            }else{
                //展示
                $competitor = Competitor::where("id",$id)->first();
                return view("admin.Competitor.update",compact('competitor'));
            }
        }else{
            return redirect()->action("Admin\CompetitorController@store")->with(['status'=>"id为空"]);
        }
    }
}
