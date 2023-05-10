
{{ content() }}

<div class="page-header">
    <h2>Contact us</h2>
</div>

<p>Post comments and suggestions for improvements.</p>

{{ form('contact/send', 'role': 'form') }}
    <fieldset>
        <div class="form-group">
            {{ form.label('name') }}
            {{ form.render('name', ['class': 'form-control']) }}
        </div>
        <div class="form-group">
            {{ form.label('email') }}
            {{ form.render('email', ['class': 'form-control']) }}
        </div>
        <div class="form-group">
            {{ form.label('comments') }}
            {{ form.render('comments', ['class': 'form-control']) }}
        </div>
        <div class="form-group">
            {{ submit_button('Send', 'class': 'btn btn-primary btn-large') }}
        </div>
    </fieldset>
</form>
