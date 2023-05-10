{{ content() }}



{{ form("template/search") }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("template/search", "&larr; Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("document/new", "Create Proposal") }}
    </li>
</ul>

<h2>DOCUMENT PROPOSAL OVERVIEW</h2>

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

