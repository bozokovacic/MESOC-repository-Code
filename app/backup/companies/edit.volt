{{ form("companies/save", 'role': 'form') }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("companies", "&larr; Natrag") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Snimi", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<h2>Ažuriranje suradnika</h2>

<fieldset>

{% for element in form %}
    {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
{{ element }}
    {% else %}
<div class="form-group">
    {{ element.label(['class': 'control-label']) }}
    <div class="controls">
        {{ element }}
    </div>
</div>
    {% endif %}
{% endfor %}

</fieldset>

</form>
