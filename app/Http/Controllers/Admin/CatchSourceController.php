<?php

namespace App\Http\Controllers\Admin;

use App\CatchSource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatchSourceController extends Controller
{
    //新建ip来源
    public function insert(Request $request)
    {
        if (isset($_REQUEST['submit'])) {
            $data = $request->all(['url', 'description', 'match_preg']);

            if (CatchSource::insert($data)) {
                return redirect()->action("Admin\CatchSourceController@store")->with(['status' => "添加成功"]);
            } else {
                return redirect()->action("Admin\CatchSourceController@store")->with(['status' => "添加失败"]);
            }
        } else {
            return view("admin.CatchSource.insert");
        }
    }

    //ip来源列表
    public function store(Request $request)
    {

        $handle = CatchSource::query();
        if (!empty($request->get("url"))) {
            $like = trim($request->get('url'));
            $handle->where("url", 'like', "%{$like}%");
        }

        $list = $handle->paginate(20);
        return view('admin.CatchSource.store', compact('list'));
    }

    //更新
    public function update(Request $request)
    {
        $id = $request->get("id");
        if ($id) {

            if (isset($_REQUEST['submit'])) {
                //提交
                $data = $request->all(['url', 'description', 'match_preg', 'status']);
                $data['updated_at'] = date("Y-m-d H:i:s");
                if (CatchSource::where("id", $id)->update($data)) {
                    return redirect()->action("Admin\CatchSourceController@store")->with(['status' => "success"]);
                } else {
                    return redirect()->action("Admin\CatchSourceController@store")->with(['status' => "error"]);
                }

            } else {
                //展示
                $catchSource = CatchSource::where("id", $id)->first();
                return view("admin.CatchSource.update", compact('catchSource'));
            }
        } else {
            return redirect()->action("Admin\CatchSourceController@store")->with(['status' => "id为空"]);
        }
    }


    //更新
    public function try_catch(Request $request)
    {
        $id = $request->get("id");
        if ($id) {
            $catchSource = CatchSource::where("id", $id)->first();
            if ($catchSource) {

                try {
                    $options = array('verify' => false); //不验证ssl
                    $request = \Requests::get($catchSource['url'], [], $options);
                    $str = $request->body;
                    if ($str) {
                        $match_res = preg_match_all($catchSource['match_preg'], $str, $match_ips);
                        if ($match_res) {

                            $match_ips = [];
                            //遍历资源
                            foreach ($match_ips[1] as $key => $match_ip) {
                                $match_ip = (isset($match_ips[2][$key]) && stripos($match_ip, ':') === false) ?
                                    $match_ip . ':' . $match_ips[2][$key] :
                                    $match_ip;
                                $match_ips[] = $match_ip;
                            }

                            return back()->with(['status' => "获取到ip数:[" . count($match_ips) . "]\n抽查一个ip:[" . $match_ips[0] . ']']);

                        } else {
                            new \Exception('没有匹配到数据');
                        }

                    }
                } catch (\Exception $exception) {
                    return back()->with(['status' => "抓取异常:" . substr($exception->getMessage(), 0, 500)]);
                }

            } else {
                return back()->with(['status' => "数据异常"]);
            }

        } else {
            return back()->with(['status' => "id为空"]);
        }
    }
}
