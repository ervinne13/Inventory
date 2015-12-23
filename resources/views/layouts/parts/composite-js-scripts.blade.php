
@if (isset($uses))

@if (in_array("sg-formatter", $uses))
<script src="{{skarla_vendor_url("js/moment.min.js")}}"></script>
<script src="{{url("js/sg-formatter.js")}}"></script>
@endif

@if (in_array("fullcalendar", $uses))
<script src="{{skarla_vendor_url("js/jquery-ui-draggable.min.js")}}"></script>
<script src="{{skarla_vendor_url("js/moment.min.js")}}"></script>
<script src="{{skarla_vendor_url("js/fullcalendar.min.js")}}"></script>
@endif

@if (in_array("datatables", $uses))
<script src="{{skarla_vendor_url("js/jquery.dataTables.min.js")}}"></script>
<script src="{{skarla_vendor_url("js/dataTables.bootstrap.min.js")}}"></script>
<script src="{{url("js/datatable-utilities.js")}}"></script>
@endif



@endif
