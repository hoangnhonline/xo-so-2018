<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Ordersx;
use App\Models\CateParent;
use App\Models\Cate;
use App\Models\Color;
use App\Models\FormStatus;
use App\Models\MetaData;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Method;
use App\Models\OrderDetail;
use App\Models\OrderDetailHistory;
use App\Models\Logs;
use App\Models\Customerx;

use Helper, File, Session, Auth, URL, Image, DB;

class OrdersController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */ 
    public function iform(Request $request)
    {
            $all = Ordersx::all();
            foreach($all as $order){
                
                Orders::find($order->id)->update(['not_form' => $order->not_form]);
            }

    }
    public function index(Request $request)
    {
        $paramArr['type'] = $type = isset($request->type) ? $request->type : 1;    
        $paramArr['order_status'] = $order_status = isset($request->order_status) ? $request->order_status : null;
        $paramArr['da_soan'] = $da_soan = isset($request->da_soan) ? $request->da_soan : null;
        $paramArr['customer_id'] = $customer_id = isset($request->customer_id) ? $request->customer_id : null;
        $paramArr['from_date'] = $from_date = isset($request->from_date) ? $request->from_date : date('d-m-Y') ;
        $paramArr['to_date'] = $to_date = isset($request->to_date) ? $request->to_date : null;                  
        if($type == 2){
            $paramArr['order_status'] = 1;
            $paramArr['from_date'] = null;
            $paramArr['to_date'] = date('Y-m-d', time());
        }  
        $items = Orders::getList($paramArr, $type);        
        $formStatusList = FormStatus::all();
        foreach($formStatusList as $formStatus){            
            $formStatusArr[$formStatus->id] = $formStatus;
        }
              
        $customerList = Customer::orderBy('id', 'desc')->get();       
        return view('backend.orders.index', compact( 'items', 'paramArr', 'formStatusArr', 'customerList'));
    }    
  
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $customer_id = isset($request->customer_id) ? $request->customer_id : null;  
        $paymentList = Payment::all();
        $methodList = Method::all();        
        $customerList = Customer::orderBy('id', 'desc')->get();  
        $backUrl = null;
        if($request->backParam){
            $backUrl = route('orders.index', json_decode($request->backParam, true));
        }
        return view('backend.orders.create', compact('customer_id', 'customerList', 'paymentList', 'methodList', 'backUrl'));
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
            'customer_id' => 'required',
            'ngay_dat' => 'required' ,
          //  'ngay_giao' => 'required' ,
            'tien_coc' => 'required' ,
            'method_id' => 'required' ,
            'payment_id' => 'required' ,                             
        ],
        [
            'customer_id.required' => 'Bạn chưa chọn khách hàng',
            'ngay_dat.required' => 'Bạn chưa nhập ngày đặt',
           // 'ngay_giao.required' => 'Bạn chưa nhập ngày giao',
            'tien_coc.required' => 'Bạn chưa nhập tiền cọc',
            'method_id.required' => 'Bạn chưa chọn hình thức',
            'payment_id.required' => 'Bạn chưa chọn phương thức thanh toán',
        ]);
       
        $dataArr['not_form'] = isset($dataArr['not_form']) ? 1 : 0;
        $dataArr['ngay_dat'] = date('Y-m-d', strtotime($dataArr['ngay_dat']));
        //$dataArr['ngay_giao'] = date('Y-m-d', strtotime($dataArr['ngay_giao']));
        $dataArr['tien_coc'] = str_replace(',', '', $request->tien_coc);
        $dataArr['total_price'] = str_replace(',', '', $request->total_price);
        
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;
        
        $rs = Orders::create($dataArr);

        $order_id = $rs->id;

        Session::flash('message', 'Tạo mới đơn hàng thành công');
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 1,
            'type' => 1,
            'object_id' => $order_id,
            'new_data' => json_encode($dataArr), 
            ]);        
        return redirect()->route('orders-detail.create',['order_id' => $order_id]);
    } 

    public function updateStatus(Request $request)
    {
        $dataArr = $request->all();
        foreach($dataArr['order_id'] as $order_id){
            Orders::find($order_id)->update([$dataArr['change_column'] => $dataArr['change_value']]);
        }
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 4, // update nhieu don hang
            'type' => 1,
            'object_id' => $order_id,
            'new_data' => json_encode($dataArr), 
            ]);
        Session::flash('message', 'Cập nhật thành công');        
        return redirect()->route('orders.index', json_decode($dataArr['backParam'], true) );
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
    public function edit($id, Request $request)
    {
        
        $detail = Orders::find($id);
        $paymentList = Payment::all();
        $methodList = Method::all();        
        $customerList = Customer::orderBy('id', 'desc')->get();   
        $backUrl = null;
        if($request->backParam){
            $backUrl = route('orders.index', json_decode($request->backParam, true));
        }
        return view('backend.orders.edit', compact( 'detail', 'paymentList', 'methodList', 'customerList', 'backUrl'));
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
            'customer_id' => 'required',
            'ngay_dat' => 'required' ,
            //'ngay_giao' => 'required' ,
            'tien_coc' => 'required' ,
            'method_id' => 'required' ,
            'payment_id' => 'required' ,                             
        ],
        [
            'customer_id.required' => 'Bạn chưa chọn khách hàng',
            'ngay_dat.required' => 'Bạn chưa nhập ngày đặt',
            //'ngay_giao.required' => 'Bạn chưa nhập ngày giao',
            'tien_coc.required' => 'Bạn chưa nhập tiền cọc',
            'method_id.required' => 'Bạn chưa chọn hình thức',
            'payment_id.required' => 'Bạn chưa chọn phương thức thanh toán',
        ]);
       
        $dataArr['not_form'] = isset($dataArr['not_form']) ? 1 : 0;
        $dataArr['ngay_dat'] = date('Y-m-d', strtotime($dataArr['ngay_dat']));
        //$dataArr['ngay_giao'] = date('Y-m-d', strtotime($dataArr['ngay_giao']));
        $dataArr['tien_coc'] = str_replace(',', '', $request->tien_coc);
        $dataArr['total_price'] = str_replace(',', '', $request->total_price);
        $dataArr['updated_user'] = Auth::user()->id;
            
        $model = Orders::find($dataArr['id']);

        $model->update($dataArr);
        
        $order_id = $dataArr['id'];
        
        Session::flash('message', 'Chỉnh sửa thành công');
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 2,
            'type' => 1,
            'object_id' => $order_id,
            'old_data' => json_encode($model->toArray()),
            'new_data' => json_encode($dataArr), 
            ]);
        if($request->backUrl != ''){
            return redirect($request->backUrl);
        }
        return redirect()->route('orders.edit', $order_id);
        
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
        $model = Orders::find($id);        
        $model->update(['status' => 0]);        
        OrderDetail::where('order_id', $id)->update(['status' => 0]); 
        // redirect
        Session::flash('message', 'Xóa đơn hàng thành công');
        Logs::create([
            'user_id' =>  Auth::user()->id,
            'action' => 3,
            'type' => 1,
            'object_id' => $id          
            ]);
        return redirect(URL::previous());//->route('orders.short');
        
    }
}
