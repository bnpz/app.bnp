<?php
/**
 * Created by PhpStorm.
 * User: mb
 * Date: 19.11.18
 * Time: 15:35
 */

namespace App\Mixin;


use App\Util\PropertyTranscriber;

trait CanTranscribe
{

    /**
     * @var PropertyTranscriber
     */
    private $transcriber;

    /**
     * @return PropertyTranscriber
     */
    protected function getTranscriber(): PropertyTranscriber
    {
        if (!$this->transcriber) {
            $this->transcriber = new PropertyTranscriber();
        }
        return $this->transcriber;
    }

    protected function transcribeProperty($from, $to, $property, $toProperty = null, $force = false)
    {
        if (!$toProperty) {
            $toProperty = $property;
        }
        $this->transcribe($from, $to, [$property => $toProperty], $force);
    }

    protected function transcribe($from, $to, $fields, $force = false)
    {
        return $this->getTranscriber()->transcribe($from, $to, $fields, $force);
    }

}