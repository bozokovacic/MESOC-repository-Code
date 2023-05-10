{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/view", "&larr; Back to analyse") }}
    </li>
</ul>

<H3> ANALYSIS - DOCUMENT -> KEYWORD </H3>

<!--  <table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ANALYSE ID</th>
            <th>ANALYSE NAME</th>
            <th>DOCUMENT NAME</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ analysedocumentkeyword.ID_Analyse }}</td>
            <td>{{ analysedocumentkeyword.AnalyseName }}</td>
            <td>{{ analysedocumentkeyword.DocumentName }}</td>
            </td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td colspan="6" align="right">
              &nbsp;
            </td>
        </tr>
    </tbody>
</table>  -->

{% for analysedocumentkeyword in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>DOCUMENT ID</th>
            <th>DOCUMENT NAME</th>
        </tr>
    </thead>
        <tr>
            <td>{{ analysedocumentkeyword.ID_Doc }}</td>
            <td>{{ analysedocumentkeyword.getDocument().Title }}</td>
        </tr>
        <tr>
            <td>Keywords: </td>
            <td>{{ analysedocumentkeyword.Keywordview }}</td>
        <tr>    
        </tr>
            <td>Abstract: </td>
            <td>{{ analysedocumentkeyword.Abstractview }}</td>
        </tr>
    <tbody>
  </table>
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>KEYWORD ID</th>
            <th>KEYWORD NAME</th>
            <th>KEYWORDS COUNT</th>
            <th>ABSTRACT COUNT</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ analysedocumentkeyword.ID_Keyword }}</td>
            <td>{{ analysedocumentkeyword.getKeyword().KeywordName }}</td>
            <td>{{ analysedocumentkeyword.KeywordCount }}</td>
            <td>{{ analysedocumentkeyword.AbstractCount }}</td>
            <td width="7%">{{ link_to("analyse/pregledkeyword/" ~ analysedocumentkeyword.ID_Keyword,'<i class="glyphicon glyphicon-edit"></i> View', "class": "btn btn-default") }}</td>        
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
    No document are founded.
{% endfor %}

<!--  <ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/pregled/" ~ analysedocumentkeyword.ID_Analyse,'&larr; Back to document view', "class": "btn btn-default") }}

    </li>
</ul> -->

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/pregled/" ~ analysedocumentkeyword.ID_Analyse,'&larr; Back to document view', "class": "btn btn-blue") }}

    </li>
</ul>