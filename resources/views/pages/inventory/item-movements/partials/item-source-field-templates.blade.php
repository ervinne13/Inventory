<script id="textfield-item-source-template" type="text/html">
    <input name="item_source" value="<%= value %>" id="input-item-source" required placeholder="Source of the item or supplier if this is a purchase order" type="text" class="form-control">
</script>

<script id="select-item-source-template" type="text/html">
    <select name="item_source" data-value="<%= value %>" id="input-item-source" required placeholder="Source of the item or supplier if this is a purchase order" class="form-control">
        @foreach($suppliers AS $supplier)
        <% let selected = value == '{{$supplier->supplier_number}}' ? 'selected' : '' %>
        <option value="{{$supplier->supplier_number}}" <%= selected %>>{{$supplier->display_name}}</option>
        @endforeach
    </select>
</script>