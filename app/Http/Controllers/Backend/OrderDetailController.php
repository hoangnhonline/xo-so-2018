<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\OrderDetailHistory;
use App\Models\Loai;
use App\Models\Kieu;
use App\Models\Mau;
use App\Models\Size;
use App\Models\FormStatus;
use App\Models\FormOk;
use App\Models\Staff;
use App\Models\Logs;

use Helper, File, Session, Auth, Image, DB;

class OrderDetailController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    
    public function index(Request $request)
    {   
        
        $order_id = isset($request->order_id) ? $request->order_id : null;
        if(!$order_id){
            return redirect()->route('orders.index');
        }
        $orderInfo = Orders::find($order_id);

        $detailList = $orderInfo->orderDetails;
        $backUrl = null;
        if($request->backParam){
            $backUrl = route('orders.index', json_decode($request->backParam, true));
        }
        
        return view('backend.orders-detail.index', compact( 'detailList', 'orderInfo', 'backUrl'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        
        $order_id = isset($request->order_id) ? $request->order_id : null;
        if(!$order_id){
            return redirect()->route('orders.index');
        }
        $orderInfo = Orders::find($order_id);
        $loaiList = Loai::all();
        $colorList = Mau::all();
        $sizeList = Size::all();
        $kieuList = Kieu::all();
        $formStatusList = FormStatus::all();
        $formOkList = FormOk::all();       

        $staffArr = Staff::getListStaff(1);        
        $staffNhanArr = Staff::getListStaff(2);
        $staffDinhArr = Staff::getListStaff(3);
        
        return view('backend.orders-detail.create', compact( 'orderInfo', 'order_id', 'loaiList',
            'colorList', 'kieuList', 'sizeList', 'formStatusList', 'formOkList', 'staffDinhArr', 'staffArr', 'staffNhanArr'
        ));
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
            'loai_id' => 'required',            
            'product_code' => 'required',
            'price' => 'required',
            'number_product' => 'required',
            'total_price' => 'required',
            'ngay_giao' => 'required',           
        ],
        [            
            'loai_id.required' => 'Bạn chưa chọn loại sản phẩm',            
            'product_code.required' => 'Bạn chưa nhập mã sản phẩm',
            'price.required' => 'Bạn chưa nhập giá',
            'number_product.required' => 'Bạn chưa nhập số lượng',          
            'total_price.required' => 'Bạn chưa nhập thành tiền',
            'ngay_giao.required' => 'Bạn chưa nhập ngày giao',
        ]);        
        
        $dataArr['ngay_giao'] = date('Y-m-d', strtotime($dataArr['ngay_giao']));
        $dataArr['total_price'] = str_replace(',', '', $request->total_price);
        $dataArr['price'] = str_replace(',', '', $request->price);

        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;
        
        $rs = OrderDetail::create($dataArr);
        
        Session::flash('message', 'Thêm sản phẩm thành công');
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 1,
            'type' => 2,
            'object_id' => $rs->id,
            'new_data' => json_encode($dataArr), 
            ]);
        $this->history($rs->id, $dataArr['ngay_giao']);
        $ngay_giao_max = DB::table('order_detail')->where('status', 1)->where('order_id', $rs->order_id)->select('ngay_giao')->max('ngay_giao');
        $ngay_giao_min = DB::table('order_detail')->where('status', 1)->where('order_id', $rs->order_id)->select('ngay_giao')->min('ngay_giao');

        $tong_tien = DB::table('order_detail')->where('status', 1)->where('order_id', $rs->order_id)->sum('total_price');
        $total_product = DB::table('order_detail')->where('status', 1)->where('order_id', $rs->order_id)->sum('number_product');          
        Orders::find($dataArr['order_id'])->update(['ngay_giao_max' => $ngay_giao_max, 'total_price' => $tong_tien, 'total_product' => $total_product, 'ngay_giao' => $ngay_giao_min]);

        return redirect()->route('orders-detail.index',['order_id' => $dataArr['order_id']]);
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

        $detail = OrderDetail::find($id);        
        $orderInfo = Orders::find($detail->order_id);
        $order_id = $detail->order_id;

        $loaiList = Loai::all();
        $colorList = Mau::all();
        $sizeList = Size::all();
        $kieuList = Kieu::all();
        $formStatusList = FormStatus::all();
        $formOkList = FormOk::all();       

        $staffArr = Staff::getListStaff(1);        
        $staffNhanArr = Staff::getListStaff(2);
        $staffDinhArr = Staff::getListStaff(3);
        return view('backend.orders-detail.edit', compact('detail', 'orderInfo', 'order_id','loaiList',
            'colorList', 'kieuList', 'sizeList', 'formStatusList', 'formOkList', 'staffDinhArr', 'staffArr', 'staffNhanArr'));
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
            'loai_id' => 'required',            
            'product_code' => 'required',
            'price' => 'required',
            'number_product' => 'required',
            'total_price' => 'required',
            'ngay_giao' => 'required',           
        ],
        [            
            'loai_id.required' => 'Bạn chưa chọn loại sản phẩm',            
            'product_code.required' => 'Bạn chưa nhập mã sản phẩm',
            'price.required' => 'Bạn chưa nhập giá',
            'number_product.required' => 'Bạn chưa nhập số lượng',          
            'total_price.required' => 'Bạn chưa nhập thành tiền',
            'ngay_giao.required' => 'Bạn chưa nhập ngày giao',
        ]);        
        
        $dataArr['ngay_giao'] = date('Y-m-d', strtotime($dataArr['ngay_giao']));
        $dataArr['total_price'] = str_replace(',', '', $request->total_price);
        $dataArr['price'] = str_replace(',', '', $request->price);        
        $dataArr['updated_user'] = Auth::user()->id;
        $model = OrderDetail::find($dataArr['id']);

        $model->update($dataArr);
        
        Session::flash('message', 'Cập nhật sản phẩm thành công');
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 2,
            'type' => 2,
            'object_id' => $dataArr['id'],
            'old_data' => json_encode($model->toArray()),
            'new_data' => json_encode($dataArr), 
            ]);
        $this->history($dataArr['id'], $dataArr['ngay_giao']);
        $rs = DB::table('order_detail')->where('status', 1)->where('order_id', $dataArr['order_id'])->select('ngay_giao')->max('ngay_giao');
         $ngay_giao_min = DB::table('order_detail')->where('status', 1)->where('order_id', $dataArr['order_id'])->select('ngay_giao')->min('ngay_giao');
        $tong_tien = DB::table('order_detail')->where('status', 1)->where('order_id', $dataArr['order_id'])->sum('total_price');  
        $total_product = DB::table('order_detail')->where('status', 1)->where('order_id', $dataArr['order_id'])->sum('number_product');         
        Orders::find($dataArr['order_id'])->update(['ngay_giao_max' => $rs, 'total_price' => $tong_tien, 'total_product' => $total_product, 'ngay_giao' => $ngay_giao_min]);
        return redirect()->route('orders-detail.index',['order_id' => $dataArr['order_id']]);
    }
    private function history($order_detail_id, $ngay_giao){
        $check = OrderDetailHistory::where('order_detail_id', $order_detail_id)->where('ngay_giao', $ngay_giao)->first();
        if(!$check){
            OrderDetailHistory::create(['order_detail_id' => $order_detail_id, 'ngay_giao' => $ngay_giao, 'status' => 1]);
        }

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
        $model = OrderDetail::find($id);            
        $model->update(['status' => 0]);
        OrderDetailHistory::where('order_detail_id', $id)->update(['status' => 0]);
        // redirect
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 3,
            'type' => 2,
            'object_id' => $id          
            ]);
        Session::flash('message', 'Xóa sản phẩm thành công');
        return redirect()->route('orders-detail.index', $model->order_id);
    }
}
