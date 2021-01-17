<?php


namespace app\core;


class Session
{
    protected const FLASH_KEY = "flash_messages";

    public function __construct()
    {
        session_start();

        foreach ($_SESSION[self::FLASH_KEY] as $key => &$flashMessage) {
            $flashMessage["remove"] = true;
        }
    }

    public function setFlash($key, $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            "value" => $message,
            "remove" => false
        ];
    }

    public function getFlash($key): string
    {
        if (isset($_SESSION[self::FLASH_KEY][$key])) {
            return $_SESSION[self::FLASH_KEY][$key]["value"];
        }

        return false;
    }

    public function __destruct() {
        foreach ($_SESSION[self::FLASH_KEY] as $key=>$flashMessage) {
            if ($flashMessage["remove"]) {
                unset($_SESSION[self::FLASH_KEY][$key]);
            }
        }
    }
}