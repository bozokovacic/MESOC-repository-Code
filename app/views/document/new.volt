
{{ content() }}

<!--
{{ form('document/unos', 'name': 'actionForm', 'method': 'post', 'class':'form-horizontal', 'enctype': 'multipart/form-data') }}
         <input type="text" name="broj">
         <button type="Submit" name="upload", "class": "btn btn-success">ID document</button>
</form>    -->

{{ form("document/create") }}

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("document/view", "&larr; Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <fieldset>

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
