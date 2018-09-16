@extends('layouts.joli.app')
@section('title','Stock Received Listing')
@section('content')

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="#">Stock</a></li>
        <li class="active">Stock In Listing</li>
    </ul>
    <!-- END BREADCRUMB -->     
    
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <h3 class="panel-title">Stock In Listing as {{date('d/m/Y')}}</h3>
                        <div class="actions pull-right">
                                <a href="{{ url('inventory/stock/barcode/all') }}" class="btn btn-default  btn-sm btn-circle" title="Show All Products Serial Number">
                                    <i class="fa fa-list"></i> Show All Product S/N</a>
                        </div>
                        </div>
                        <div class="panel-body panel-body-table">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="table_listing">
                                    <thead>
                                        <tr>
                                            <th>Stock Received No</th>
                                            <th>Description</th>
                                            <th>Stock In Date</th>                                       
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($stocks) > 0)
                                        @foreach($stocks as $stock)
                                        <tr class='click' data-href='{{ url('inventory/stock/in/view/'.$stock->stock_in_no) }}'>
                                            <td> <a href="{{ url('inventory/stock/in/view/'.$stock->stock_in_no) }}">{{$stock->stock_in_no}}</a> </td>
                                            <td>{{$stock->description}}</td>
                                            <td>{{$stock->StockItem->where('stock_id',$stock->id)->sum('quantity')}}</td>
                                            <td  data-order="{{ Carbon\Carbon::parse($stock->stock_date)}}">{{ Carbon\Carbon::parse($stock->stock_date)->format('d/m/Y') }}</td>                                            
                                        </tr>
                                        @endforeach
                                        {{-- @else
                                        <tr>
                                            <td colspan="9" class="text-center"> No Data Found <br />
                                        </tr> --}}
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

    $(document).ready(function($) {
        var t = $('#table_listing').DataTable({
                    "order": [],
                    "columnDefs": [
                                { targets: 'no-sort', orderable: false }
                                ]
                });

    $(".click").click(function() {
            window.location = $(this).data("href");
        });
    });
    
    function fn_clear(){
        console.log("clear!");
    }
    </script>

@stop