<?php

class anon_auth extends master_auth
{
    public function __construct($db)
    {
        parent::__construct($db);
        session_start();
        $this->ses = new session();
    }

    public function auth()
    {
        return true;
    }

    public function session()
    {
        return $this->ses;
    }
}
