{{ content() }}

<!-- <ul class="pager">
    <li class="previous">
        {{ link_to("keywordtv/view", "&larr; Back") }}
    </li>
    <li class="next">
        {{ link_to("keywordtv/new", "New Keyword") }}
    </li> -->
</ul>


<h2>KEYWORD DATA</h2>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
           <th>KEYWORD TRAN_VAR. ID</th>
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

        {{ keywordtv.Keywordtvcultdomainview }}

<ul class="pager">
    <li class="previous">
        {{ link_to("keywordtv/view", "&larr; Back") }}
    </li>
   <!-- <li class="next">
        {{ link_to("keywordtv/new", "New Keyword") }}
    </li> -->
</ul>