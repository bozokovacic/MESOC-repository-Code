{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("type/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("type/new", "New Document") }}
    </li> -->
</ul>


<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>TYPE ID</th>
           <th>DOCUMENT TYPE</th>           
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ ID_Type }}</td>
            <td>{{ DocType }}</td>
	</tr>

    </tbody>

    <table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>CATEGORY NAME</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ categorylist }}</td>
	</tr>

    </tbody>
    
</table>

{% for category in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>CATEGORY ID</th>                       
            <th>CATEGORY NAME</th>                       
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ category.ID_Category }}</td>
        <td>{{ category.CategoryName }}</td>
        <td with="7%">{{ link_to("type/addCategory/" ~ category.ID_Category, '<i class="glyphicon glyphicon-plus"></i>', "class": "btn btn-default") }}</td>
        <td with="7%">{{ link_to("type/deleteCategory/" ~ category.ID_Category, '<i class="glyphicon glyphicon-minus"></i>', "class": "btn btn-default") }}</td>
        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No category are recorded
{% endfor %}  


