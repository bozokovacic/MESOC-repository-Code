{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("analyse/statisticyeardomain/" ~ ID_Category, "&larr; Statistic") }}
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
            <th> YEAR: {{ Year }} </th>
            <th> CULTURAL DOMAIN: {{ CultDomainName }} </th>
        </tr>
    </thead>
</table>

{{ documentsview }}
