{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("documentwaitingroom/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("documentwaitingroom/new", "New Template") }}
    </li> -->
</ul>

<h2>DOCUMENT DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>YEAR OF PUB.</th>
            <th>LINK TO DOCUMENT</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ documentwaitingroom.ID_Doc }}</td>
            <td>{{ documentwaitingroom.Title }}</td>
            <td>{{ documentwaitingroom.Keywords }}</td>
            <td>{{ documentwaitingroom.PubYear }}</td>
            <td>{{ documentwaitingroom.Links }}</td>
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
            <td>{{ documentwaitingroom.Summary }}</td>
       	</tr>

    </tbody>
    
</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>BIBLIOGRAPHIC REFERENCE</th>
            <th>NUMBER OF PAGES</th>
            <th>TIME PERIOD OF DATA</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ documentwaitingroom.BiblioRef }}</td>
            <td>{{ documentwaitingroom.NumPages }}</td>
            <td>{{ documentwaitingroom.PeriodFrom }}</td>
  	</tr>

    </tbody>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>FINDINGS AND OUTCOMES</th>         
         </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ documentwaitingroom.FindingsOutcomes }}</td>
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
            <td>{{ documentwaitingroom.OpenAccess }}</td>
            <td>{{ documentwaitingroom.getType().DocType }}</td>
            <td>{{ documentwaitingroom.getLanguage().Language }}</td>
            <td>{{ documentwaitingroom.ID_Template }}</td>
            <td>{{ documentwaitingroom.getCategory().CategoryName }}</td>
	</tr>

    </tbody>

</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>TRANSITION VARIABLE</th>
            <th>KEYWORD TRANSITION VARIABLE</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ documentwaitingroom.transitionvar }}</td>
            <td>{{ documentwaitingroom.keywordtv }}</td>
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
            <td>{{ documentwaitingroom.Author }}</td>
            <td>{{ documentwaitingroom.Institution }}</td>
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
            <td>{{ documentwaitingroom.keywordtv }}</td>
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
            <td>{{ documentwaitingroom.transitionvar }}</td>
	</tr>
    </tbody>

</table> -->

{{ documentwaitingroom.documentwaitingroomview }}

<ul class="pager">
    <li class="previous">
        {{ link_to("documentwaitingroom/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("documentwaitingroom/new", "New Template") }}
    </li> -->
</ul>