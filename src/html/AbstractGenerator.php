<?php
namespace html;


use model\ClassEntity;

abstract class AbstractGenerator
{
    abstract public function generateCode(ClassEntity $entity=null);
    abstract public function getName();

    protected function getIndentation($level=1)
    {
        return str_repeat(" ", 4 * $level);
    }
}