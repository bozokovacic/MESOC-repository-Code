{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("template/view/" ~ view, "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("template/new", "New Template") }}
    </li> -->
</ul>

<h2>DOCUMENT DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>PROPOSAL ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>YEAR OF PUB.</th>
            <th>LINK TO DOCUMENT</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ template.ID_Proposal }}</td>
            <td>{{ template.Title }}</td>
            <td>{{ template.Keywords }}</td>
            <td>{{ template.PubYear }}</td>
            <td>{{ template.Links }}</td>
	</tr>

    </tbody>
    
</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>SUMMARY</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ template.Summary }}</td>
       	</tr>

    </tbody>
    
</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>RELEVANCE</th>
            <th>NUMBER OF PAGES</th>
            <th>TIME PERIOD OF DATA</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ template.Relevance }}</td>
            <td>{{ template.NumPages }}</td>
            <td>{{ template.PeriodFrom }}</td>
  	</tr>

    </tbody>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>FINDINGS AND OUTCOMES</th>         
            <th>BIBLIOGRAPHIC REFERENCE</th>
         </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ template.FindingsOutcomes }}</td>
            <td>{{ template.BiblioRef }}</td>
 	</tr>

    </tbody>

</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>OPEN ACCESS</th>
            <th>DOCUMENT TYPE</th>
            <th>LANGUAGE</th>
            <th>TEMPLATE ID</th>
            <th>CATEGORY</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ template.OpenAccess }}</td>
            <td>{{ template.getType().DocType }}</td>
            <td>{{ template.getLanguage().Language }}</td>
            <td>{{ template.ID_Proposal }}</td>
            <td>{{ template.getCategory().CategoryName }}</td>
	</tr>

    </tbody>

</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>AUTHOR</th>
            <th>INSTITUTION</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ template.Author }}</td>
            <td>{{ template.Institution }}</td>
	</tr>

    </tbody>

</table>

<!-- <table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>KEYWORD TRANSITION VARIABLES</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ template.keywordtv }}</td>
	</tr>
    </tbody>

</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>TRANSITION VARIABLES</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ template.transitionvar }}</td>
	</tr>
    </tbody>

</table> -->

{{ template.templateview }}

<ul class="pager">
    <li class="previous">
        {{ link_to("template/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("template/new", "New Template") }}
    </li> -->
</ul>