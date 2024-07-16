<?php

namespace Leo\Bills\Controllers;

use Leo\Bills\Models\Bills;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Leo\Carts\Models\Carts;
use Inertia\Inertia;
use Leo\Bills\Models\Bill_Detail;
use Illuminate\Support\Facades\Validator;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bills::with(['details.product'])
        ->get()
        ->map(function ($bill) {
            $total = $bill->details->reduce(function ($carry, $detail) {
                $productDiscount = $detail->product->discount;
                $quantity = $detail->quantity;
                return $carry + ($productDiscount * $quantity);
            }, 0);
            $bill->total = $total;
            return $bill;
        });
        return Inertia::render("Bills/Index",['bills'=>$bills]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'cart'=>'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['check'=>false , 'msg' => $validator->errors()->first()], 200);
        }
        $data=[];
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $data['address']=$request->address;
        $id_hoa_don = Bills::insertGetId($data);
        foreach ($request->cart as $key => $item) {
            Bill_Detail::create(['id_hoa_don'=>$id_hoa_don,'id_product'=>$item[0],'quantity'=>$item[1]]);
        }
        return response()->json(['check'=>true]);
    }

    public function store2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'id_customer'=>'required|exists:customers,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['check'=>false , 'msg' => $validator->errors()->first()], 200);
        }
        $data= [];
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $data['address']=$request->address;
        $id_hoa_don = Bills::insertGetId($data);
        $cart= Carts::where('id_customer',$request->id_customer)
        ->select('id_product','quantity')
        ->get();
        foreach ($cart as $key => $value) {
            Bill_Detail::create(['id_hoa_don'=>$id_hoa_don,'id_product'=>$value->id_product,'quantity'=>$value->quantity,'created_at'=>now()]);
        }
        Carts::where('id_customer',$request->id_customer)->delete();
        return response()->json(['check'=>true]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Bills $bills,$id)
    {
        $bill = Bills::with('details.product')->find($id);
        $total = $bill->details->sum(function($detail) {
            return $detail->quantity * $detail->product->price;
        });
       $billList = Bill_Detail::with(['product','product.gallery'])->where('hoa_don_chi_tiet.id_hoa_don',$id)->select()->get();
       return Inertia::render("Bills/Detail",['total'=>$total,'bill'=>$bill,'billList'=>$billList]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bills $bills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bills $bills,$id)
    {
        $bill= Bills::where('id',$id)->first();
        if(!$bill){
            return response()->json(['check'=>false,'msg'=>'Không tìm thấy mã hóa đơn']);
        }
        $data=$request->all();
        $data['updated_at']=now();
        Bills::where('id',$id)->update($data);
        $bill = Bills::with('details.product')->find($id);
        $total = $bill->details->sum(function($detail) {
            return $detail->quantity * $detail->product->price;
        });
        $billList = Bill_Detail::with(['product','product.gallery'])->where('hoa_don_chi_tiet.id_hoa_don',$id)->select()->get();
        return response()->json(['check'=>true,'bill'=>$bill,'total'=>$total,'billList'=>$billList]);
    }
    // ============================================
    public function return (Request $request){
        $url = session('url_prev','/');
        if($request->vnp_ResponseCode == "00") {
            $this->apSer->thanhtoanonline(session('cost_id'));
            return redirect($url)->with('success' ,'Đã thanh toán phí dịch vụ');
        }
        session()->forget('url_prev');
        return redirect($url)->with('errors' ,'Lỗi trong quá trình thanh toán phí dịch vụ');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function vnpay(Request $request,Bills $bills)
    {
        $vnp_TmnCode = "JPYX2RJF"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "OZ8LAHQWCQHK3HIAI30VURVJ6CHM23CI"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
        $vnp_TxnRef = rand(1,10000);
        $vnp_Amount = 20000000; // Số tiền thanh toán
        $vnp_Locale = 'vi'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = "QR"; //Mã phương thức thanh toán
        $vnp_IpAddr = '13.160.92.202'; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount* 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:". $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        dd($vnp_Url);
        header('Location: ' . $vnp_Url);
    }

}
