@extends('layouts.admin')

@section('title', $customer->name)

@section('content')


<style>
    .card{
        padding:5px;
        background:#fff;
    }
    .top-div{
        background:#1f3d7a !important;
        padding: 40px 20px 40px 20px;
        color: #fff;
    }
    
    .top-div i{
        font-size:54px;
    }
    .top-m-div{
        background:#85a3e0 !important;
        text-align:center;
        color:#fff;
        padding:5px;
    }
    .row-statment{
        margin:0px !important;
        margin-top:10px !important;
    }
    .statment-head{
        background:#1f3d7a !important;
        color:#fff;
        padding:10px;
    }
    .statement-row{
        padding:10px;
        border-bottom: solid 1px #f2f2f2;
    }
    .statement-row-0{
        border-bottom:solid 2px !important;
    }
    .statement-row-last{
        border-bottom:none !important;
    }
    .statement-row span{
        float: right;
    }
    .table-head-f{
        background:#1f3d7a !important;
        color:#fff !important;
    }
    .table-head-f td, .table-head-f th{
        color:#fff !important;
    }
    .card .el-table td, .card .el-table th, .card .table td, .card .table th {
        padding-left: .4rem !important;
        padding-right: .5rem !important;
        /*
        white-space: pre-wrap !important;
word-wrap: break-word !important;
*/
    }
    
    .spec-cls{
        background: #fff !important;
        padding-bottom: 10px !important;
        padding-left: 15px !important;
        margin: 0px !important;
    }
    
