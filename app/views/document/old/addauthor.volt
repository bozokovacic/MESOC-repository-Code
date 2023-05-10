{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("document/search", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New Document") }}
    </li> -->
</ul>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>PUB. YEAR</th>
            <th>LINKS</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.ID_Doc }}</td>
            <td>{{ document.Title }}</td>
            <td>{{ document.Keywords }}</td>
            <td>{{ document.PubYear }}</td>
            <td>{{ document.Links }}</td>
	</tr>

    </tbody>
    
</table>

             {{ link_to("document/linksauthor/" ~ document.ID_Doc, 'Author', "class": "btn btn-primary") }} 
             {{ link_to("document/linkscountry/" ~ document.ID_Doc, 'Country', "class": "btn btn-primary") }}   
             {{ link_to("document/linkssearchdatabase/" ~ document.ID_Doc, 'Search database', "class": "btn btn-primary") }} 
             {{ link_to("document/linkstechnique/" ~ document.ID_Doc, 'Technique', "class": "btn btn-primary") }} 
             {{ link_to("document/linksrelevance/" ~ document.ID_Doc, 'Relevance', "class": "btn btn-primary") }} 

 <h3>AUTHORS</h3> 

{% for docauthor in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>NAME</th>            
            <th>SURNAME</th>
            <th>INSTITUTION</th>
            <th>COUNTRY</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ docauthor.getAuthor().FirstName }}</td>
        <td>{{ docauthor.getAuthor().LastName }}</td>
        <td>{{ docauthor.getInstitution().InstName }}</td>
        <td>{{ docauthor.getCountry().CountryName }}</td>
        <td with="7%">{{ link_to("document/deleteauthor/" ~ docauthor.ID_Author, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No author are recorded.
{% endfor %}  

{{ form("document/searchauthor/" ~ document.ID_Doc) }}

<h3>AUTHOR OVERVIEW</h3>

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
