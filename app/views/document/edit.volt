
{{ form("document/save", 'role': 'form') }}

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("document/view", "&larr; Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    {{ content() }}
    
<!--    <a href="/upload/upload" class="btn btn-primary">Upload file</a> </div> <BR> 

	<a href="/document/preparecity" class="btn btn-primary">City LAT LON</a> 
	<a href="/document/documentcity" class="btn btn-primary">Document City</a>  
    <BR>
    <a href="/document/documenttransvar" class="btn btn-primary">Document transition variable</a> 
		
    <BR>   -->
    
    <h2>Edit document</h2>

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

    <ul class="pager">
        <li class="previous pull-left">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

</form>
