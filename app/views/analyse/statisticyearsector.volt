{{ content() }}

<BR>
<a href="/analyse/statistic" class="btn btn-primary">General statistic</a> 
<a href="/analyse/statisticsector" class="btn btn-primary">Cultural sector</a> 
<a href="/analyse/statistictheme" class="btn btn-primary">Cross-over theme</a>
<a href="/analyse/statisticyeardomain" class="btn btn-primary">Year & Cultural sector</a>
<a href="/analyse/statisticyearsector" class="btn btn-primary">Year & Cross-over theme</a> 
<!-- <a href="/analyse/view" class="btn btn-primary">Document by keyword analyse</a> -->
<BR><BR>

{{ link_to("analyse/statisticyearsector/" ~ "0", ' ALL DOCUMENTS', "class": "btn btn-default") }}  
{{ link_to("analyse/statisticyearsector/" ~ "2", ' SCIENTIFIC DOCUMENTS', "class": "btn btn-default") }}  
{{ link_to("analyse/statisticyearsector/" ~ "3", ' GREY LITERATURE', "class": "btn btn-default") }}  
{{ link_to("analyse/statisticyearsector/" ~ "1", ' UNDEFINED', "class": "btn btn-default") }}

<BR> <BR>

{% if ID_Category == 0 %}  {% set category = "ALL DOCUMENTS" %} {% endif %}
{% if ID_Category == 2 %}  {% set category = "SCIENTIFIC DOCUMENTS" %} {% endif %}
{% if ID_Category == 3 %}  {% set category = "GREY LITERATURE" %} {% endif %}
{% if ID_Category == 1 %}  {% set category = "UNDEFINED" %} {% endif %}

{{ statisticview }} 