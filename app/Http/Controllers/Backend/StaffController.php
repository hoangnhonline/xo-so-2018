<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Logs;
use Helper, File, Session, Auth;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $query = Staff::where('status', 1);        
        
        $items = $query->orderBy('id', 'desc')->paginate(20);
        
        return view('backend.staff.index', compact( 'items', 'keyword'));
    }    
    public function create(Request $request)
    {
        return view('backend.staff.create');
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
            'short_name' => 'required',                     
        ],
        [                                    
            'short_name.required' => 'Bạn chưa nhập tên ngắn nhân viên',
        ]);        
        $dataArr['created_user'] = Auth::user()->id;        
        $dataArr['updated_user'] = Auth::user()->id;        
        $rs = Staff::create($dataArr);
        $customer_id = $rs->id;
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 1,
            'type' => 4, // staff
            'object_id' => $customer_id,
            'new_data' => json_encode($dataArr), 
            ]);
        return redirect()->route('staff.index');
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

        $detail = Staff::find($id);

        return view('backend.staff.edit', compact('detail'));
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
            'short_name' => 'required',            
        ],
        [
            'short_name.required' => 'Bạn chưa nhập tên ngắn nhân viên'
        ]);        
                
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = Staff::find($dataArr['id']);
        $model->update($dataArr);
        Session::flash('message', 'Cập nhật thành công');        
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 2,
            'type' => 4,//staff
            'object_id' => $dataArr['id'],
            'old_data' => json_encode($model->toArray()),
            'new_data' => json_encode($dataArr), 
            ]);
        return redirect()->route('staff.index');
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
        $model = Staff::find($id);
        $model->update(['status' => 0]);
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 3,
            'type' => 4,
            'object_id' => $id          
            ]);
        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('staff.index');
    }
}
