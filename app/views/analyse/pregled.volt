{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/view", "&larr; Back") }}
    </li>
</ul>

<H3> ANALYSIS - DOCUMENT </H3>

{% for analysedocument in page.items %}
{% if loop.first %}
  <table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ANALYSIS ID</th>
            <th>ANALYSIS NAME</th>
            <th>ANALYSIS DESCRIPTION</th>
        </tr>
    </thead>
    <tr>
            <td>{{ analysedocument.ID_Analyse }}</td>
            <td>{{ analysedocument.getAnalyse().AnalyseName }}</td>
            <td>{{ analysedocument.getAnalyse().AnalyseDescription }}</td>
        </tr>
    <tbody>
  </table>
  {{ analysedocument.getAnalyse().Analyseview }}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DOCUMENT ID</th>
            <th>DOCUMENT NAME</th>
            <th>KEYWORD COUNT</th>
            <th>ABSTRACT COUNT</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ analysedocument.ID_Doc }}</td>
            <td>{{ analysedocument.getDocument().Title }}</td>
            <td>{{ analysedocument.KeywordCount }}</td>
            <td>{{ analysedocument.AbstractCount }}</td>
            <td width="7%">{{ link_to("analyse/pregledkeyword/" ~ analysedocument.ID_Doc,'<i class="glyphicon glyphicon-edit"></i> Detail', "class": "btn btn-default") }}</td>        
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("analysedocument/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("analysedocument/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("analysedocument/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("analysedocument/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}                    
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No document are founded or document analysis is not performed.
{% endfor %}
