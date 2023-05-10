{{ content() }}

<div align="right">
    {{ link_to("socialimpact/new", "Create cross-over theme", "class": "btn btn-primary") }}
</div>

{{ form("socialimpact/search") }}

<h3>CROSS-OVER THEME NAME OVERVIEW</h3>

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
    {{ submit_button("Search", "class": "btn btn-primary") }}
</div>

</fieldset>

</form>
