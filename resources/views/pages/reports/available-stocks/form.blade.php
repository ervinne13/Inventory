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
                <h4 class="m-b-0 ">Items In Stock / Unsold Items</h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            

            <table class="table">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>Stock / Qty</th>                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks AS $stock)
                    <tr>
                        <td>{{$stock->location->name}}</td>
                        <td>{{$stock->item->name}}</td>
                        <td>{{$stock->uom->name}}</td>
                        <td>{{$stock->qty}}</td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection