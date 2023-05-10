{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("documentwaitingroom/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("documentwaitingroom/new", "New documentwaitingroom") }}
    </li> -->
</ul>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>PUB. YEAR</th>
            <th>LINKS</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ documentwaitingroom.ID_Doc }}</td>
            <td>{{ documentwaitingroom.Title }}</td>
            <td>{{ documentwaitingroom.PubYear }}</td>
            <td>{{ documentwaitingroom.Links }}</td>
	</tr>

    </tbody>
    
</table>
            
<H3> CULTURAL DOMAIN </H3>

{{ documentwaitingroom.documentcultdomainview }}

<H3> SOCIAL IMPACT </H3>

{{ documentwaitingroom.documentsocimpactview }}