</style>
    <div class="row">
        <div class="col-xl-12">
            
            
            <form action="{{ route('customers.report', $customer->id) }}" method="post">
                {{ csrf_field() }}
                <div class="row spec-cls">
                   
                    <div style="padding-bottom:0px;" class="list-group-item d-flex justify-content-between align-items-center border-0 col-xl-12">
                        <label>{{$customer->name}} {{ trans('general.statement') }}</label>
                        
                    </div>
                    
                    <div class="col-xl-6 list-group-item d-flex justify-content-between align-items-center border-0" style="padding-bottom:0px;" >
                        <label class="col-xl-12">{{trans('general.from_date')}} * </label>
                        
                        
                    </div>
                    
                    <div class="col-xl-6 list-group-item d-flex justify-content-between align-items-center border-0" style="padding-bottom:0px;">
                        <label class="col-xl-12">{{trans('general.to_date')}} *</label>
                        
                        
                        
                    </div>
                   
                    <div class="col-xl-6 list-group-item d-flex justify-content-between align-items-center border-0" style="padding-top:0px;">
                        
                        <input type="date" value="{{$invoices->st_date}}" class="form-control date" name="st_date" id="st_date" required />
                        
                    </div>
                    <div class="col-xl-6 list-group-item d-flex justify-content-between align-items-center border-0" style="padding-top:0px;">
                        
                        <input type="date" max="0" value="{{$invoices->ed_date}}" class="form-control date" name="end_date" id="end_date" required />
                    </div>
                    
                    <button type="submit" class="btn btn-info btn-block col-md-3"><b>{{trans('general.view_btn')}}</b></button>
                    
                   
            <button type='button' class="btn btn-info col-md-3" id='btn'  onclick='printDiv();'>{{trans('general.print')}}</button>
            
                    
                </div>
            

            

                
            </form>
            
        </div>

        <div class="col-xl-12">
    

            <div class="row1" id="DivIdToPrint">
                <div class="col-md-121">
                    
                    <div class="card">
                        <div class="tab-content1" id="myTabContent1">
                            
                                <div class="col-xl-12 top-div" >
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <i class="fa fa-building"></i>
                                            
                                            
                                            
                                            
                                        </div>
                                        <div class="col-xl-8 text-right">
                                            {{ setting('company.name') }}
                                            <br>{{ setting('company.email') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 top-m-div">
                                    {{trans('general.statement')}} <br>
                                    {{$invoices->st_date}} {{trans('general.to')}} {{$invoices->ed_date}}
                                </div>
                                
                                <div class="row row-statment">
                                    <div class="col-xl-6">
                                        <div><b>{{trans('general.to')}}:</b></div>
                                        <div><b>{{$customer->name}}</b></div>
                                        <div>{{$customer->email}}</div>
                                        <div>{{$customer->phone}}</div>
                                        <div>{{$customer->address}}</div>
                                    </div>
                                    
                                    <div class="col-xl-6">
                                        <div class="statment-head">{{trans('general.account_summary')}}</div>
                                        <div class="statement-row">{{trans('general.open_balance')}} 
                                            <span>${{$invoices->openbalance}}</span>
                                        </div>
                                        <div class="statement-row">{{trans('general.invoice_amount')}} <span>${{$invoices->invoicamt}}</span></div>
                                        <div class="statement-row statement-row-0">{{trans('general.amount_paid')}} <span>${{$invoices->transamt}}</span></div>
                                        
                                        <div class="statement-row statement-row-last">{{trans('general.close_balance')}} 
                                            <span>${{$invoices->closingbalance}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xl-12">
                                        <table class="table table-flush table-hover">
                                            <thead class="table-head-f">
                                                <tr>
                                                    <th>
                                                        {{trans('general.invoice_no')}}
                                                    </th>
                                                    <th>
                                                        {{trans('general.date')}}
                                                    </th>
                                                    <th>{{trans('general.document')}}</th>
                                                    <?php
                                                        /**/
                                                        ?>
                                                    <th>{{trans('general.details')}}</th>
                                                    
                                                    
                                                    <th>{{ trans($invoices->textQuantity) }}</th>
                                                    <th>{{trans('items.product_unit')}}</th>
                                                    <th>{{trans('items.meter_square_header')}}</th>
                                                    <th>{{ trans($invoices->textPrice) }}</th>
                                                    
                                                    
                                                    <th>{{trans('general.amount')}}</th>
                                                    
                                                    <th>{{trans('general.paid')}}</th>
                                                    <th>{{trans('general.debt')}}</th>
                                                    
                                                   <th>{{trans('general.description')}}</th>
                                                    <th>{{trans('general.balance')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoices->rows as $item)
                                                    <tr>
                                                        <td>{{$item["inv_no"]}}</td>
                                                        <td>{{$item["date"]}}</td>
                                                        <td>{{$item["document"]}}</td>
                                                        
                                                        <?php
                                                        /*
                                                        ?>
                                                        <td>{{$item["products"]}}</td>*/?>
                                                        <td style="text-align:right;">
                                                            <?php
                                                            echo str_replace("@_@_@", "<br>", $item["products"]);
                                                            ?>
                                                        </td>
                                                        
                                                        <td style="text-align:right;">
                                                            <?php
                                                            echo str_replace("@_@_@", "<br>", $item["qty"]);
                                                            ?>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <?php
                                                            echo str_replace("@_@_@", "<br>", $item["unit"]);
                                                            ?>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <?php
                                                            echo str_replace("@_@_@", "<br>", $item["measure"]);
                                                            ?>
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <?php
                                                            echo str_replace("@_@_@", "<br>", $item["price"]);
                                                            ?>
                                                        </td>
                                                        
                                                        <td>{{$item["val"]}}</td>
                                                        
                                                        <td>{{$item["paidamtcur"]}}</td>
                                                        <td>
                                                        {{$item["detstr"]}}
                                                        </td>
                                                        
                                                        <td>{{$item["description"]}}</td>
                                                        <td>{{$item["balance"]}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-head-f">
                                                <tr>
                                                    <td colspan="12">{{trans('general.total')}}:</td>
                                                    <!--<td>${{$invoices->amttotal}}</td>-->
                                                    <td>${{$invoices->closingbalance}}</td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td colspan="12">{{trans('general.total_paid')}}:</td>
                                                    <td>${{$invoices->transamt}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="12">{{trans('general.total_debt')}}:</td>
                                                    <td >${{$invoices->invoicamt - $invoices->transamt}}
                                                        
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                 <div class="row print-only">
                                    <div class="col-xl-12">
                                        
                                        <p>{{trans('general.giver')}}</p>
                                        
                                        <p>{{trans('general.recipient')}}</p>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div id="printdouter" style="display:none;">
    
    
    <style>
    
    body {
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact;
}

.print-only{
        margin: 10px 0 0 -19px;
        display: none !important;
    }
    .print-only p{
        text-align: right;
        font-size: 1rem;
        font-weight: 400;
    }

    @media print {
        .print-only{
            display: block !important;
        }
    }
   
    .col-xl-6{
        width:45%;
        float:left;
        padding-left:15px;
        padding-right:15px;
    }
    .row{
        width:100%;
    }
    table{
        width:100%;
        
    }
    
    tbody tr:nth-child(even) {background-color: #f2f2f2;}
    
    .card{
        padding:5px;
        background:#fff;
    }
    .top-div{
        /*background:#1f3d7a !important;*/
        background-color:#1f3d7a !important;
        padding: 40px 20px 40px 20px;
        color: #fff;
    }
    
    .top-div i{
        font-size:54px;
    }
    .top-m-div{
        background:#85a3e0 !important;
        text-align:center;
        color:#fff;
        padding:5px;
    }
    .row-statment{
        margin:0px !important;
        margin-top:10px !important;
    }
    .statment-head{
        background:#1f3d7a !important;
        color:#fff;
        padding:10px;
    }
    .statement-row{
        padding:10px;
        border-bottom: solid 1px #f2f2f2;
    }
    .statement-row-0{
        border-bottom:solid 2px !important;
    }
    .statement-row-last{
        border-bottom:none !important;
    }
    .statement-row span{
        float: right;
    }
    .table-head-f{
        background:#1f3d7a !important;
        color:#fff !important;
    }
    .table-head-f td, .table-head-f th{
        color:#fff !important;
    }
 
</style>
    <div id="printd"></div>
</div>

@push('scripts_start')
    
    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        
        if (dd < 10) {
           dd = '0' + dd;
        }
        
        if (mm < 10) {
           mm = '0' + mm;
        } 
            
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("st_date").setAttribute("max", today);
        document.getElementById("end_date").setAttribute("max", today);
        
        
        
        function printDiv() 
        {
          
           //DivIdToPrint
           
           var ihtml = $("#DivIdToPrint").html();
           $("#printd").html(ihtml);
            
          var divToPrint=document.getElementById('printdouter');
        
          var newWin=window.open('','Print-Window');
        
          newWin.document.open();
        
          newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        
          newWin.document.close();
        
          setTimeout(function(){newWin.close();},10);
          
          $("#printd").html("");
      
        }
       
    </script>
@endpush
