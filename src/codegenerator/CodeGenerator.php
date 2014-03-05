<?php
namespace codegenerator;

use codegenerator\generator\AbstractGenerator;
use codegenerator\model\ClassEntity;

class CodeGenerator
{
    public function generateHtml(Request $request, array $modules)
    {
        $html = $this->createTabs($modules);
        $html .= $this->createContent($request, $modules);
        return $html;
    }

    protected function createTabs(array $modules)
    {
        $html = '<ul class="nav nav-tabs">';

        $index = 0;
        foreach($modules as $module => $enabled) {
            $obj = $this->createGenerator($module);
            $class = $index == 0 ? ' class="active"' : '';
            $html .= '<li' . $class . '><a href="#' . $obj->getName() . '" data-toggle="tab">' . $obj->getName() . '</a></li>';
            $index++;
        }
        $html .= '</ul>';
        return $html;
    }

    protected function createContent(Request $request, $modules)
    {
        $class = ClassEntity::fromRequest($request);

        $html = '<div id="myTabContent" class="tab-content">';

        $index = 0;
        foreach($modules as $module => $enabled) {
            $generator = $this->createGenerator($module);
            $divClass = $index == 0 ? ' active' : '';

            $html .= '
                <div class="tab-pane fade in' . $divClass . '" id="' . $generator->getName() . '">
                    ' . $generator->generateCode($class) . '
                </div>';

            $index++;
        }

        $html .= '</div>';
        return $html;
    }

    protected function createGenerator($name)
    {
        if (!class_exists($name)) {
            throw new \Exception("Cannot find codegenerator class '" . $name . "', make sure the class is available and namespace exists");
        }

        $generator = new $name();

        if (!$generator instanceof AbstractGenerator) {
            throw new \Exception("Class '" . $name . "' is not derived from AbstractGenerator");
        }

        return $generator;
    }
}