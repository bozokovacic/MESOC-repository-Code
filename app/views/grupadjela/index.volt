{{ content() }}

<div align="right">
    {{ link_to("grupadjela/new", "Stvori novu grupu djela", "class": "btn btn-primary") }}
</div>

{{ form("grupadjela/search", "autocomplete": "off") }}

<div class="center scaffold">

    <h2>Pregled grupe djela</h2>

	
    <div class="clearfix">
        <label for="OPIS">Opis</label>
        {{ text_field("OPIS", "size": 24, "maxlength": 70) }}
    </div>

	<div class="clearfix">
        <label for="OPASKA">Opaska</label>
        {{ text_field("OPASKA", "size": 24, "maxlength": 70) }}
    </div>
	
    <div class="clearfix">
        {{ submit_button("Traži", "class": "btn btn-primary") }}
    </div>

</div>

</form>
