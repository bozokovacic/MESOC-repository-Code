{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("document", "&larr; Back") }}
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

{% for doccountry in page.items %}
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
        <td>{{ doccountry.getCountry().CountryName }}</td>
        <td>{{ doccountry.getRegion().RegionName }}</td>
        <td>{{ doccountry.getCity().CityName }}</td>
        <td with="7%">{{ link_to("document/deletecountry/" ~ doccountry.ID_Country, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No country are recorded.
{% endfor %}  
