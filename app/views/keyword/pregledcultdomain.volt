{{ content() }}

<!-- <ul class="pager">
    <li class="previous">
        {{ link_to("keyword/view", "&larr; Back") }}
    </li>
    <li class="next">
        {{ link_to("keyword/new", "New Keyword") }}
    </li> -->
</ul>


<h2>KEYWORD DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>KEYWORD ID</th>
           <th>KEYWORD</th>
           <th>KEYWORD DESCRIPTION</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ keyword.ID_Keyword }}</td>
            <td>{{ keyword.KeywordName }}</td>
            <td>{{ keyword.KeywordDescription }}</td>
        </tr>

    </tbody>
    
</table>

        {{ keyword.Keywordcultdomainview }}

<ul class="pager">
    <li class="previous">
        {{ link_to("keyword/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("keyword/new", "New Keyword") }}
    </li> -->
</ul>