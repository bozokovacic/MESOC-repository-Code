{{ form("upload/savedoc", 'role': 'form') }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("upload/view", "&larr; back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<h2>Upload Update</h2>

<fieldset>

{% for element in form %}
    {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
{{ element }}
    {% else %}
<div class="form-group">
    {{ element.label(['class': 'control-label']) }}
    <div class="controls">
        {{ element }}
    </div>
</div>
    {% endif %}
{% endfor %}

</fieldset>

</form>

{{ form("upload/upload", 'role': 'form') }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("upload/view", "&larr; back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<h2>Upload </h2>


<!-- <form action="" method="post" enctype="multipart/form-data"> -->
    <input type="file" name="file">
    <button type="Submit" name="Read file", "class": "btn btn-success">Import</button>
</form>