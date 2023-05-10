{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("analyse/view", "&larr; Back") }}
    </li>
</ul>

{% for analysestatistic in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>No.</th>
            <th>CULTURAL SECTOR</th>
            <th>HEALT AND WELLBEING</th>
            <th>URBAN AND TERITORIAL RENOVATION</th>
            <th>PEOPLE'S ENGAGMENT AND PARTICIPATION</th>
            <th>TOTAL</th>
            <th>GENERAL</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ analysestatistic.row }}</td>
            <td>{{ analysestatistic.sector1 }}</td>
            <td>{{ analysestatistic.sector2 }}</td>
            <td>{{ analysestatistic.sector3 }}</td>
            <td>{{ analysestatistic.total }}</td>
            <td>{{ analysestatistic.general }}</td>
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
