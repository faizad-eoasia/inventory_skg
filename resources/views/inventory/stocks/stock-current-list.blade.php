@extends('layouts.joli.app')
@section('title','Current Stock')
<style>
#table_listing{
    font-size: 1.2rem;
}
textarea {
   resize: none;
}
</style>
@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{ url('home') }}">Home</a></li>                    
	<li><a href="{{ url('stock/listing') }}">Current Stock</a></li>
</ul>
<!-- END BREADCRUMB -->   

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START RESPONSIVE TABLES -->
    <div class="row"><div class="col-sm-12">
 @if(session("message"))        
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                {{ session("message") }}
            </div>
        </div>
 @endif
 @if(session("errorid"))
     <div class="col-sm-12">
         <div class="alert alert-danger">
             <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
             {{ session("errorid") }}
         </div>
     </div>
 @endif
    </div>

    <div class="row">
            <div class="col-md-12">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                    <h3 class="panel-title">Current Stock Listing</h3>
                                    <div class="actions pull-right">
                                            <a href="{{ url('inventory/stock/in') }}" class="btn btn-default  btn-sm btn-circle" title="Stock In" >
                                                <i class="fa fa-plus"></i> Stock In </a>
                                    </div>
                                    <div class="actions pull-right">
                                        <a href="{{ url('inventory/stock/adjustment') }}" class="btn btn-default  btn-sm btn-circle" title="Adjust Stock" >
                                            <i class="fa fa-plus"></i> Stock Adjustment </a>
                                    </div>
                                    <div class="actions pull-right">
                                            <a href="#" class="btn btn-default  btn-sm btn-circle" title="Check Barcode" data-toggle="modal" data-target="#barcode_checker">
                                                <i class="fa fa-search"></i> Check Barcode </a>
                                        </div>
                            </div>
                            <div class="panel-body"> 
                                    <div class="col-md-3">
                                            <div class="widget widget-danger widget-item-icon widget-no-subtitle">
                                                    <div class="widget-item-left">
                                                        <span class="glyphicon glyphicon-warning-sign"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-big-int num-count">{{$dashboards['totalLessStock']}}</div>
                                                        <div class="widget-title">Product low in stocks</div>
                                                        <div class="widget-subtitle"></div>
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>

                                    <div class="col-md-3">
                                            <div class="widget widget-info widget-item-icon widget-no-subtitle">
                                                    <div class="widget-item-left">
                                                        <span class="fa fa-adjust"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-big-int num-count">{{\Carbon\Carbon::parse($dashboards['lastAdjustment'])->diffForHumans()}}</div>
                                                        {{-- <div class="widget-title">Last Adjustment</div> --}}
                                                        <div class="widget-title">Last Adjustment</div>
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>

                                    <div class="col-md-3">
                                            <div class="widget widget-success widget-item-icon widget-no-subtitle">
                                                    <div class="widget-item-left">
                                                        <span class="fa fa-truck"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-big-int num-count">{{$dashboards['totalActiveStock']}}</div>
                                                        <div class="widget-title">Available in stock</div>
                                                        {{--  <div class="widget-subtitle">In your mailbox</div>  --}}
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>
                                    
                                    
                                    <div class="col-md-3">
                                            <div class="widget widget-primary widget-item-icon widget-no-subtitle">
                                                    <div class="widget-item-left">
                                                        <span class="fa fa-shopping-cart"></span>
                                                    </div>                             
                                                    <div class="widget-data">
                                                        <div class="widget-big-int num-count">{{$dashboards['totalProduct']}}</div>
                                                        <div class="widget-title">Products</div>
                                                        <div class="widget-subtitle"></div>
                                                    </div>      
                                                    {{--  <div class="widget-controls">                                
                                                        <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                                    </div>  --}}
                                                </div>   
                                    </div>
                            </div>
                            <div class="panel-body">              
                                            <p>Total listing: <b>{{ count($data) }}</b></p>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped datatable" id="table_listing">
                                                <thead>
                                                        <tr>
                                                                <th  class="no-sort">Name</th>
                                                                <th >Code</th>
                                                                <th >Product Name</th>
                                                                <th >Stock left</th>   
                                                                <th  class="no-sort">Actions</th>
                                                                <th  class="no-sort"></th>
                                                            </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($data) > 0)
                                                    <?php $i = 1; ?>
                                                    @foreach($data as $stock)       
                                                                              
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td>{{ $stock['product_code'] }} </td>
                                                            <td>{{ $stock['product_name'] }} </td>
                                                            <td>{{ $stock['stocksCount']}} </td>
                                                            <td>
                                                                <a href="{{url('inventory/product/view/'.$stock['product_id'])}}" class="" data-toggle="tooltip" data-placement="bottom" title="Product Details"><span class="fa fa-eye"></span></a>
                                                            </td>
                                                            <td>    
                                                                <a href="{{url('inventory/stock/barcode/'.$stock['product_id'])}}" class="" data-toggle="tooltip" data-placement="bottom" title="Barcode"><span class="fa fa-barcode"></span></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="6" class="text-center"> No Data Found <br />
                                                    <a href="{{ url('stock/in') }}"><span class="fa fa-plus"></span> Add new stock</a></td>
                                                    <td style="display: none;"></td>
                                                    <td style="display: none;"></td>
                                                    <td style="display: none;"></td>
                                                    <td style="display: none;"></td>
                                                    <td style="display: none;"></td>
                                                </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                            </div>
                    </div>
            </div>
    </div>



</div>

<!-- Modal -->
<div id="barcode_checker" class="modal fade" role="dialog">
        <div class="modal-dialog">      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Scan</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal" id="barcodeDoneBtn">Done</button>
            </div>
          </div>
      
        </div>
      </div>
      <script type='text/javascript' src="{!! asset('joli/js/plugins/validationengine/jquery.validationEngine.js') !!}"></script>   
      <script>
            
                

        
        </script>
@endsection
{{-- page level scripts --}}
@section('footer_scripts')
 <script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/tableExport.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jquery.base64.js"') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/html2canvas.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
	<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/jspdf.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/base64.js') }}"></script> 

<script type="text/javascript">

    $(document).ready(function() {
                var t = $('.datatable').DataTable({
                    "order": [],
                    "columnDefs": [
                                { targets: 'no-sort', orderable: false }
                                ]
                });
            })
    
    function fn_clear(){
        console.log("clear!");
    }
    </script>

@stop