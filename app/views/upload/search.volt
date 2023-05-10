{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("upload/index", "Search") }}
    </li>   
</ul>

{% for upload in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>UPLOAD ID</th>
            <th>FILE NAME</th>
            <th>USE FILE NAME</th>
            <th>FILE SIZE</th>
            <th>FILE TYPE</th>
            <th>DOWNLOAD</th>
            <th>DOCUMENT ID</th>
            
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ upload.ID_Upload}}</td>
            <td>{{ upload.FileName }}</td>
            <td>{{ upload.UserFileName }}</td>
            <td>{{ upload.FileSizeKB }}</td>
            <td>{{ upload.FileType }}</td>
            <td>{{ upload.Download }}</td>
            <td>{{ upload.ID_Doc}}</td> 
            <td width="7%">{{ link_to("upload/edit/" ~ upload.ID_Upload, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("upload/delete/" ~ upload.ID_Upload, '<i class="glyphicon glyphicon-remove"></i> Delete file', "class": "btn btn-default") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
          <tr>
            <td colspan="11" align="right">
                <div class="btn-group">
                    {{ link_to("upload/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("upload/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("upload/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("upload/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No cultural domain are recorded
{% endfor %}
