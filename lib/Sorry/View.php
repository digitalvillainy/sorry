<?php


namespace Sorry;

/**
 * Base class for all views
 */
class View
{
    /**
     * Optional name to save an error message under in the session.
     */
    const SESSION_ERROR = "sorry_error";

    /**
     * View constructor.
     * @param object $site The site object
     * @param array $get $_GET
     */
    public function __construct(Site $site, array $get = []) {
        /*
		 * Several pages will likely need $_GET
		 * for error message handling.
         *
         * Some pages may need $_POST or $_SESSION in which case we can construct
         * the subsequent view class with that as well.
         *
         * We can add and remove as needed.
         *
         * All views will definitely need $site though.
		 */
        $this->site = $site;
        $this->get = $get;
    }

    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get the redirect location link.
     * @return page to redirect to.
     */
    public function getRedirect() {
        return $this->redirect;
    }

    /**
     * Create the HTML for the contents of the head tag
     * @return string HTML for the page head
     */
    public function head() {
        return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="lib/sorry.css">
HTML;
    }

    /**
     * Just call this in the constructor of derived class
     * with the string in HTML form of a line to add to the header.
     *
     * (such as '<h1>Welcome to Sorry</h1>', '<h2>Exisiting Open Games</h2>', etc..)
     *
     * @return string Additional content to put in the header
     */
    public function addAdditionalHeaderContent($content) {
        $this->contents = $content;
    }

    /**
     * Add a link that will appear on the nav bar
     * This will be put in the header, to the left (using css)
     * @param $href What to link to
     * @param $text What the link should appear as on the page
     */
    public function addLink($href, $text) {
        $this->links[] = ["href" => $href, "text" => $text];
    }

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header()
    {
        $html = <<<HTML
<nav>
HTML;
        if(count($this->links) > 0) {
            $html .= '<ul class="right">';
            foreach($this->links as $link) {
                $html .= '<li><a href="' .
                    $link['href'] . '">' .
                    $link['text'] . '</a></li>';
            }
            $html .= '</ul>';
        }
        $html .= <<<HTML
</nav>
<header class="main">
HTML;
        if(count($this->contents) > 0) {
            foreach($this->contents as $additionalContent) {
                $html .= $additionalContent;
            }
        }

        return $html;
    }

    /**
     * Create the HTML for the page footer
     * Not sure if we'll need this but wouldn't hurt to add to new project2 pages.
     * @return string HTML for the standard page footer
     */
    public function footer()
    {
        return <<<HTML
<footer><p>Team 8 - 'Sorry!' online board game.</p></footer>
HTML;
    }



    protected $site;		///< The Site object
    protected $get;			///< $_GET
    private $title = "";	///< The page title
    private $links = [];	// Links to add to the nav bar (header)
    private $contents = [];  // additional content to add to header

    protected $redirect = null;	///< Optional redirect?

}