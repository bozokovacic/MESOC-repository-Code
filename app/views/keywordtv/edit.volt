{{ form("keywordtv/save", 'role': 'form') }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("keywordtv/view", "&larr; Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<BR>
    <a href="/keywordtv/dockey" class="btn btn-primary">Document Keyword</a> <BR>
    <BR> 
    <a href="/keywordtv/preparecity" class="btn btn-primary">City LAT LON</a> 
    <BR>
    <BR>
    <a href="/keywordtv/documentcity" class="btn btn-primary">Document City</a> 
    <BR>
<h2>UPDATE KEYWORD TRANSITION VARIABLE</h2>

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
