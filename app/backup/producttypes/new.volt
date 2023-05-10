{{ form("producttypes/create", "autocomplete": "off") }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("producttypes", "&larr; Natrag") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Snimi", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">
    <h2>Stvori grupu djela</h2>

    <div class="clearfix">
        <label for="name">Name</label>
        {{ text_field("name", "size": 24, "maxlength": 70) }}
    </div>
	
	<div class="clearfix">
        <label for="opaska">Opaska</label>
        {{ text_field("opaska", "size": 24, "maxlength": 80) }}
    </div>

</div>
</form>
