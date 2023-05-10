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
            <th>LINK TO DOCUMENT</th>
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

             {{ link_to("documentlink/linksauthor/" ~ document.ID_Doc, 'Author', "class": "btn btn-primary") }} 
             {{ link_to("documentresearch/linkscountry/" ~ document.ID_Doc, 'Territorial context', "class": "btn btn-primary") }}   
             {{ link_to("documentlink/linkssearchdatabase/" ~ document.ID_Doc, 'Search database', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkstechnique/" ~ document.ID_Doc, 'Technique', "class": "btn btn-primary") }} 
<!--             {{ link_to("documentlink/linkslitarea/" ~ document.ID_Doc, 'Literature Area', "class": "btn btn-primary") }} -->
             {{ link_to("documentlink/linksdataprov/" ~ document.ID_Doc, 'Data provider', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkssector/" ~ document.ID_Doc, 'Sector', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksinstitution/" ~ document.ID_Doc, 'Institution', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkscultdomainsocimpact/" ~ document.ID_Doc, 'Cult. sector & cross-over theme', "class": "btn btn-primary") }} 
<!--         {{ link_to("documentlink/linksrelevance/" ~ document.ID_Doc, 'Relevance', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksbeneficiary/" ~ document.ID_Doc, 'Beneficiary', "class": "btn btn-primary") }}   -->

 <h3>SEARCH AUTHOR</h3> 

{% for docauthor in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>LAST NAME</th>
            <th>FIRST NAME</th>            
            <th>INSTITUTION</th>
            <th>COUNTRY</th>        
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ docauthor.getAuthor().LastName }}</td>
            <td>{{ docauthor.getAuthor().FirstName }}</td>
            <td>{{ docauthor.getInstitution().InstName }}</td>
            <td>{{ docauthor.getCountry().CountryName }}</td>
            <td with="15%">
                        {{ link_to("documentlink/authordelete/" ~ docauthor.ID_Author, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}               
                {% switch docauthor.ID_Institution %}
                    {% case  1  %}
                        {{ link_to("documentlink/authorselectInst/" ~ docauthor.ID_Author,'<i class="glyphicon glyphicon-edit"></i> Define institution', "class": "btn btn-default") }}    
                        {{ link_to("documentlink/authorselectCountry/" ~ docauthor.ID_Author,'<i class="glyphicon glyphicon-edit"></i> Define Country', "class": "btn btn-default") }}        
                    {% break %}
                    {% default %}
                        {{ link_to("documentlink/authordelInst/" ~ docauthor.ID_Author,'<i class="glyphicon glyphicon-remove"></i> Delete institution', "class": "btn btn-default") }}        
                {% endswitch %} 
            </td>
			
        </tr>
    {% if loop.last %}
       <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("author/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
      <tbody>
    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No author are recorded.
{% endfor %}  

{{ form("documentlink/authorsearch/" ~ document.ID_Doc) }}

<h3>ADD AUTHOR</h3>

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
