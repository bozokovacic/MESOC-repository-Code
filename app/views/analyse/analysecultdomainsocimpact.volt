{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("analyse/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("analyse/new", "New Analyse") }}
    </li> -->
</ul>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>ANALYSIS ID</th>
            <th>ANALYSIS NAME</th>
            <th>ANALYSE DESCRIPTION</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ analyse.ID_Analyse }}</td>
            <td>{{ analyse.AnalyseName }}</td>
            <td>{{ analyse.AnalyseDescription }}</td>
	</tr>

    </tbody>
    
</table>

            {{ link_to("analyse/analysekeyword/" ~ analyse.ID_Analyse, 'Keywords', "class": "btn btn-primary") }} 

<h3>CULTURAL DOMAIN</h3>

{{ analyse.Analysecultdomainview }}

<h3>SOCIAL IMPACT</h3>

{{ analyse.Analysesocimpactview }}

