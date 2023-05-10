{{ form("language/create", "autocomplete": "off") }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("language/view", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">

    <h3>CREATE LANGUAGE</h3><BR>

    <div class="clearfix">
        <label for="LANGUAGE">LANGUAGE: </label>
        {{ text_field("Language", "size": 24, "maxlength": 70) }}
    </div>

</div>
</form>
