@extends("layouts.report")

@section('js')
<script type='text/javascript'>
    $(document).ready(function () {
        window.print();
    });
</script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Sales Report</h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            

            <div class="row">

                <div class="col-md-4">
                    <label>Report Coverage:</label>
                    {{$from->format("m/d/Y")}} - {{$to->format("m/d/Y")}}
                </div>            

                <div class="col-md-4">
                    <label>Total Number of Sales Invoices:</label>
                    <b class="text-success">{{$invoiceCount}}</b>
                </div>

                <div class="col-md-4">                    
                    <div class="text-right p-t-0">
                        <h1 class="m-t-0 m-b-0 f-w-300">P {{number_format($totalSales)}}</h1>
                        <p>Total Gross Sales</p>
                    </div>
                </div>  

            </div>

            <div class="row">
                <div class="col-md-12">
                    @include("pages.reports.sales.breakdown-by-item")
                </div>
            </div>

        </div>
    </div>
</div>

@endsection