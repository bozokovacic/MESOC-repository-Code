
{{ content() }}

{{ form("template/create") }} 


    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("template/view", "&larr; Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <fieldset>

        <div class="control-group">
            {{ form.label('Title', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('Title', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Title is missing.
                </div> -->
            </div>
        </div>

        <div class="control-group">
            {{ form.label('PubYear', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('PubYear', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Title.
                </div>  -->
            </div>
        </div>

        <div class="control-group">
            {{ form.label('OpenAccess', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('OpenAccess', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="email_alert">
                    <strong>Warning!</strong> Email   -->
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('CountryPub', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('CountryPub', ['class': 'form-control']) }}
                <p class="help-block">(mandatory )</p>   
<!--                <div class="alert alert-warning" id="password_alert">
                    <strong>Warning!</strong> Choose the country publication. 
                </div>  -->
            </div>
        </div>

        <div class="control-group">
            {{ form.label('ID_Language', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('ID_Language', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="email_alert">
                    <strong>Warning!</strong> Choose language  
                </div>   -->
            </div>
        </div>

        <div class="control-group">
            {{ form.label('Summary', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('Summary', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Enter summary.
                </div> -->
            </div>
        </div>

        <div class="control-group">
            {{ form.label('ID_CultDomain', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('ID_CultDomain', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                    <div class="alert alert-warning" id="username_alert">
                    <strong>Upozorenje!</strong> Cultural Domain.  
                </div> -->
            </div>  

        <div class="control-group">
            {{ form.label('ID_SocImpact', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('ID_SocImpact', ['class': 'form-control']) }}
<!--                <p class="help-block">(mandatory)</p>
                <div class="alert alert-warning" id="username_alert">
                    <strong>Upozorenje!</strong> Social Impact.   
                </div>   
            </div> -->
        </div>   

        <div class="control-group">
            {{ form.label('TransitionVar', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('TransitionVar', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Enter transition variables.
                </div> -->
            </div>
        </div>

        <div class="control-group">
            {{ form.label('Keywords', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('Keywords', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Enter keywords.
                </div>  -->
            </div>
        </div>
        
        <div class="control-group">
            {{ form.label('Links', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('Links', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
<!--                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Enter links.
                </div> --
            </div>
        </div>

 <!--       <div class="form-actions">
            {{ submit_button('Registration', 'class': 'btn btn-primary', 'onclick': 'return SignUp.validate();') }}
            <p class="help-block">By accepting, you agree to the data protection policy defined by the security policy.</p>
        </div>   -->

    </fieldset>

</form>
