<?php
namespace codegenerator;

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

        foreach($modules as $index => $module) {
            $obj = new $module();
            $class = $index == 0 ? ' class="active"' : '';
            $html .= '<li' . $class . '><a href="#' . $obj->getName() . '" data-toggle="tab">' . $obj->getName() . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    protected function createContent(Request $request, $modules)
    {
        $class = ClassEntity::fromRequest($request);

        $html = '<div id="myTabContent" class="tab-content">';

        foreach($modules as $index => $module) {
            $generator = new $module();
            $divClass = $index == 0 ? ' active' : '';

            $html .= '
                <div class="tab-pane fade in' . $divClass . '" id="' . $generator->getName() . '">
                    ' . $generator->generateCode($class) . '
                </div>';
        }

        $html .= '</div>';
        return $html;
    }
}