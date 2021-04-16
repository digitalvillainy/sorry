<?php


namespace Sorry;


class PasswordValidateView extends View
{
    public function __construct(Site $site, array $get) {
        $this->setTitle('Sorry Password Entry');
        $this->site = $site;

        // set if Invalid or unavailable validator
        if (isset($get['e'])) {
            $this->invalid = true;
            $this->validator = "";
        }
        // set if Email address is not for a valid user
        elseif(isset($get['m'])) {
            $this->email = true;
            $this->validator = "";
        }
        // set if Email address does not match validator
        elseif(isset($get['n'])) {
            $this->matchEmail = true;
            $this->validator = "";
        }
        // set if Passwords did not match
        elseif(isset($get['k'])) {
            $this->pass = true;
            $this->validator = "";
        }
        // set if Password too short
        elseif(isset($get['s'])) {
            $this->tooShort = true;
            $this->validator = "";
        }
        else {
            $this->validator = strip_tags($get['v']);
        }
    }

    public function present()
    {
        $html = <<<HTML
<form method="post" action="post/password-validate.php">
	<fieldset>
		<legend>Change Password</legend>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<label for="password1">Password:</label><br>
			<input type="text" id="password1" name="password" placeholder="password">
		</p>
		<p>
			<label for="password2">Password (again):</label><br>
			<input type="text" id="password2" name="password2" placeholder="password">
		</p>

		<p>
			<input type="submit" id="ok" name="ok" value="OK"> <input type="submit" id="cancel" name="cancel" value="Cancel">
		</p>
		
		<p>
		    <input type="hidden" name="validator" value="$this->validator">
        </p>

HTML;

        if ($this->invalid) {
            $html .= '<p class="msg">Invalid or unavailable validator</p>';
        }
        if ($this->email) {
            $html .= '<p class="msg">Email address is not for a valid user</p>';
        }
        if ($this->matchEmail) {
            $html .= '<p class="msg">Email address does not match validator</p>';
        }
        if ($this->pass) {
            $html .= '<p class="msg">Passwords did not match</p>';
        }
        if ($this->tooShort) {
            $html .= '<p class="msg">Password too short</p>';
        }

        $html .= '</fieldset>';
        $html .= '</form>';
        return $html;
    }



    private $validator;
    private $tooShort = false;
    private $invalid = false;
    private $email = false;
    private $matchEmail = false;
    private $pass = false;

}