
{{ content() }}

{{ form("city/create") }}

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("city/view", "&larr; Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <fieldset>

    <h3>CREATE CITY</h3><BR> 

    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
			
            <div class="form-group">
                {{ element.label() }}
                {{ element.render(['class': 'form-control']) }}
            </div>
        {% endif %}
    {% endfor %}

    </fieldset>

</form>
