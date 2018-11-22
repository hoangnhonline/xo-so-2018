<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Models\CateParent;
use Helper, File, Session, Auth;

class SizeController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {              
        $items = Size::orderBy('display_order')->get();

        return view('backend.size.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        return view('backend.size.create');
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
            'name' => 'required|unique:size,name'
        ],
        [
            'name.required' => 'Bạn chưa nhập size',
            'name.unique' => 'Size đã tồn tại',           
        ]);
        
        $dataArr['display_order'] = Helper::getNextOrder('size');
      
        Size::create($dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('size.index');
    }

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
        $detail = Size::find($id);

        return view('backend.size.edit', compact( 'detail' ));
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
            'name' => 'required|unique:size,name,'.$dataArr['id'],          
        ],
        [
            'name.required' => 'Bạn chưa nhập size',
            'name.unique' => 'Size đã tồn tại',
        ]);

        $model = Size::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('size.edit', $dataArr['id']);
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
        $model = Size::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('size.index');
    }
}
