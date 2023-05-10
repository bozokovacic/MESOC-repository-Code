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
<!--             {{ link_to("documentlink/linksrelevance/" ~ document.ID_Doc, 'Relevance', "class": "btn btn-primary") }} 
             {{ link_to("documentlink/linksbeneficiary/" ~ document.ID_Doc, 'Beneficiary', "class": "btn btn-primary") }}   -->      

 <h3>SECTOR</h3> 

{% for docsector in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>SECTOR NAME</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ docsector.getSector().SectorName }}</td>
        <td with="7%">{{ link_to("documentlink/sectordelete/" ~ docsector.ID_Sector, '<i class="glyphicon glyphicon-remove"></i> Delete sector', "class": "btn btn-default") }}</td>
			
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No author are recorded.
{% endfor %}  

{{ form("documentlink/sectorsearch/" ~ document.ID_Doc) }}

<h3>ADD SECTOR</h3>

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
