<div class="form-group">
    <label class="control-label" for="input-status">Status</label>                        
    <select name="status" id="input-status" class="form-control select2-input" required>
        @foreach($statusList AS $status)
        <?php $selected = $documentStatus == $status ? "selected" : "" ?>
        <option {{$selected}} value="{{$status}}">{{$status}}</option>
        @endforeach
    </select>                      
</div>