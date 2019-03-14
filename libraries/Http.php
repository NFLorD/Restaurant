<?php 

class Http
{
    /**
     * Redirects to a given url
     *
     * @param string $url
     * @return void
     */
    static public function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }

    /**
     * Redirects to previous page through HTTP_REFERER
     *
     * @return void
     */
    static public function redirectBack()
    {
        if (empty($_SERVER['HTTP_REFERER'])) {
            $_SERVER['HTTP_REFERER'] = WEB_ROOT;
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}







?>