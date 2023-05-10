{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("analyse/statistic/"~ ID_Category, "&larr; Statistic") }}
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
</table>

{{ documentsview }}