<?php


namespace Sorry;

/**
 * Base class for any controllers in project2
 *
 * To save time with repeated work such as the redirect
 * functionality and saving a session
 * reference.
 */
class Controller
{
    /**
     * Controller constructor.
     * @param Site $site The Site object
     * @param $session Session array by reference
     */
    public function __construct(Site $site, &$session) {
        $this->site = $site;

        // We must assign by reference if we want to be
        // able to change the session.
        $this->session = &$session;

        // Ensure no error is set in the session
        unset($this->session[View::SESSION_ERROR]);
    }

    /**
     * Get the redirect location link.
     * @return page to redirect to.
     */
    public function getRedirect() {
        return $this->redirect;
    }

    /**
     * General mechanism for error handling
     * @param $page Page we go to
     * @param $msg Message to display on the page
     */
    protected function error($page, $msg) {
        $root = $this->site->getRoot();
        if(strstr($page, '?') !== false ) {
            $this->redirect = "$root/$page&e";
        } else {
            $this->redirect = "$root/$page?e";
        }

        $this->session[View::SESSION_ERROR] = $msg;
    }



    protected $redirect;	///< Page we will redirect the user to.

    protected $site;		///< The Site object
    protected $session;		///< $_SESSION

}