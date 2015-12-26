
<div class="table-responsive">
    <table id="{{$id}}" class="table table-hover">
        <thead>
            <tr>
                @foreach($columns AS $column)
                <th class="small text-muted text-uppercase">
                    <strong>{{$column}}</strong>
                </th>
                @endforeach               
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
