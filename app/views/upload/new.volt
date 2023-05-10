<!-- {{ form("upload/create") }} -->

{{ form('upload/create', 'name': 'actionForm', 'method': 'post', 'class':'form-horizontal', 'enctype': 'multipart/form-data') }}      

    <h2>UPLOAD FILE</h2>

    <fieldset>
    
    <div class="form-group">
        <label for="FileName">Choose file</label>
            <div class="controls">
                {{ file_field('FileName', 'class': "form-control") }}
            </div>
    </div>
    
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

<ul class="pager">
        <li class="pull-left">
            {{ submit_button("Upload file", "class": "btn btn-success") }}
        </li>
    </ul>