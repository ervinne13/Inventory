<div class="panel panel-default b-a-0 shadow-box">
    <div class="panel-heading">
        Items Low on Stocks
        <div class="pull-right">
            <select id="item-low-stock-location-select" class="form-control">
                <option selected disabled>-- Select Location -- </option>
                @foreach($locations AS $location)
                <option value="{{$location->code}}">{{$location->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table id="low-stock-items-by-location-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="small text-muted text-uppercase"><strong>Item</strong></th>                    
                    <th class="small text-muted text-uppercase"><strong>Min Stock</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Stock</strong></th>
                </tr>
            </thead>
            <tbody>
            </tbody>                       
        </table>
    </div>
</div>