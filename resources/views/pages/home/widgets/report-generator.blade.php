<div class="panel panel-default b-a-0 shadow-box">
    <div class="panel-heading">
        Printable Report
        <div class="pull-right">
            <select id="report-select" class="form-control">
                @if (count($reports) > 1)
                <option selected disabled>-- Select Report -- </option>
                @endif

                @foreach($reports AS $reportId => $reportName)
                <option value="{{$reportId}}">{{$reportName}}</option>
                @endforeach
            </select>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="input-date-from">Date From</label>
            <input name="report_date_from" id="input-date-from" class="form-control" type="text">
        </div>

        <div class="form-group">
            <label class="control-label" for="input-date-to">Date To</label>
            <input name="report_date_to" id="input-date-to" class="form-control" type="text">
        </div>

        <div class="pull-right">
            <button id="action-generate-report" class="btn btn-success">Generate Report</button>
        </div>
        <div class="clearfix"></div>
    </div>
</div>