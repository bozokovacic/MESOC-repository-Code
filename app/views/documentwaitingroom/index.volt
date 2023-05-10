{{ content() }}


{{ form("documentwaitingroom/search") }}

<h2>WAITINGROOM OVERVIEW</h2>

<fieldset>

{% for element in form %}
    {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
{{ element }}
    {% else %}
<div class="form-group">
    <div class="controls"> 
        {{ element.label() }}
        {{ element.render(['class': 'form-control']) }}
    </div>
</div>
    {% endif %}
{% endfor %}

<div class="control-group">
    {{ submit_button("Search", "class": "btn btn-primary") }}
</div>

</fieldset>

</form>

