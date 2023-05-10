{{ content() }}

<div align="right">
    {{ link_to("keywordtv/new", "Create keyword transition variable", "class": "btn btn-primary") }}
</div>

{{ form("keywordtv/search") }}

<h2>KEYWORDS TRANSITION VARIABLE OVERVIEW</h2>

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