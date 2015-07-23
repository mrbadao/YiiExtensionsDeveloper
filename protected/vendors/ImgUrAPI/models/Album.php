<?php
/**
 * Created by PhpStorm.
 * User: HieuNguyen
 * Date: 7/23/2015
 * Time: 4:35 PM
 */

//namespace ImgUr;


class Album
{
    public $_id;
    public $_title;
    public $_description;
    public $_datetime;
    public $_cover;
    public $_cover_width;
    public $_cover_height;
    public $_account_url;
    public $_privacy;
    public $_layout;
    public $_views;
    public $_link;
    public $_favorite;
    public $_name;
    public $_section;
    public $_order;
    public $_deletehash;
    public $_images_count;
    public $_images;
    public $_nsfw;
    public $_account_id;

    function __construct(){}

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
                    if($name == "images"){
                        foreach($value as $val){
                            $tmp = new Image();
                            $tmp->setAttributes($val);
                            $this->_images[] = $tmp;
                        }
                    }else $this->{'_' . $name} = $value;
        }
    }

    public function getAttributes()
    {
        return call_user_func('get_object_vars', $this);
    }
}