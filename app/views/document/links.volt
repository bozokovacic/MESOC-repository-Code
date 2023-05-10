{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("document/view", "&larr; Back") }}
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

             {{ link_to("documentlink/author/adddoc" ~ document.ID_Doc, 'Author', "class": "btn btn-primary") }} {{ link_to("document/author/adddoc" ~ document.ID_Doc, 'Country', "class": "btn btn-primary") }}   
             {{ link_to("documentlink/author/adddoc" ~ document.ID_Doc, 'Search database', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/author/adddoc" ~ document.ID_Doc, 'Technique', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/author/adddoc" ~ document.ID_Doc, 'Relevance', "class": "btn btn-primary") }} 

<!-- <h3>RELEVANCE</h3>

{% for docrelevance in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>RELEVANCE</th>           
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ docrelevance.Relevance }}</td>
        <td with="7%">{{ link_to("document/deleterelevance/" ~ docrelevance.ID_Relevance, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No djela are recorded
{% endfor %}  -->

<!-- <h3>COUNTRY</h3>
{% for doccountry in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>COUNTRY NAME</th>            
            <th>REGION NAME</th>            
            <th>CITY NAME</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ doccountry.CountryName }}</td>
        <td>{{ doccountry.RegionName }}</td>
        <td>{{ doccountry.CityName }}</td>
        <td with="7%">{{ link_to("document/deletedoccountry/" ~ doccountry.ID_Country, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No djela are recorded
{% endfor %}   -->

<!-- <h3>SEARCH DATABASE</h3>
{% for docsearchdatabase in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>SEARCH DATABASE NAME</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ docsearchdatabase.SearchDatabase }}</td>
        <td with="7%">{{ link_to("document/deletesearchdatabase/" ~ docsearchdatabase.ID_Database, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No djela are recorded
{% endfor %}  

 <h3>AUTHORS</h3> -->

<!-- {% for docauthor in page.items %}
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
        <td>{{ docauthor.FirstName }}</td>
        <td>{{ docauthor.LastName }}</td>
        <td>{{ docauthor.InstName }}</td>
        <td>{{ docauthor.CountryName }}</td>
        <td with="7%">{{ link_to("document/deleteauthor/" ~ docauthor.ID_Author, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No djela are recorded
{% endfor %}  -->

<h3>TECHNIQUE</h3>
{% for doctechnique in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>TECHNIQUE NAME</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ doctechnique.getTechnique().TechniqueName }}</td>
        <td with="7%">{{ link_to("document/deletetechnique/" ~ doctechnique.ID_Technique, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No djela are recorded
{% endfor %} 

