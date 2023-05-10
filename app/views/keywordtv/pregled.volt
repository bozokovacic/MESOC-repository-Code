{{ content() }}

<!-- <ul class="pager">
    <li class="previous">
        {{ link_to("keywordtv/view", "&larr; Back") }}
    </li>
    <li class="next">
        {{ link_to("keywordtv/new", "New Keyword") }}
    </li> -->
</ul>


<h2>KEYWORD TRANSITION VARIABLE DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>KEYWORD TRAN_VAR. ID</th>
           <th>KEYWORD TRANSITION VARIABLE</th>
           <th>KEYWORD TRANSITION VARIABLE DESCRIPTION</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ keywordtv.ID_Keyword }}</td>
            <td>{{ keywordtv.KeywordtvName }}</td>
            <td>{{ keywordtv.KeywordtvDescription }}</td>
        </tr>

    </tbody>
    
</table>

        {{ keywordtv.Keywordtvcultdomainview }}

        {{ keywordtv.Cultdomainview }}

<!--  {% for culturaldomain in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>            
            <th>CULTURAL DOMAIN</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ culturaldomain.CultDomainName }}</td> 
            <td width="7%">{{ link_to("keywordtv/addcultdomain/" ~ culturaldomain.ID_CultDomain, '<i class="glyphicon glyphicon-edit"></i> Add cultural domain', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keywordtv/delcultdomain/" ~ culturaldomain.ID_CultDomain, '<i class="glyphicon glyphicon-remove"></i> Delete cultural domain', "class": "btn btn-default") }}</td>
        </tr>  
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("keywordtv/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("keywordtv/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("keywordtv/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("keywordtv/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No keywords  transition variable are recorded.
{% endfor %}   -->



<ul class="pager">
    <li class="previous">
        {{ link_to("keywordtv/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("keywordtv/new", "New Keyword") }}
    </li> -->
</ul>