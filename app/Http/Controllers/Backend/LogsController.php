<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Logs;
use Helper, File, Session, Auth, DB;
use Maatwebsite\Excel\Facades\Excel;

class LogsController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $paramArr['user_id'] = $user_id = isset($request->user_id) ? $request->user_id : null;    
        $paramArr['action'] = $action = isset($request->action) ? $request->action : null;
        $paramArr['type'] = $type = isset($request->type) ? $request->type : null;
        $paramArr['object_id'] = $object_id = isset($request->object_id) ? $request->object_id : null;

        $query = Logs::whereRaw('1');
        
        if( $user_id ){
            $query->where('user_id', $user_id);
        }
        if( $action ){
            $query->where('action', $action);
        }
        if( $type ){
            $query->where('type', $type);
        }
        if( $object_id ){
            $query->where('object_id', $object_id);
        }
        
        $items = $query->orderBy('id', 'desc')->paginate(50);
        
        return view('backend.logs.index', compact( 'items', 'paramArr'));
    }    
    public function create(Request $request)
    {
        return view('backend.logs.create');
    }
    public function updateStatus(Request $request)
    {
        $dataArr = $request->all();
        foreach($dataArr['customer_id'] as $customer_id){
            Logs::find($customer_id)->update([$dataArr['change_column'] => $dataArr['change_value']]);
            Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 3, // update nhieu don hang
            'type' => 3,
            'object_id' => $customer_id,
            'new_data' => $customer_id, 
            ]);
        }
        
        Session::flash('message', 'Xóa thành công');        
        return redirect()->route('logs.index', json_decode($dataArr['backParam'], true) );
    } 

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[                                    
            'name' => 'required',
            'phone' => 'required|unique:customer',           
        ],
        [                                    
            'name.required' => 'Bạn chưa nhập họ tên khách',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.unique' => 'Số điện thoại này đã tồn tại trong hệ thống',
        ]);        
        $dataArr['created_user'] = Auth::user()->id;        
        $dataArr['updated_user'] = Auth::user()->id;        
        $rs = Logs::create($dataArr);
        $customer_id = $rs->id;
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 1,
            'type' => 3,
            'object_id' => $customer_id,
            'new_data' => json_encode($dataArr), 
            ]);
        return redirect()->route('orders.create', ['customer_id' => $customer_id]);
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */    

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $tagSelected = [];

        $detail = Logs::find($id);

        return view('backend.logs.edit', compact('detail'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[                                    
            'name' => 'required',
            'phone' => 'required|unique:customer,phone,'.$dataArr['id']
        ],
        [
            'name.required' => 'Bạn chưa nhập họ tên khách',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.unique' => 'Số điện thoại này đã tồn tại trong hệ thống',
        ]);        
                
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = Logs::find($dataArr['id']);
        $model->update($dataArr);
        Session::flash('message', 'Cập nhật thành công');        
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 2,
            'type' => 3,
            'object_id' => $dataArr['id'],
            'old_data' => json_encode($model->toArray()),
            'new_data' => json_encode($dataArr), 
            ]);
        return redirect()->route('logs.edit', $dataArr['id']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = Logs::find($id);
        $model->delete();
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 3,
            'type' => 3,
            'object_id' => $id          
            ]);
        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('logs.index');
    }
}
