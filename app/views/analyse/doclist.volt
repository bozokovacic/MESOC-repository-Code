{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("analyse/statistic", "&larr; Back") }}
    </li>
</ul>

<!-- <ul class="pager">
    <li class="previous">
        {{ link_to("document/export", "&larr; Export") }}
    </li>
</ul> -->

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th> CULTURAL DOMAIN: {{ CultDomainName }} </th>            
            <th> CROSS-OVER THEME: {{ SocialImpactName }} </th>
        </tr>
    </thead>
    <tbody>

{% for doclist in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>YEAR OF PUBLICATION</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ doclist.ID_Doc }}</td>
			<td>{{ doclist.getDocument().Title }}</td>
			<td>{{ doclist.getDocument().Keywords }}</td>
			<td>{{ doclist.getDocument().PubYear }}</td>		
			<td width="7%">{{ link_to("analyse/detail/" ~ doclist.ID_Doc, '<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}</td>
    </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
<!--        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                    {{ link_to("analyse/pregleddoc/" ~ ID_Cell, '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("analyse/pregleddoc?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("analyse/pregleddoc?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("analyse/pregleddoc?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr> -->
    </tbody>  
</table>
    {% endif %}
{% else %}
    No document are recorded
{% endfor %}
