
{{ form("template/save", 'role': 'form') }}

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("template/view/" ~ view, "&larr; Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    {{ content() }}

    <h3>EDIT TEMPLATE</h3>

    <fieldset>

<!--        {{ template.templatecultdomainsocimpact }}  -->

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
<!--        <div class="checkbox">
        <label>
            Remember me
            <input type="checkbox" value="remember-me">
          
        </label>
        </div>  -->
    </fieldset>

</form>
