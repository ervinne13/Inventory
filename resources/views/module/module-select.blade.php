
<select name="{{$name or "module_code"}}" class="form-control selectpicker" required data-live-search="true">
    @foreach($modules AS $module)
    <?php $selected = $value == $module->code ? "selected" : "" ?>
    <option {{$selected}} value="{{$module->code}}">{{$module->description}}</option>
    @endforeach
</select>