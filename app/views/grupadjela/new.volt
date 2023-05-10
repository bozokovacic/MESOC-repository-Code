{{ form("grupadjela/create", "autocomplete": "off") }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("grupadjela", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Snimi", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">
    <h2>Stvori grupu djela</h2>

    <div class="clearfix">
        <label for="OPIS">Opis</label>
        {{ text_field("OPIS", "size": 24, "maxlength": 70) }}
    </div>
	
	<div class="clearfix">
        <label for="OPASKA">Opaska</label>
        {{ text_field("OPASKA", "size": 24, "maxlength": 70) }}
    </div>

</div>
</form>
