{{ content() }}

<ul class="pager">
    <li class="previous">
        {{ link_to("document", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("document/new", "New Document") }}
    </li> -->
</ul>

{% set innerHtml = '
    Download
    target="_blank"
' %}

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>DOCUMENT ID</th>
            <th>TITLE</th>
            <th>KEYWORDS</th>
            <th>PUB. YEAR</th>
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

{% for upload in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>UPLOAD ID </th>            
            <th>FILE NAME </th>            
            <th>USER FILE NAME </th>            
            <th>FILE TYPE </th>            
            <th>FILE SIZE (KB) </th>            
            <th>DOWNLOAD </th>           
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
        <td>{{ upload.ID_Upload }}</td>
        <td>{{ upload.FileName }}</td>
        <td>{{ upload.UserFileName }}</td>
        <td>{{ upload.FileType }}</td>
        <td>{{ upload.FileSizeKB }}</td>
        <td>{{ upload.Download }}</td>
 
        <td with="7%">{{ link_to("upload/edit/" ~ upload.ID_Upload, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
        <td with="7%">{{ link_to("upload/delete/" ~ upload.ID_Upload, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
<!--        <td with="7%">{{ link_to("../uploads/"~upload.FileName, '<i class="glyphicon glyphicon-download"></i> Download', "class": "btn btn-default") }}</td> -->
        <td with="7%">{{ upload.link }}</td>

        </tr>
    {% if loop.last %}

    </tbody>
  
</table> 
  {% endif %}
{% else %}
    No Upload are recorded.
{% endfor %} 

<h3>ADD UPLOAD TO DOCUMENT</h3>

{{ form('upload/upload', 'name': 'actionForm', 'method': 'post', 'class':'form-horizontal', 'enctype': 'multipart/form-data') }}  

<fieldset>
    
    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}	
            <div class="form-group">
                {{ element.label() }}
                {{ element.render(['class': 'form-control']) }}
            </div>
        {% endif %}
    {% endfor %}

    <div class="form-group">
        <label for="FileName">Choose file</label>
            <div class="controls">
                {{ file_field('FileName', 'class': "form-control") }}
            </div>
    </div>

        <ul class="pager">
            <li class="pull-left">
                {{ submit_button("Upload file", "class": "btn btn-primary") }}
            </li>
        </ul>
</fieldset>

</form>
