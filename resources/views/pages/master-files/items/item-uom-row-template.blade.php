<script id="item-uom-row-template" type="text/html">
    <div class="row">
        <form id="item-uom-row-form" role="form" class="container col-sm-12">

            <input type="hidden" name="item_code">        
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="input-uom-code">Unit</label>
                    <select name="uom_code" id="input-uom-code" required class="form-control select2-input" >
                        @foreach($unitsOfMeasurement AS $uom)
                        <option value="{{$uom->code}}">{{$uom->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label" for="input-is-base-uom">Base UOM?</label>
                    <input name="is_base_uom" type="checkbox" class="js-switch" id="input-is-base-uom">
                </div>            

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="input-uom-code">Base Unit</label>
                    <select name="base_uom_code" id="input-uom-code" class="form-control select2-input" >
                        <option disabled selected>-- Select UOM --</option>
                        @foreach($unitsOfMeasurement AS $uom)
                        <option value="{{$uom->code}}">{{$uom->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label" for="input-multiplier">Convert From Unit to Base Unit Multiplier</label>
                    <input name="base_uom_conv_multiplier" id="input-multiplier" placeholder="Ex. 12 for 1pc to 1 Dozen" type="number" class="form-control">
                </div>

                <div class="form-group">
                    <label class="control-label" for="input-divider">Convert From Unit to Base Unit Divider</label>
                    <input name="base_uom_conv_divider" id="input-divider" placeholder="Ex. 12 for 1dozen to 1pc" type="number" class="form-control">
                </div>
            </div>        
        </form>
    </div>
</script>