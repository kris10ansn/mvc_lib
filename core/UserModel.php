<?php


namespace app\core;


abstract class UserModel extends DBModel {
    public abstract function getDisplayName(): string;
}