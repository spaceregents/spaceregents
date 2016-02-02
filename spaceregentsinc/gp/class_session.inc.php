<?php

class session
{
    public function validate()
    {
        return (bool)$_SESSION['user_id'];
    }

    public function get_uid()
    {
        return $_SESSION["uid"];
    }

    public function get_var($var)
    {
        return $_SESSION[$var];
    }

    public function update_uid($uid)
    {
        $_SESSION["uid"] = $uid;
    }
}
