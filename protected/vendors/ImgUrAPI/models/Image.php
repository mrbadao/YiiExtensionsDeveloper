<?php
/**
 * Created by PhpStorm.
 * User: HieuNguyen
 * Date: 7/23/2015
 * Time: 4:35 PM
 */
//namespace ImgUr;


class Image
{
    public $_id;
    public $_title;
    public $_description;
    public $_datetime;
    public $_type;
    public $_animated;
    public $_width;
    public $_height;
    public $_size;
    public $_views;
    public $_bandwidth;
    public $_deletehash;
    public $_name;
    public $_section;
    public $_link;
    public $_gifv;
    public $_mp4;
    public $_webm;
    public $_looping;
    public $_favorite;
    public $_nsfw;
    public $_vote;
    public $_account_url;
    public $_account_id;

    function __construct(){}

//    function __construct($params)
//    {
//        if (is_array($params) && !empty($params)) {
//            foreach ($params as $key => $val)
//                $this->{'_' . $key} = $val;
//        }
//    }

    public function getAttribute($name = null)
    {
        if ($name && property_exists(get_class($this), "_" . $name))
            return $this->{'_' . $name};
        return null;
    }

    public function setAttibute($name = null, $value = null)
    {
        if ($name && property_exists(get_class($this), "_" . $name)) {
            $this->{'_' . $name} = $value;
            return true;
        }
        return false;
    }

    public function setAttributes($attributes = null)
    {
        if ($attributes && is_array($attributes)) {
            foreach ($attributes as $name => $value)
                if ($name && property_exists(get_class($this), "_" . $name))
                    $this->{'_' . $name} = $value;
        }
    }

    public function getAttributes()
    {
        return call_user_func('get_object_vars', $this);
    }
}