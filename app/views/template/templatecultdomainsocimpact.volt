{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("template/view/" ~ view, "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("template/new", "New Template") }}
    </li> -->
</ul>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>PROPOSAL ID</th>
            <th>TITLE</th>
            <th>PUB. YEAR</th>
            <th>LINKS</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ template.ID_Proposal }}</td>
            <td>{{ template.Title }}</td>
            <td>{{ template.PubYear }}</td>
            <td>{{ template.Links }}</td>
	</tr>

    </tbody>
    
</table>
            
<H3> CULTURAL DOMAIN </H3>

{{ template.Templatecultdomain }}

<H3> SOCIAL IMPACT </H3>

{{ template.Templatesocimpact }}

