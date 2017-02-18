<?php

class AuthMiddleware extends \Slim\Middleware
{
    
    private $public = array(
        "/",
        "/login",
        "/create-user-account",
        "/reset-password",
        "/admin/create-stickerbook"
    );

    private function isPublic($uri)
    {
        $len = strlen($uri);
        if ($len > 1)
        {
            $uri = $uri[$len - 1] == "/"? substr($uri, 0, $len - 1): $uri;
        }
        return in_array($uri, $this->public);
    }

    public function call()
    {
        session_cache_limiter(false);
        session_start();
        $app = $this->app;
        $req = $app->request;
        $uri = $req->getResourceUri();
        if (!$this->isPublic($uri))
        {
            $user = isset($_SESSION["user"])? $_SESSION["user"]: null;            
            if ($user == null)
            {
                $app->redirect("/login?uri=" . $uri);
            }
        }
        $this->next->call();
    }

}