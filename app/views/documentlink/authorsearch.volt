{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("documentlink/authorsearch", "&larr; Back") }}
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
             {{ link_to("documentrlink/linkstechnique/" ~ document.ID_Doc, 'Technique', "class": "btn btn-primary") }} 
 <!--            {{ link_to("documentlink/linkslitarea/" ~ document.ID_Doc, 'Literature Area', "class": "btn btn-primary") }}  -->
             {{ link_to("documentlink/linksdataprov/" ~ document.ID_Doc, 'Data provider', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkssector/" ~ document.ID_Doc, 'Sector', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksinstitution/" ~ document.ID_Doc, 'Institution', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linkscultdomainsocimpact/" ~ document.ID_Doc, 'Cult. sector & cross-over theme', "class": "btn btn-primary") }} 
<!--         {{ link_to("documentlink/linksrelevance/" ~ document.ID_Doc, 'Relevance', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksbeneficiary/" ~ document.ID_Doc, 'Beneficiary', "class": "btn btn-primary") }}   -->
 <h3>AUTHORS</h3> 

{% for author in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>LAST NAME</th>            
            <th>FIRST NAME</th>
            <th>MIDLE NAME</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ author.LastName }}</td>
        <td>{{ author.FirstName }}</td>
        <td>{{ author.MiddleNameInitial }}</td>
        <td with="7%">{{ link_to("documentlink/authoradd/" ~ author.ID_Author, ' Add to document', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}
     <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("author/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("author/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
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
