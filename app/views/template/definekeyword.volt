{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("template/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("template/new", "New Document") }}
    </li> -->
</ul>

{% for templatekeyword in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ID TEMPLATE</th>
            <th>KEYWORD NUMBER</th>
            <th>KEYWORD TEMPLATE</th>
            <th>KEYWORD DOCUMENT</th>           
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ templatekeyword.ID_Template }}</td>           
            <td>{{ templatekeyword.ID_TemplateKeyword }}</td>           
            <td>{{ templatekeyword.Keyword }}</td> 
            <td>{{ templatekeyword.getKeyword().KeywordName }}</td>          
            {% switch templatekeyword.ID_Keyword %}
                    {% case  0  %}
                        <td width="7%">{{ link_to("template/check/" ~ templatekeyword.ID_Template, '<i class="glyphicon glyphicon-remove"></i>', "class": "btn btn-primary") }}</td> 
                      {% break %}
                    {% default  %}
                        <td width="7%">{{ link_to("template/check/" ~ templatekeyword.ID_Template, '<i class="glyphicon glyphicon-check"></i>', "class": "btn btn-success") }}</td> 
                      {% break %} 
                {% endswitch %}
       </tr>
    </tbody>
{% else %}
    No template are recorded
{% endfor %}

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>
                {{ form("keyword/search/" ~ templatekeyword.ID_TemplateKeyword) }}

                <h3>SEARCH KEYWORD</h3>

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
        </th>
   
        </tr>
    </thead>
    <tbody>
    </tbody>
  
</table>


