<?php
class Validate{
    public function isString($str){
        $reg = "/^[A-Z a-z]+$/";
        return preg_match($reg,$str);
    }
    public function isNumeric($str){
        $reg = "/^\d+$/";
        return preg_match($reg,$str);
    }
    public function isStringNum($str){
        $reg = "/^[A-Z a-z 0-9]+$/";
        return preg_match($reg,$str);
    }
    public function isNull($str){
        $reg = "/^{0}$/";
        return preg_match($reg,$str);
    }
    public function isMail($str){
        $reg="/^[A-Za-z0-9\.\-\_]+\@[a-z0-9A-Z\-\_]+\.[a-zA-Z]{2,5}(\.[a-zA-Z]{2,4})?$/";
        return preg_match($reg,$str);
    }
    public function isPassword($str){
        $reg="/^[0-9A-Za-z]{8,20}$/";
        return preg_match($reg,$str);
    }
    public function isPwd($str){
        $reg="/^[0-9A-Za-z]{8,20}$/";
        return preg_match($reg,$str);
    }
    public function isPhone($str){
        $reg ="/^((09|03|07|08|05|02)+([0-9]{8})\b)$/";
        return preg_match($reg,$str);   
    }
}