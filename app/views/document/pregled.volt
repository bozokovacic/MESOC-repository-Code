{{ content() }}

<ul class="pager">
    <li class="previous">
	{% if View == 'SEARCH' %}           
		{{ link_to("document/search", "Back") }}              
        {% endif  %}     
	{% if View == 'ALL' %}           
		{{ link_to("document/view", "Back") }}              
        {% endif  %}     

    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New Document") }}
    </li> -->
</ul>

<h2>DOCUMENT DATA</h2>

{% set Category = ID_Category %}

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
            <th>FINDINGS AND OUTCOMES</th>         
            {% if Category == 1 %} <th>METHODOLOGY</th> {% endif  %}    
            {% if Category == 2 %} <th>METHODOLOGY</th> {% endif  %}    
            {% if Category == 3 %} <th>TARGET GROUP</th> {% endif  %}    
<!--            <th>ANALITY. LIMIT.</th>  -->
         </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.FindingsOutcomes }}</td>
            {% if Category == 1 %} <td>{{ document.Methodology }}</td> {% endif  %}    
            {% if Category == 2 %} <td>{{ document.Methodology }}</td> {% endif  %}    
            {% if Category == 3 %} <td>{{ document.Targetgroup }}</td> {% endif  %}    
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
            {% if Category == 1 %} <th>RELAVANCE</th> {% endif  %}    
            {% if Category == 2 %} <th>RELAVANCE</th> {% endif  %}    
<!--            <th>TEMPLATE ID</th>  -->
            {% if Category == 1 %} <th>DOI</th> {% endif  %}                
            {% if Category == 2 %} <th>DOI</th> {% endif  %}                
            <th>CATEGORY</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ document.OpenAccess }}</td>
            <td>{{ document.getType().DocType }}</td>
            <td>{{ document.getLanguage().Language }}</td>
            {% if Category == 1 %} <td>{{ document.Relevance }}</td> {% endif  %}                
            {% if Category == 2 %} <td>{{ document.Relevance }}</td> {% endif  %}                
<!--            {% if Category == 2 %} <td>{{ document.ID.Template }}</td> {% endif  %} -->
            {% if Category == 1 %} <td>{{ document.DOI }}</td> {% endif  %}                             
            {% if Category == 2 %} <td>{{ document.DOI }}</td> {% endif  %}                            
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
        {{ link_to("document/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New Document") }}
    </li> -->
</ul>