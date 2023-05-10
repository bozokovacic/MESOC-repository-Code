{{ content() }}

<ul class="pager">
    <li class="previous">
      {% if Type == 1 %}
        {{ link_to("analyse/pregleddoc/" ~ ID_Cell, "&larr; List") }}
        {{ link_to("analyse/statistic/"~ ID_Category, "&larr; Statistic") }}
      {% endif  %} 
      {% if Type == 2 %}
        {{ link_to("analyse/pregleddocsector/" ~ ID_Domain, "&larr; List") }}
        {{ link_to("analyse/statisticsector/"~ ID_Category, "&larr; Statistic") }}
      {% endif  %} 
      {% if Type == 3 %}
        {{ link_to("analyse/pregleddoctheme/" ~ ID_Theme, "&larr; List") }}
        {{ link_to("analyse/statistictheme/"~ ID_Category, " &larr; Statistic") }}
      {% endif  %} 
      {% if Type == 4 %}
        {{ link_to("analyse/pregledyeardomain/" ~ ID_Cell, "&larr; List") }}
        {{ link_to("analyse/statisticyeardomain/"~ ID_Category, " &larr; Statistic") }}
      {% endif  %} 
      {% if Type == 5 %}
        {{ link_to("analyse/pregledyearsector/" ~ ID_Cell, "&larr; List") }}
        {{ link_to("analyse/statisticyearsector/"~ ID_Category, " &larr; Statistic") }}
      {% endif  %} 
    </li>
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
            <th>BIBLIOGRAPHIC REFERENCE</th>
            <th>NUMBER OF PAGES</th>
            <th>TIME PERIOD OF DATA</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.BiblioRef }}</td>
            <td>{{ document.NumPages }}</td>
            <td>{{ document.PeriodFrom }}</td>
  	</tr>

    </tbody>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>METHODOLOGY</th>
            <th>FINDINGS AND OUTCOMES</th>         
<!--            <th>ANALITY. LIMIT.</th>  -->
         </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.Methodology }}</td>
            <td>{{ document.FindingsOutcomes }}</td>
<!--            <td>{{ document.AnalytLimitations  }}</td>  -->
 	</tr>

    </tbody>

</table>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>OPEN ACCESS</th>
            <th>DOCUMENT TYPE</th>
            <th>LANGUAGE</th>
            <th>RELEVANCE</th>
            <th>TEMPLATE ID</th>
            <th>DOI</th>
            <th>CATEGORY</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.OpenAccess }}</td>
            <td>{{ document.getType().DocType }}</td>
            <td>{{ document.getLanguage().Language }}</td>
            <td>{{ document.Relevance }}</td>
            <td>{{ document.ID_Template }}</td>
            <td>{{ document.DOI }}</td>
            <td>{{ document.getCategory().CategoryName }}</td>
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
            <td>{{ document.keywordtv }}</td>
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
            <td>{{ document.transitionvar }}</td>
	</tr>
    </tbody>

</table> -->

{{ document.docview }}

<ul class="pager">
    <li class="previous">
      {% if Type == 1 %}
        {{ link_to("analyse/pregleddoc/" ~ ID_Cell, "&larr; Back") }}
      {% endif  %} 
      {% if Type == 2 %}
        {{ link_to("analyse/pregleddocsector/" ~ ID_CultDomain, "&larr; Back") }}
      {% endif  %} 
      {% if Type == 3 %}
        {{ link_to("analyse/pregleddoctheme/" ~ ID_SocImpact, "&larr; Back") }}
      {% endif  %} 
      {% if Type == 4 %}
        {{ link_to("analyse/pregledyeardomain/" ~ ID_Cell, "&larr; Back") }}
      {% endif  %} 
      {% if Type == 5 %}
        {{ link_to("analyse/pregledyearsector/" ~ ID_Cell, "&larr; Back") }}
      {% endif  %} 
    </li>
</ul>