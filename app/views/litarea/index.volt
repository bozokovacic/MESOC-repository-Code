{{ content() }}

<div align="right">
    {{ link_to("litarea/new", "Create literature type", "class": "btn btn-primary") }}
</div>

{{ form("litarea/search") }}

<h2>LITERATURE AREA OVERVIEW</h2>

<fieldset>

{% for element in form %}
    {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
{{ element }}
    {% else %}
<div class="control-group">
    {{ element.label(['class': 'control-label']) }}
    <div class="controls">
        {{ element }}
    </div>
</div>
    {% endif %}
{% endfor %}

<div class="control-group">
    {{ submit_button("Traži", "class": "btn btn-primary") }}
</div>

</fieldset>

</form>
