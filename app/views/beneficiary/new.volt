{{ form("beneficiary/create/create", "autocomplete": "off") }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("beneficiary/view", "&larr; Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">
    <h2>Create Beneficiary</h2>

<!--	<div class="clearfix">
        <label for="id">Šifra</label>
        {{ text_field("SIFVLA", "size": 10, "maxlength": 20) }}
    </div>    -->
	
    <div class="clearfix">
        <label for="Sector">Beneficiary name</label>
        {{ text_field("BeneficiaryName", "size": 24, "maxlength": 70) }}
    </div>
	
   </div>

</form>
