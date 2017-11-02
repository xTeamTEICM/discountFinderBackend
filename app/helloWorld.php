<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class helloWorld extends Model
{
    private $title;
    private $desc;

    /**
     * helloWorld constructor.
     */
    public function __construct()
    {
        $this->title = "Hello world";
        $this->desc = "from Laravel";
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc(string $desc)
    {
        $this->desc = $desc;
    }

    public function toJson($options = 0)
    {
        $objectJson = new \stdClass();
        $objectJson->title = $this->title;
        $objectJson->desc = $this->desc;

        return json_encode($objectJson, $options);
    }


}
