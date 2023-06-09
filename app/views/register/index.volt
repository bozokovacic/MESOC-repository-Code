{{ content() }}

<div class="page-header">
    <h2>User registration</h2>
</div>

{{ form('register', 'id': 'registerForm', 'onbeforesubmit': 'return false') }}

    <fieldset>

        <div class="control-group">
            {{ form.label('name', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('name', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Name and surname.
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('username', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('username', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
                <div class="alert alert-warning" id="username_alert">
                    <strong>Warning!</strong> User name.
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('email', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('email', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
                <div class="alert alert-warning" id="email_alert">
                    <strong>Warning!</strong> Email
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('password', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('password', ['class': 'form-control']) }}
                <p class="help-block">(8 characters minimum )</p>
                <div class="alert alert-warning" id="password_alert">
                    <strong>Warning!</strong> Enter the correct password
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="repeatPassword">Repeat the password</label>
            <div class="controls">
                {{ password_field('repeatPassword', 'class': 'form-control') }}
                <div class="alert" id="repeatPassword_alert">
                    <strong>Warning!</strong> Passwords do not match.
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('ID_Role', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('ID_Role', ['class': 'form-control']) }}
                <p class="help-block">(obligatory)</p>
                    <div class="alert alert-warning" id="username_alert">
                    <strong>Warning!</strong> User name.  
                </div> 
            </div>

        <div class="control-group">
            {{ form.label('ID_Partner', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('ID_Partner', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
    <!--            <div class="alert alert-warning" id="username_alert">
                    <strong>Warning!</strong> User name.   
                </div>   -->
            </div>
        </div>   

        <div class="control-group">
            {{ form.label('ID_Organisation', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('ID_Organisation', ['class': 'form-control']) }}
                <p class="help-block">(mandatory)</p>
    <!--            <div class="alert alert-warning" id="username_alert">
                    <strong>Warning!</strong> User name.   
                </div>   -->
            </div>
        </div>   

        <div class="form-actions">
            {{ submit_button('Registration', 'class': 'btn btn-primary', 'onclick': 'return SignUp.validate();') }}
            <p class="help-block">By accepting, you agree to the data protection policy defined by the security policy.</p>
        </div>

    </fieldset>
</form>
