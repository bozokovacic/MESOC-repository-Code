
{{ content() }}

<div class="profile left">
    {{ form('invoices/profile', 'id': 'profileForm', 'onbeforesubmit': 'return false') }}
        <div class="clearfix">
            <label for="name">User name:</label>
            <div class="input">
                {{ text_field("name", "size": "30", "class": "span6") }}
                <div class="alert" id="name_alert">
                    <strong>Upozorenje!</strong> Unesite vaše ime.
                </div>
            </div>
        </div>
        <div class="clearfix">
            <label for="email">Email:</label>
            <div class="input">
                {{ text_field("email", "size": "30", "class": "span6") }}
                <div class="alert" id="email_alert">
                    <strong>Upozorenje!</strong> Unesite e-maolč adresu.
                </div>
            </div>
        </div>
        <div class="clearfix">
            <input type="button" value="Ažuriraj" class="btn btn-primary btn-large btn-info" onclick="Profile.validate()">
            &nbsp;
            {{ link_to('document/search', 'Cancel') }}
        </div>
    </form>
</div>