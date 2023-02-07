<?php

namespace App\Http\Controllers\Sales;

use App\Abstracts\Http\Controller;
use App\Exports\Sales\Customers as Export;
use App\Http\Requests\Common\Contact as Request;
use App\Http\Requests\Common\Import as ImportRequest;
use App\Imports\Sales\Customers as Import;
use App\Jobs\Common\CreateContact;
use App\Jobs\Common\DeleteContact;
use App\Jobs\Common\UpdateContact;
use App\Models\Banking\Transaction;
use App\Models\Common\Contact;
use App\Models\Document\Document;
use App\Models\Setting\Currency;
use App\Traits\Currencies;
use Date;
use DB;
use Illuminate\Http\Request as BaseRequest;

class Customers extends Controller
{
    use Currencies;
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $customers = Contact::with('invoices.transactions')->customer()->collect();

        return $this->response('sales.customers.index', compact('customers'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param  Contact  $customer
     *
     * @return Response
     */
    public function show(Contact $customer)
    {
        $amounts = [
            'paid' => 0,
            'open' => 0,
            'overdue' => 0,
        ];

        $counts = [];

        // Handle invoices
        $invoices = Document::invoice()->with('transactions')->where('contact_id', $customer->id)->get();

        $counts['invoices'] = $invoices->count();

        $today = Date::today()->toDateString();
        
        $today = '2222-01-17';
        

        foreach ($invoices as $item) {
            // Already in transactions
            if ($item->status == 'paid') {
                continue;
            }

            $transactions = 0;

            foreach ($item->transactions as $transaction) {
                $transactions += $transaction->getAmountConvertedToDefault();
            }

            // Check if it's open or overdue invoice
            if ($item->due_at > $today) {
                $amounts['open'] += $item->getAmountConvertedToDefault() - $transactions;
            } else {
                $amounts['overdue'] += $item->getAmountConvertedToDefault() - $transactions;
            }
        }

        // Handle transactions
        $transactions = Transaction::with('category')->where('contact_id', $customer->id)->income()->get();

        $counts['transactions'] = $transactions->count();

        // Prepare data
        $transactions->each(function ($item) use (&$amounts) {
            $amounts['paid'] += $item->getAmountConvertedToDefault();
        });

        $limit = request('limit', setting('default.list_limit', '25'));
        $transactions = $this->paginate($transactions->sortByDesc('paid_at'), $limit);
        $invoices = $this->paginate($invoices->sortByDesc('issued_at'), $limit);

        return view('sales.customers.show', compact('customer', 'counts', 'amounts', 'transactions', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $currencies = Currency::enabled()->pluck('name', 'code');

        return view('sales.customers.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateContact($request));

        if ($response['success']) {
            $response['redirect'] = route('customers.index');

            $message = trans('messages.success.added', ['type' => trans_choice('general.customers', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('customers.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Duplicate the specified resource.
     *
     * @param  Contact  $customer
     *
     * @return Response
     */
    public function duplicate(Contact $customer)
    {
        $clone = $customer->duplicate();

        $message = trans('messages.success.duplicated', ['type' => trans_choice('general.customers', 1)]);

        flash($message)->success();

        return redirect()->route('customers.edit', $clone->id);
    }
    
    public function report(Contact $customer){
        
       // $currency_code = '$';
        
        
       $textQuantity =  setting('invoice.quantity_name');
       $textPrice = setting('invoice.price_name');
      
        
        $stdate = date("d M Y",strtotime("-1 month"));
        $edate = date("d M Y", time());
        
        $adtime = 86400;
       // $adtime = 0;
        
        $edatval = date("d M Y", time() + $adtime);
        
        if (request()->isMethod('post')) {
            
            $stval = $_POST["st_date"];
            $edval = $_POST["end_date"];
            if(strtotime($edval) > strtotime($stval)){
                $stdate = date("d M Y",strtotime($stval));
                $edate = date("d M Y", strtotime($edval));
                $edatval = date("d M Y", strtotime($edval) + $adtime);
            }
            
        }
        
        $dbstdate = date("Y-m-d", strtotime($stdate));
        $dbeddate = date("Y-m-d", strtotime($edatval));
        
        
        
      
        
        $amounts = [
            'paid' => 0,
            'open' => 0,
            'overdue' => 0,
        ];

        $counts = [];

        // Handle invoices
        //$invoices = Document::invoice()->with('transactions')->where('contact_id', $customer->id)->get();

//2021-11-11
        
        $invoicamt = 0;
        $transamt = 0;
        
        $prvinvoice = 0;
        $prvamt = 0;
        $amttotal = 0;
        //get all invoice
        //$invoices = Document::invoice()->where('contact_id', $customer->id)->get();
        $invoices = Document::invoice()->with('transactions')->where('contact_id', $customer->id)->get();
        
        $datarow = array();
        
        $invoicstr = trans('general.invoice', ['Invoice']);
        $transstr = trans('general.transaction', ['Transaction']);
        $openbalstr = trans('general.open_balance', ['open_balance']);
        $closbalstr = trans('general.close_balance', ['close_balance']);

        foreach ($invoices as $item) {
            if(strtotime($item->created_at) >= strtotime($stdate) && strtotime($item->created_at) <= strtotime($edatval)){
                $invoicamt = $invoicamt + $item->amount;
                
                $noteitem = DB::table('documents')->where('id', $item->id)->where('deleted_at', null)->first();
                $notes = '';
                
                if($noteitem != null){
                    $notes = $noteitem->notes;
                }
                
                $detamt = $item->amount;
                $paidamtcur = 0;
                foreach ($item->transactions as $transaction) {
                    $paidamtcur = $paidamtcur + $transaction->amount;
                }
                
                //$detstr = "$".$detamt;
                $detstr = $detamt;
                
                $paidstr = "";
                if($paidamtcur > 0)
                {
                    /*$paidstr = '$'.$paidamtcur;
                    $detstr =  $detamt - $paidamtcur;
                    $detstr = "$".$detstr;*/
                    
                    $paidstr = $paidamtcur;
                    $detstr =  $detamt - $paidamtcur;
                    $detstr = $detstr;
                }
                
                
                $amttotal = $amttotal - $item->amount;
                
                $allitems = DB::table('document_items')->where('document_Id', $item->id)->where('deleted_at', null)->get();
                
                $productnames = "";
                $productsqty = "";
                $productsunit = "";
                $productmeausre = "";
                $productprice = "";
                
                $init = 0;
                
                foreach($allitems as $citem)
                {
                   // $ndata =  array('date' => '', 'document' => "", 'description' => $citem->name . ': $'.$citem->price , 'val' => '',  'balance' => '');
                    //array_push($datarow, $ndata);
                    if($init == 0){
                        $productnames = $citem->name;
                        $productsqty = //intval($citem->quantity);
                        $productsqty = $citem->quantity;
                        $productsunit = $citem->product_unit;
                        $productmeausre = $citem->meter_square;
                        $productprice = $citem->price;
                        $init = 1;
                    }else{
                        $productnames = $productnames . "@_@_@" . $citem->name;
                        $productsqty = $productsqty . "@_@_@" . intval($citem->quantity);
                        $productsunit = $productsunit . "@_@_@" . intval($citem->product_unit);
                        $productmeausre = $productmeausre . "@_@_@" . $citem->meter_square ;
                        $productprice = $productprice . "@_@_@" . $citem->price;
                         //$productnames = $productnames. "<p>" . $citem->name .'</p>' ;
                    }
                    
                }
                
                $ndata =  array('inv_no' => $item->document_number, 'date' => $item->issued_at, 'document' => $invoicstr, 'products' => $productnames, 'qty' => $productsqty, 'unit' => $productsunit, 'measure' => $productmeausre, 'price' => $productprice,  'val' => '$'.$item->amount, 'description' => $notes ,  'balance' => '', 'paidamtcur' => $paidstr, 'detstr' => $detstr);
                array_push($datarow, $ndata);
                
                
            }
            
            if(strtotime($item->created_at) <= strtotime($stdate) ){
                $prvinvoice = $prvinvoice + $item->amount;
            }
            
            foreach ($item->transactions as $transaction) {
                //$transactions += $transaction->getAmountConvertedToDefault();
                
                if(strtotime($transaction->paid_at) >= strtotime($stdate) && strtotime($transaction->paid_at) <= strtotime($edatval)){
                    $transamt = $transamt + $transaction->amount;
                    
                    $ndata =  array('inv_no' => '','date' => $transaction->paid_at, 'document' => $transstr, 'products' => '', 'qty' => '', 'unit' => '', 'measure' => '', 'price' => '', 'val' => '$'.$transaction->amount, 'description' => $transaction->notes,   'balance' => '', 'paidamtcur' => '', 'detstr' => '');
                    array_push($datarow, $ndata);
                    
                    $amttotal = $amttotal + $transaction->amount;
                }
                
                if(strtotime($transaction->paid_at) <= strtotime($stdate) ){
                    $prvamt = $prvamt + $transaction->amount;
                }
            }
            
            
        }
        
        $dt = DB::table('documents')->where('contact_id', $customer->id)->where('created_at', '>=', $dbstdate)->where('deleted_at', null)->where('created_at', '<=', $dbeddate)->where('type', 'invoice')->get()->sum('amount');
        
        $paidallamt = DB::table('transactions')->where('contact_id', $customer->id)->where('created_at', '>=', $dbstdate)->where('deleted_at', null)->where('created_at', '<=', $dbeddate)->get()->sum('amount');
        
        
        
        $invoicamt = $dt;
        $transamt = $paidallamt;
        
        
        $openbalance = $prvamt - $prvinvoice;
        $closingbalance = $openbalance - $invoicamt + $transamt;
        
        
        $ary = array();
        $nary = array('inv_no' => '', 'date' => $stdate, 'document' => $openbalstr,'description' => '', 'products' => '','qty' => '', 'unit' => '', 'measure' => '', 'price' => '', 'val' => '-', 'paid' => '-', 'balance' => '$'.$openbalance, 'paidamtcur' => '', 'detstr' => '');
        array_push($ary, $nary);
        
        foreach($datarow as $crow){
            array_push($ary, $crow);
        }
        
        $nary = array('inv_no' => '','date' => $edate, 'document' => $closbalstr, 'description' => '', 'products' => '','qty' => '', 'unit' => '', 'measure' => '', 'price' => '', 'val' => '-', 'paid' => '-', 'balance' => '$'.$closingbalance, 'paidamtcur' => '', 'detstr' => '');
        array_push($ary, $nary);
        
        $today = Date::today()->toDateString();
        
        $today = '2222-01-17';

        foreach ($invoices as $item) {
            // Already in transactions
            if ($item->status == 'paid') {
                continue;
            }

            $transactions = 0;

            foreach ($item->transactions as $transaction) {
                $transactions += $transaction->getAmountConvertedToDefault();
            }

            // Check if it's open or overdue invoice
            if ($item->due_at > $today) {
                $amounts['open'] += $item->getAmountConvertedToDefault() - $transactions;
            } else {
                $amounts['overdue'] += $item->getAmountConvertedToDefault() - $transactions;
            }
        }

        // Handle transactions
        $transactions = Transaction::with('category')->where('contact_id', $customer->id)->income()->get();

        
        // Prepare data
        $transactions->each(function ($item) use (&$amounts) {
            $amounts['paid'] += $item->getAmountConvertedToDefault();
        });

        $limit = request('limit', setting('default.list_limit', '25'));
        $transactions = $this->paginate($transactions->sortByDesc('paid_at'), $limit);
        $invoices = $this->paginate($invoices->sortByDesc('issued_at'), $limit);
        
        $invoices->st_date = $stdate;
        $invoices->ed_date = $edate;
        $invoices->invoicamt = $invoicamt;
        $invoices->transamt = $transamt;
        $invoices->openbalance = $openbalance;
        $invoices->closingbalance = $closingbalance;
        $invoices->rows = $ary;
        $invoices->amttotal = $amttotal;
        $invoices->textQuantity = $textQuantity;
        $invoices->textPrice = $textPrice;
        

        return view('sales.customers.report', compact('customer', 'amounts', 'transactions', 'invoices'));
    }
    public function report_backup(Contact $customer){
        
       // $currency_code = '$';
        
        
       $textQuantity =  setting('invoice.quantity_name');
       $textPrice = setting('invoice.price_name');
      
        
        $stdate = date("d M Y",strtotime("-1 month"));
        $edate = date("d M Y", time());
        
        $adtime = 86400;
       // $adtime = 0;
        
        $edatval = date("d M Y", time() + $adtime);
        
        if (request()->isMethod('post')) {
            
            $stval = $_POST["st_date"];
            $edval = $_POST["end_date"];
            if(strtotime($edval) > strtotime($stval)){
                $stdate = date("d M Y",strtotime($stval));
                $edate = date("d M Y", strtotime($edval));
                $edatval = date("d M Y", strtotime($edval) + $adtime);
            }
            
        }
        
        $dbstdate = date("Y-m-d", strtotime($stdate));
        $dbeddate = date("Y-m-d", strtotime($edatval));
        
        
        
      
        
        $amounts = [
            'paid' => 0,
            'open' => 0,
            'overdue' => 0,
        ];

        $counts = [];

        // Handle invoices
        //$invoices = Document::invoice()->with('transactions')->where('contact_id', $customer->id)->get();

//2021-11-11
        
        $invoicamt = 0;
        $transamt = 0;
        
        $prvinvoice = 0;
        $prvamt = 0;
        $amttotal = 0;
        //get all invoice
        //$invoices = Document::invoice()->where('contact_id', $customer->id)->get();
        $invoices = Document::invoice()->with('transactions')->where('contact_id', $customer->id)->get();
        
        $datarow = array();
        
        $invoicstr = trans('general.invoice', ['Invoice']);
        $transstr = trans('general.transaction', ['Transaction']);
        $openbalstr = trans('general.open_balance', ['open_balance']);
        $closbalstr = trans('general.close_balance', ['close_balance']);

        foreach ($invoices as $item) {
            if(strtotime($item->created_at) >= strtotime($stdate) && strtotime($item->created_at) <= strtotime($edatval)){
                $invoicamt = $invoicamt + $item->amount;
                
                $noteitem = DB::table('documents')->where('id', $item->id)->where('deleted_at', null)->first();
                $notes = '';
                
                if($noteitem != null){
                    $notes = $noteitem->notes;
                }
                
                $detamt = $item->amount;
                $paidamtcur = 0;
                foreach ($item->transactions as $transaction) {
                    $paidamtcur = $paidamtcur + $transaction->amount;
                }
                
                $detstr = "$".$detamt;
                
                
                $paidstr = "";
                if($paidamtcur > 0){
                    $paidstr = '$'.$paidamtcur;
                    $detstr =  $detamt - $paidamtcur;
                    $detstr = "$".$detstr;
                }
                
                
                $amttotal = $amttotal - $item->amount;
                
                $allitems = DB::table('document_items')->where('document_Id', $item->id)->where('deleted_at', null)->get();
                
                $productnames = "";
                $productsqty = "";
                $productsunit = "";
                $productmeausre = "";
                $productprice = "";
                
                $init = 0;
                
                foreach($allitems as $citem){
                    
                   // $ndata =  array('date' => '', 'document' => "", 'description' => $citem->name . ': $'.$citem->price , 'val' => '',  'balance' => '');
                    //array_push($datarow, $ndata);
                    if($init == 0){
                        $productnames = $citem->name;
                        $productsqty = //intval($citem->quantity);
                        $productsqty = $citem->quantity;
                        $productsunit = $citem->product_unit;
                        $productmeausre = $citem->meter_square;
                        $productprice = $citem->price;
                        $init = 1;
                    }else{
                        $productnames = $productnames . "@_@_@" . $citem->name;
                        $productsqty = $productsqty . "@_@_@" . intval($citem->quantity);
                        $productsunit = $productsunit . "@_@_@" . intval($citem->product_unit);
                        $productmeausre = $productmeausre . "@_@_@" . $citem->meter_square ;
                        $productprice = $productprice . "@_@_@" . $citem->price;
                         //$productnames = $productnames. "<p>" . $citem->name .'</p>' ;
                    }
                    
                }
                
                $ndata =  array('inv_no' => $item->document_number, 'date' => $item->issued_at, 'document' => $invoicstr, 'products' => $productnames, 'qty' => $productsqty, 'unit' => $productsunit, 'measure' => $productmeausre, 'price' => $productprice,  'val' => '$'.$item->amount, 'description' => $notes ,  'balance' => '', 'paidamtcur' => $paidstr, 'detstr' => $detstr);
                array_push($datarow, $ndata);
                
                
            }
            
            if(strtotime($item->created_at) <= strtotime($stdate) ){
                $prvinvoice = $prvinvoice + $item->amount;
            }
            
            foreach ($item->transactions as $transaction) {
                //$transactions += $transaction->getAmountConvertedToDefault();
                
                if(strtotime($transaction->paid_at) >= strtotime($stdate) && strtotime($transaction->paid_at) <= strtotime($edatval)){
                    $transamt = $transamt + $transaction->amount;
                    
                    $ndata =  array('inv_no' => '','date' => $transaction->paid_at, 'document' => $transstr, 'products' => '', 'qty' => '', 'unit' => '', 'measure' => '', 'price' => '', 'val' => '$'.$transaction->amount, 'description' => $transaction->notes,   'balance' => '', 'paidamtcur' => '', 'detstr' => '');
                    array_push($datarow, $ndata);
                    
                    $amttotal = $amttotal + $transaction->amount;
                }
                
                if(strtotime($transaction->paid_at) <= strtotime($stdate) ){
                    $prvamt = $prvamt + $transaction->amount;
                }
            }
            
            
        }
        
        $dt = DB::table('documents')->where('contact_id', $customer->id)->where('created_at', '>=', $dbstdate)->where('deleted_at', null)->where('created_at', '<=', $dbeddate)->where('type', 'invoice')->get()->sum('amount');
        
        $paidallamt = DB::table('transactions')->where('contact_id', $customer->id)->where('created_at', '>=', $dbstdate)->where('deleted_at', null)->where('created_at', '<=', $dbeddate)->get()->sum('amount');
        
        
        
        $invoicamt = $dt;
        $transamt = $paidallamt;
        
        
        $openbalance = $prvamt - $prvinvoice;
        $closingbalance = $openbalance - $invoicamt + $transamt;
        
        
        $ary = array();
        $nary = array('inv_no' => '', 'date' => $stdate, 'document' => $openbalstr,'description' => '', 'products' => '','qty' => '', 'unit' => '', 'measure' => '', 'price' => '', 'val' => '-', 'paid' => '-', 'balance' => '$'.$openbalance, 'paidamtcur' => '', 'detstr' => '');
        array_push($ary, $nary);
        
        foreach($datarow as $crow){
            array_push($ary, $crow);
        }
        
        $nary = array('inv_no' => '','date' => $edate, 'document' => $closbalstr, 'description' => '', 'products' => '','qty' => '', 'unit' => '', 'measure' => '', 'price' => '', 'val' => '-', 'paid' => '-', 'balance' => '$'.$closingbalance, 'paidamtcur' => '', 'detstr' => '');
        array_push($ary, $nary);
        
        $today = Date::today()->toDateString();
        
        $today = '2222-01-17';

        foreach ($invoices as $item) {
            // Already in transactions
            if ($item->status == 'paid') {
                continue;
            }

            $transactions = 0;

            foreach ($item->transactions as $transaction) {
                $transactions += $transaction->getAmountConvertedToDefault();
            }

            // Check if it's open or overdue invoice
            if ($item->due_at > $today) {
                $amounts['open'] += $item->getAmountConvertedToDefault() - $transactions;
            } else {
                $amounts['overdue'] += $item->getAmountConvertedToDefault() - $transactions;
            }
        }

        // Handle transactions
        $transactions = Transaction::with('category')->where('contact_id', $customer->id)->income()->get();

        
        // Prepare data
        $transactions->each(function ($item) use (&$amounts) {
            $amounts['paid'] += $item->getAmountConvertedToDefault();
        });

        $limit = request('limit', setting('default.list_limit', '25'));
        $transactions = $this->paginate($transactions->sortByDesc('paid_at'), $limit);
        $invoices = $this->paginate($invoices->sortByDesc('issued_at'), $limit);
        
        $invoices->st_date = $stdate;
        $invoices->ed_date = $edate;
        $invoices->invoicamt = $invoicamt;
        $invoices->transamt = $transamt;
        $invoices->openbalance = $openbalance;
        $invoices->closingbalance = $closingbalance;
        $invoices->rows = $ary;
        $invoices->amttotal = $amttotal;
        $invoices->textQuantity = $textQuantity;
        $invoices->textPrice = $textPrice;
        

        return view('sales.customers.report', compact('customer', 'amounts', 'transactions', 'invoices'));
    }

    /**
     * Import the specified resource.
     *
     * @param  ImportRequest  $request
     *
     * @return Response
     */
    public function import(ImportRequest $request)
    {
        $response = $this->importExcel(new Import, $request);

        if ($response['success']) {
            $response['redirect'] = route('customers.index');

            $message = trans('messages.success.imported', ['type' => trans_choice('general.customers', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('import.create', ['sales', 'customers']);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Contact  $customer
     *
     * @return Response
     */
    public function edit(Contact $customer)
    {
        $currencies = Currency::enabled()->pluck('name', 'code');

        return view('sales.customers.edit', compact('customer', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Contact $customer
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Contact $customer, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateContact($customer, $request));

        if ($response['success']) {
            $response['redirect'] = route('customers.index');

            $message = trans('messages.success.updated', ['type' => $customer->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('customers.edit', $customer->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Enable the specified resource.
     *
     * @param  Contact $customer
     *
     * @return Response
     */
    public function enable(Contact $customer)
    {
        $response = $this->ajaxDispatch(new UpdateContact($customer, request()->merge(['enabled' => 1])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $customer->name]);
        }

        return response()->json($response);
    }

    /**
     * Disable the specified resource.
     *
     * @param  Contact $customer
     *
     * @return Response
     */
    public function disable(Contact $customer)
    {
        $response = $this->ajaxDispatch(new UpdateContact($customer, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => $customer->name]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact $customer
     *
     * @return Response
     */
    public function destroy(Contact $customer)
    {
        $response = $this->ajaxDispatch(new DeleteContact($customer));

        $response['redirect'] = route('customers.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $customer->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Export the specified resource.
     *
     * @return Response
     */
    public function export()
    {
        return $this->exportExcel(new Export, trans_choice('general.customers', 2));
    }

    public function currency(Contact $customer)
    {
        if (empty($customer)) {
            return response()->json([]);
        }

        $currency_code = setting('default.currency');

        if (isset($customer->currency_code)) {
            $currencies = Currency::enabled()->pluck('name', 'code')->toArray();

            if (array_key_exists($customer->currency_code, $currencies)) {
                $currency_code = $customer->currency_code;
            }
        }

        // Get currency object
        $currency = Currency::where('code', $currency_code)->first();

        $customer->currency_name = $currency->name;
        $customer->currency_code = $currency_code;
        $customer->currency_rate = $currency->rate;

        $customer->thousands_separator = $currency->thousands_separator;
        $customer->decimal_mark = $currency->decimal_mark;
        $customer->precision = (int) $currency->precision;
        $customer->symbol_first = $currency->symbol_first;
        $customer->symbol = $currency->symbol;

        return response()->json($customer);
    }

    public function field(BaseRequest $request)
    {
        $html = '';

        if ($request['fields']) {
            foreach ($request['fields'] as $field) {
                switch ($field) {
                    case 'password':
                        $html .= \Form::passwordGroup('password', trans('auth.password.current'), 'key', [], 'col-md-6 password');
                        break;
                    case 'password_confirmation':
                        $html .= \Form::passwordGroup('password_confirmation', trans('auth.password.current_confirm'), 'key', [], 'col-md-6 password');
                        break;
                }
            }
        }

        $json = [
            'html' => $html
        ];

        return response()->json($json);
    }
}
