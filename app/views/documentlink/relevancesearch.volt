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

             {{ link_to("documentlink/linksauthor/" ~ document.ID_Doc, 'Author', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkscountry/" ~ document.ID_Doc, 'Country', "class": "btn btn-primary") }}   
             {{ link_to("documentlink/linkssearchdatabase/" ~ document.ID_Doc, 'Search database', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkstechnique/" ~ document.ID_Doc, 'Technique', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksrelevance/" ~ document.ID_Doc, 'Relevance', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksbeneficiary/" ~ document.ID_Doc, 'Beneficiary', "class": "btn btn-primary") }}  

 <h3>RELEVANCE</h3> 

{% for relevance in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>RELEVANCE NAME</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ relevance.Relevance }}</td>
        <td with="7%">{{ link_to("documentlink/relevanceadd/" ~ relevance.ID_Relevance, ' Add to document', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No relevance are recorded.
{% endfor %}  
