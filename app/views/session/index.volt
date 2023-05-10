
{{ content() }}

<div class="row">

    <div class="col-md-6">
        <div class="page-header">
            <h2>User login</h2>
        </div>
        {{ form('session/start', 'role': 'form') }}
            <fieldset>
                <div class="form-group">
                    <label for="email">User name/Email</label>
                    <div class="controls">
                        {{ text_field('email', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="controls">
                        {{ password_field('password', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    {{ submit_button('Sign in', 'class': 'btn btn-primary btn-large') }}
                </div>
            </fieldset>
        </form>
    </div>

    <div class="col-md-6">

        <div class="page-header">
            <h2>Do You have a user account?</h2>
        </div>

        <p>Free access:</p>
        <ul>
            <li>View document's data.</li>
            <li>Search for documents by define criteria.</li>
            <li>View document's statistic</li>
            <li>Click on the button to access the repository </li>
            <li><a href="/session/access" class="btn btn-primary">Free access</a> </li>
        </ul>


        <div class="clearfix center">
<!--            {{ link_to('register', 'Registration', 'class': 'btn btn-primary btn-large btn-success') }}  -->
        </div>
    </div>

</div>
