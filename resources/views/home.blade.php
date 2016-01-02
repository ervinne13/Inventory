@extends('layouts.skarla')

@section('content')
<div class="container">

    <h4>Reports</h4>

    <div class="row">

        <div class="col-md-6 col-sm-6">
            <div class="panel panel-default b-a-0 shadow-box">
                <div class="panel-heading">Inventory By Location</div>
                <div class="panel-body">
                    <table id="" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="small text-muted text-uppercase"><strong>Item</strong></th>
                                <th class="small text-muted text-uppercase"><strong>Unit</strong></th>
                                <th class="small text-muted text-uppercase"><strong>Stock</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>                       
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
