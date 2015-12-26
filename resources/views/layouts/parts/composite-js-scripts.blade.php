
@if (isset($uses))

@if (in_array("sg-formatter", $uses))
<script src="{{skarla_vendor_url("js/moment.min.js")}}"></script>
<script src="{{url("js/sg-formatter.js")}}"></script>
@endif

@if (in_array("sg-table", $uses))

@include('templates.default-dropdown-table-actions')

<script src="{{url("vendor/underscore/underscore.js")}}"></script>
<script src="{{url("js/sg-formatter.js")}}"></script>
<script src="{{url("js/sg-table-row-utilities.js")}}"></script>
<script src="{{url("js/sg-table.js")}}"></script>
@endif

@if (in_array("datepicker", $uses))
<script src="{{skarla_vendor_url("js/moment.min.js")}}"></script>
<script src="{{skarla_vendor_url("js/daterangepicker.min.js")}}"></script>
@endif

@if (in_array("fullcalendar", $uses))
<script src="{{skarla_vendor_url("js/jquery-ui-draggable.min.js")}}"></script>
<script src="{{skarla_vendor_url("js/moment.min.js")}}"></script>
<script src="{{skarla_vendor_url("js/fullcalendar.min.js")}}"></script>
@endif

@if (in_array("datatables", $uses))

@include('templates.table-inline-actions')

<script src="{{skarla_vendor_url("js/moment.min.js")}}"></script>
<script src="{{url("js/sg-formatter.js")}}"></script>

<script src="{{skarla_vendor_url("js/jquery.dataTables.min.js")}}"></script>
<script src="{{skarla_vendor_url("js/dataTables.bootstrap.min.js")}}"></script>
<script src="{{url("vendor/underscore/underscore.js")}}"></script>
<script src="{{url("js/datatable-utilities.js")}}"></script>
@endif

@if (in_array("form", $uses))
<script src="{{url("vendor/underscore/underscore.js")}}"></script>
<script src="{{url("vendor/jquery-validation/jquery.validate.js")}}"></script>
<script src="{{url("js/form-utilities.js")}}"></script>

<!--Switchery-->
<script src="{{url("vendor/bower_components/switchery/dist/switchery.min.js")}}"></script>
@endif

@endif
