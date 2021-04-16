<?php


namespace Sorry;


class PasswordValidateController extends Controller
{
    public function __construct(Site $site, array &$session, array $post) {
        parent::__construct($site, $session);
        $root = $site->getRoot();

        // if user clicks cancel, return to home page
        if (isset($post['cancel'])) {
            $this->redirect = "$root/";
            return;
        }
        //
        // 1. Ensure the validator is correct! Use it to get the user ID.
        //
        $validators = new Validators($site);
        $validator = strip_tags($post['validator']);
        $userid = $validators->get($validator);
        if($userid === null) {
            // otherwise set e=1 for error message
            // validator not correct
            $this->redirect = "$root/password-validate.php?e=1";
            return;
        }
        //
        // 2. Ensure the email matches the user.
        //
        $users = new Users($site);
        $editUser = $users->get($userid);
        if($editUser === null) {
            // User does not exist!
            $this->redirect = "$root/password-validate.php?m=1";
            return;
        }
        $email = trim(strip_tags($post['email']));
        if($email !== $editUser->getEmail()) {
            // Email entered is invalid
            $this->redirect = "$root/password-validate.php?n=1";
            return;
        }

        //
        // 3. Ensure the passwords match each other
        //
        $password1 = trim(strip_tags($post['password']));
        $password2 = trim(strip_tags($post['password2']));
        if($password1 !== $password2) {
            // Passwords do not match
            $this->redirect = "$root/password-validate.php?k=1";
            return;
        }

        if(strlen($password1) < 8) {
            // Password too short
            $this->redirect = "$root/password-validate.php?s=1";
            return;
        }
        // otherwise no problems, can update password
        //
        // 4. Create a salted password and save it for the user.
        //
        $users->setPassword($userid, $password1);
        //
        // 5. Destroy the validator record so it can't be used again!
        //
        $validators->remove($userid);

        $this->redirect = "$root/";


    }

    /**
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    protected $redirect;


}

