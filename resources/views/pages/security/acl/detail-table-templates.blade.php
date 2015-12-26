
<script id="role-access-row-template" type="text/html">
    <form id="role-access-row-form" class="row" role="form" class="container">

        <input type="hidden" name="module_name">

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="input-module-code">Module</label>
                <select name="module_code" id="input-module-code" required class="form-control select2-input" >
                    @foreach($modules AS $module)
                    <option value="{{$module->code}}">{{$module->name}}</option>
                    @endforeach
                </select>
            </div>         
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="input-access-control-code">Access Control</label>
                <select name="access_control_code" id="input-access-control-code" required class="form-control select2-input">
                    @foreach($accessControls AS $accessControl)
                    <option value="{{$accessControl->code}}">{{$accessControl->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</script>