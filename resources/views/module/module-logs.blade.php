
<div id="module-logs-modal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Module Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                            <th>By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($moduleLogs AS $log)
                        <tr>
                            <td>{{$log->action_date->format("m/d/Y h:i A")}}</td>
                            <td>{{$log->action}}</td>
                            <td>{{$log->actionBy->display_name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
