{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/view", "&larr; Back") }}
    </li>
</ul>

<H3> ANALYSIS - KEYWORD </H3>

{% for analysedocumentkeywordkeyword in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>ANALYSIS ID</th>
            <th>ANALYSIS NAME</th>
            <th>DOCUMENT ID</th>
            <th>DOCUMENT NAME</th>
            <th>KEYWORD NAME</th>
            <th>KEYWORD COUNT</th>
            <th>ABSTRACT COUNT</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ analysedocumentkeyword.ID_Analyse }}</td>
            <td>{{ analysedocumentkeyword.getAnalyse().AnalyseName }}</td>
            <td>{{ analysedocumentkeyword.ID_Doc }}</td>
            <td>{{ analysedocumentkeyword.getDocument().Title }}</td>
            <td>{{ analysedocumentkeyword.getKeyword().KeywordName }}</td>
            <td>{{ analysedocumentkeyword.KeywordCount }}</td>
            <td>{{ analysedocumentkeyword.AbstractCount }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("analysedocumentkeyword/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("analysedocumentkeyword/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("analysedocumentkeyword/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("analysedocumentkeyword/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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
