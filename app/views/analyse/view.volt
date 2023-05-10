{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/index", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("analyse/new", "Create analysis") }}
    </li>
</ul>

{% for analyse in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ANALYSIS ID</th>
            <th>ANALYSIS NAME</th>
            <th>ANALYSIS DESCRIPTION</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ analyse.ID_Analyse }}</td>
            <td>{{ analyse.AnalyseName }}</td>
            <td>{{ analyse.AnalyseDescription }}</td>
                    <td width="7%">{{ link_to("analyse/edit/" ~ analyse.ID_Analyse, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
                    <td width="7%">{{ link_to("analyse/delete/" ~ analyse.ID_Analyse, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
                    <td width="7%">{{ link_to("analyse/analysecultdomainsocimpact/" ~ analyse.ID_Analyse,'<i class="glyphicon glyphicon-edit"></i> Cult. domain & soc. impact', "class": "btn btn-default") }}</td>       
                    <td width="7%">{{ link_to("analyse/pregled/" ~ analyse.ID_Analyse,'<i class="glyphicon glyphicon-edit"></i> View', "class": "btn btn-default") }}</td>        
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("analyse/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("analyse/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("analyse/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("analyse/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No analysis are recorded
{% endfor %}
