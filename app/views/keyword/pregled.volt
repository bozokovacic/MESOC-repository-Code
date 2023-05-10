{{ content() }}

<!-- <ul class="pager">
    <li class="previous">
        {{ link_to("keyword/view", "&larr; Back") }}
    </li>
    <li class="next">
        {{ link_to("keyword/new", "New Keyword") }}
    </li> -->
</ul>


<h2>KEYWORD DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>KEYWORD ID</th>
           <th>KEYWORD</th>
           <th>KEYWORD DESCRIPTION</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ keyword.ID_Keyword }}</td>
            <td>{{ keyword.KeywordName }}</td>
            <td>{{ keyword.KeywordDescription }}</td>
        </tr>

    </tbody>
    
</table>

        {{ keyword.Keywordcultdomainview }}

        {{ keyword.Cultdomainview }}

<!--  {% for culturaldomain in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>            
            <th>CULTURAL DOMAINsdfsfs</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ culturaldomain.CultDomainName }}</td> 
            <td width="7%">{{ link_to("keyword/addcultdomain/" ~ culturaldomain.ID_CultDomain, '<i class="glyphicon glyphicon-edit"></i> Add cultural domain', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("keyword/delcultdomain/" ~ culturaldomain.ID_CultDomain, '<i class="glyphicon glyphicon-remove"></i> Delete cultural domain', "class": "btn btn-default") }}</td>
        </tr>  
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("keyword/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("keyword/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("keyword/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("keyword/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No keywords are recorded.
{% endfor %}   -->



<ul class="pager">
    <li class="previous">
        {{ link_to("keyword/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("keyword/new", "New Keyword") }}
    </li> -->
</ul>