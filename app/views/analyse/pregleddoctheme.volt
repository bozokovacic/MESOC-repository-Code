{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("analyse/statistictheme/" ~ ID_Category, "&larr; Statistic") }}
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
            <th> CROSS-OVER THEME: {{ SocImpactName }} </th>
        </tr>
    </thead>
    <tbody>

{{ documentsview }}