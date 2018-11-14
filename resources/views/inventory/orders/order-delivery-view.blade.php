@extends('layouts.joli.app')    
<style>
    page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
  width: 21cm;
  height: 29.7cm; 
}
page[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 21cm;  
}
page[size="A3"] {
  width: 29.7cm;
  height: 42cm;
}
page[size="A3"][layout="landscape"] {
  width: 42cm;
  height: 29.7cm;  
}
page[size="A5"] {
  width: 14.8cm;
  height: 21cm;
}
page[size="A5"][layout="landscape"] {
  width: 21cm;
  height: 14.8cm;  
}

p {font-size:12px !important;}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}
</style>

@section('content')
  <!-- Load paper.css for happy printing -->
  
<div class="page-content-wrap">
        <div class="row">
                <div class="col-sm-12">
         @if(session("message"))        
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        {{ session("message") }}
                    </div>
                </div>
         @endif
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>
<div class="row">

	<div class="col-md-12">

        <div class="panel panel-success push-up-20">
                <div class="panel-heading">
                   
                    <button class="btn pull-right" onclick="printElem('printed_area')"><i class="fa fa-print"></i> Print</button>
                    <a href="{{url('inventory/order/delivery')}}" class="btn btn-info pull-right"><i class="fa fa-list"></i> DO Listing </a>
                </div>
                @if($delivery)
                <page size="A4" id="printed_area">
                        <div  class="panel-body panel-body-pricing A4">  
                                <div class="row">
                                    <img style="float: right!important;" class="pull-right" src="data:image/png;base64,{{ DNS1D::getBarcodePNG(isset($delivery->delivery_number) ? $delivery->delivery_number : "", "C128",1,33,array(1,1,1),true)  }}" alt="barcode"   />
                                    <img src="{{ asset('themes/Joli/img/skgwrldogo.png') }}"  height="50" width="200" alt="skgworld">
                                    <h3>SKG WORLD SDN BHD</h3>
                                    <hr>
                                </div>             
                                    <h3 style="text-align: center;">Delivery Order</h3>                          
                            
                            <div style="width:50%;float:left;font-size:8px;">
                            <p style=""><span class="fa fa-caret-right"></span> <strong>Customer:</strong> {{ isset($delivery->salesOrder->user->username) ? $delivery->salesOrder->user->username : "" }}</p>
                            <p><span class="fa fa-caret-right"></span> <strong>Tel:</strong> {{ isset($delivery->salesOrder->contect_no) ? $delivery->salesOrder->contect_no : "" }}</p>                
                            <p><span class="fa fa-caret-right"></span> <strong>Purchase Date:</strong> {{ Carbon\Carbon::parse(isset($delivery->salesOrder->purchase_date) ?$delivery->salesOrder->purchase_date: "")->format('d/m/Y') }}</p>
                            
                            <p><span class="fa fa-caret-right"></span> <strong>Bill To:</strong> {{ isset($delivery->salesOrder->billing_address->street1) ? $delivery->salesOrder->billing_address->street1 : "" }}{{ isset($delivery->salesOrder->billing_address->street2) ? $delivery->salesOrder->billing_address->street2 : "" }},
                                {{ isset($delivery->salesOrder->billing_address->poscode) ? $delivery->salesOrder->billing_address->poscode : "" }},
                                {{ isset($delivery->salesOrder->billing_address->city) ? $delivery->salesOrder->billing_address->city : "" }},
                                {{ isset($delivery->salesOrder->billing_address->state) ? $delivery->salesOrder->billing_address->state: "" }},
                                {{ isset($delivery->salesOrder->billing_address->country) ? $delivery->salesOrder->billing_address->country : "" }}                                                                    
                            </p>
            
                            <p><span class="fa fa-caret-right"></span> <strong>Ship To:</strong> {{ isset($delivery->salesOrder->shipping_address->street1) ? $delivery->salesOrder->shipping_address->street1 : "" }}{{ isset($delivery->salesOrder->billing_address->street2 ) ? $delivery->salesOrder->billing_address->street2  : ""}},
                                {{ isset($delivery->salesOrder->shipping_address->poscode) ? $delivery->salesOrder->shipping_address->poscode : "" }},
                                {{ isset($delivery->salesOrder->shipping_address->city) ? $delivery->salesOrder->shipping_address->city : "" }},
                                {{ isset($delivery->salesOrder->shipping_address->state) ? $delivery->salesOrder->shipping_address->state : "" }},
                                {{ isset($delivery->salesOrder->shipping_address->country) ? $delivery->salesOrder->shipping_address->country : "" }}                                                                    
                            </p>
            
                            
                        </div>
                        <div style="width:50%;float:right;font-size:8px;">
                                <p><span class="fa fa-caret-right"></span> <strong>Delivery Order:</strong>#{{ isset($delivery->delivery_number) ? $delivery->delivery_number : ""}}</p>
                                <p><span class="fa fa-caret-right"></span> <strong>Consignment Note (C/N):</strong> {{ isset($delivery->courier_consignment) ? $delivery->courier_consignment : "" }}</p>
                                <p><span class="fa fa-caret-right"></span> <strong>Courier:</strong> {{ isset($delivery->courier->courier_name) ? $delivery->courier->courier_name : "" }}</p>
                                <p><span class="fa fa-caret-right"></span> <strong>Generate Date:</strong> {{ isset($delivery->created_at) ? Carbon\Carbon::parse($delivery->created_at)->format('Y/m/d H:i:s') : "" }}</p>
                        </div>
                            <table border="1px" class="table table-condensed table-stripe" style="font-size:11px !important;">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ isset($item->products->code) ? $item->products->code : "" }}</td>   
                                            <td>{{ isset($item->products->name) ? $item->products->name : "" }}</td>                               
                                            <td>{{ isset($item->quantity) ? $item->where('id',$item->id)->where('product_id',$item->product_id)->sum('quantity') : "0" }}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                            <div>
                                    <p>This is computer-generated copy,no signature required</p>
                                </div>
                        </div>
                        


                </page>
            
            @else
            <div class="alert alert-danger">
                    <ul>
                        <h1>Order not found</h1>
                    </ul>
                </div>
                @endif
        </div>

    </div>
</div>
</div>

@stop
@section('footer_scripts')
<script>
function printElem(divId) {
    var content = document.getElementById(divId).innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');

    mywindow.document.write('<html><head><style>table{border: 1px solid black;width:100%}</style><title>Print</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}
</script>


@endsection
