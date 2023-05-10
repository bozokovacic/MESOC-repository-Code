{{ content() }}

<!-- <ul class="pager">
    <li class="previous">
        {{ link_to("keywordtv/view", "&larr; Back") }}
    </li>
    <li class="next">
        {{ link_to("keywordtv/new", "New Keyword") }}
    </li> -->
</ul>


<h2>KEYWORD TRANSITION VARIABLE DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>KEYWORD TRANS_VAR. ID</th>
           <th>KEYWORD TRANSITION VARIABLE</th>
           <th>KEYWORD TRANSITION VARIABLE DESCRIPTION</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{ keywordtv.ID_Keywordtv }}</td>
            <td>{{ keywordtv.KeywordtvName }}</td>
            <td>{{ keywordtv.KeywordtvDescription }}</td>
        </tr>

    </tbody>
    
</table>

        {{ keyword.Keywordtvsocimpactview }}

<ul class="pager">
    <li class="previous">
        {{ link_to("keyword/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("keyword/new", "New Keyword") }}
    </li> -->
</ul>