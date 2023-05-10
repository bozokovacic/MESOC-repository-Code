{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/view", "&larr; Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("analyse/analysedocument", "Analyse documents") }}
    </li>
</ul>

<H3> ANALYSIS - DOCUMENT </H3>

{% for analysekeyword in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ANALYSE ID</th>
            <th>ANALYSE NAME</th>
            <th>ANALYSE DESCRIPTION</th>
        </tr>
        <tr>
            <td>{{ analysekeyword.ID_Analyse }}</td>
            <td>{{ analysekeyword.getAnalyse().AnalyseName }}</td>
            <td>{{ analysekeyword.getAnalyse().AnalyseDescription }}</td>
        </tr>
    </thead>
</table>   
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>KEYWORD ID</th>
            <th>KEYWORD NAME</th>
            <th>KEYWORD DESCRIPTION</th>
        </tr>
    </thead>
 {% endif %}
        <tr>
            <td>{{ analysekeyword.ID_Keyword }}</td>
            <td>{{ analysekeyword.getKeyword().KeywordName }}</td>
            <td>{{ analysekeyword.getKeyword().KeywordDescription }}</td>
            <td width="7%">{{ link_to("analysekeyword/delete/" ~ analysekeyword.ID_Keyword, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("analyse/analysekeyword", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("analysekeyword/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("analyse/analysekeyword?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("analysekeyword/?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No analyse keyword are recorded
{% endfor %}
