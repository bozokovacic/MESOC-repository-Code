{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("document/search", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New Document") }}
    </li> -->
</ul>


<h2>DOCUMENT DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>PUB. YEAR</th>
            <th>LINKS</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.ID_Doc }}</td>
            <td>{{ document.Title }}</td>
            <td>{{ document.Keywords }}</td>
            <td>{{ document.PubYear }}</td>
            <td>{{ document.Links }}</td>
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
            <td>{{ document.Summary }}</td>
       	</tr>

    </tbody>
    
</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>BIBLIO. REF</th>
            <th>PAGE NUM.</th>
            <th>PERIOD FROM</th>
            <th>PERIOD TO</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.BiblioRef }}</td>
            <td>{{ document.NumPages }}</td>
            <td>{{ document.PeriodFrom }}</td>
            <td>{{ document.PeriodTo }}</td>
	</tr>

    </tbody>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>METHODOLOGY</th>
            <th>DATA PROVIDERS</th>
            <th>ANALITY. LIMIT.</th>
         </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.Methodology }}</td>
            <td>{{ document.DataProviders }}</td>
            <td>{{ document.AnalytLimitations  }}</td>
 	</tr>

    </tbody>

</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>OPEN ACCESS</th>
            <th>LINK</th>
            <th>SCOPE</th>
            <th>TYPE</th>
            <th>LANGUAGE</th>
            <th>SECTOR</th>
            <th>LITER. AREA</th>
<!--            <th>CREATED AT</th>  -->
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.OpenAccess }}</td>
            <td>{{ document.Links }}</td>
            <td>{{ document.Scope }}</td>
            <td>{{ document.getType().DocType }}</td>
            <td>{{ document.getLanguage().Language }}</td>
            <td>{{ document.getSector().SectorName }}</td>
            <td>{{ document.getLitarea().LiteratureArea }}</td>
<!--            <td>{{ document.CreatedAt }}</td> -->
	</tr>

    </tbody>

</table>

<ul class="pager">
    <li class="previous">
        {{ link_to("document", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New Document") }}
    </li> -->
</ul>