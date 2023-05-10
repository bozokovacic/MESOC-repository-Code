{{ content() }}

<div align="right">
    {{ link_to("producttypes/new", "Stvori grupu djela", "class": "btn btn-primary") }}
</div>

{{ form("producttypes/search", "autocomplete": "off") }}

<div class="center scaffold">

    <h2>Pregled grupe djela</h2>

    <div class="clearfix">
        <label for="id">Šifra</label>
        {{ numeric_field("id", "size": 10, "maxlength": 10) }}
    </div>

    <div class="clearfix">
        <label for="name">Ime</label>
        {{ text_field("name", "size": 24, "maxlength": 70) }}
    </div>
	
	<div class="clearfix">
        <label for="Opaska">Opaska</label>
        {{ text_field("opaska", "size": 24, "maxlength": 70) }}
    </div>

    <div class="clearfix">
        {{ submit_button("Traži", "class": "btn btn-primary") }}
    </div>

</div>

</form>
