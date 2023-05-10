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
<!--            {{ link_to("documentlink/linkslitarea/" ~ document.ID_Doc, 'Literature Area', "class": "btn btn-primary") }}   -->
            {{ link_to("documentlink/linksdataprov/" ~ document.ID_Doc, 'Data provider', "class": "btn btn-primary") }} 
            {{ link_to("documentlink/linkssector/" ~ document.ID_Doc, 'Sector', "class": "btn btn-primary") }} 
            {{ link_to("documentlink/linksinstitution/" ~ document.ID_Doc, 'Institution', "class": "btn btn-primary") }}  
            {{ link_to("documentlink/linkscultdomainsocimpact/" ~ document.ID_Doc, 'Cult. domain & Soc. impact', "class": "btn btn-primary") }} 
<!--        {{ link_to("documentlink/linksrelevance/" ~ document.ID_Doc, 'Relevance', "class": "btn btn-primary") }} 
            {{ link_to("documentlink/linksbeneficiary/" ~ document.ID_Doc, 'Beneficiary', "class": "btn btn-primary") }}   -->

 

 <h3>RESEARCH</h3> 

{% for doccountry in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>COUNTRY CODE</th>            
            <th>COUNTRY NAME</th>
            <th>REGION</th>  
            <th>CITY NAME</th>      
            <th>TERIT. CONTEXT</th>      
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
<!--            <td>{{ doccountry.ID_Research }}</td> -->
            <td>{{ doccountry.getCountry().CountryCode }}</td>
            <td>{{ doccountry.getCountry().CountryName }}</td>
            <td>{{ doccountry.getRegion().RegionName }}</td>
            <td>{{ doccountry.getCity().CityName }}</td>
            <td>{{ doccountry.TeritCon }}</td>
            <td with="7%">{{ link_to("documentresearch/countrydelete/" ~ doccountry.ID_Research,'<i class="glyphicon glyphicon-remove"></i> Delete Country', "class": "btn btn-default") }}
                {% switch doccountry.ID_Region %}
                    {% case  1  %}
                        {{ link_to("documentresearch/countryselectRegion/" ~ doccountry.ID_Research,'<i class="glyphicon glyphicon-remove"></i> Define Region', "class": "btn btn-default") }}    
                    {% break %}
                    {% default %}
                        {{ link_to("documentresearch/countrydelRegion/" ~ doccountry.ID_Research,'<i class="glyphicon glyphicon-remove"></i> Delete Region', "class": "btn btn-default") }}        
                {% endswitch %} 
                {% switch doccountry.ID_City %}
                    {% case  1  %}
                        {{ link_to("documentresearch/countryselectCity/" ~ doccountry.ID_Research,'<i class="glyphicon glyphicon-remove"></i> Define City', "class": "btn btn-default") }}    
                    {% break %}
                    {% default %}
                        {{ link_to("documentresearch/countrydelCity/" ~ doccountry.ID_Research,'<i class="glyphicon glyphicon-remove"></i> Delete City', "class": "btn btn-default") }}        
                {% endswitch %} 
<!--                {% switch doccountry.ID_TeritCon %}
                    {% case  1  %}
                        {{ link_to("documentresearch/countryselectTeritcon/" ~ doccountry.ID_Research,'<i class="glyphicon glyphicon-remove"></i> Define Context', "class": "btn btn-default") }}    
                    {% break %}
                    {% default %}
                        {{ link_to("documentresearch/countrydelTeritcon/" ~ doccountry.ID_Research,'<i class="glyphicon glyphicon-remove"></i> Delete Context', "class": "btn btn-default") }}        
                {% endswitch %}    -->
            </td>
       </tr>
    {% if loop.last %}
          <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("country/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("country/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("country/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("country/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
      <tbody>
    </tbody>
  
</table> 

{% endif %}
{% else %}
    No country are defined.
{% endfor %}  

{{ form("documentresearch/countrysearch/" ~ document.ID_Doc) }}

<h3>COUNTRY OVERVIEW</h3>

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
