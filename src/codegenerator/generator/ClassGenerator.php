<?php
namespace codegenerator\generator;


use codegenerator\model\ClassEntity;
use codegenerator\model\ClassMember;

class ClassGenerator extends AbstractGenerator
{
    public function generateCode(ClassEntity $entity=null)
    {
        if (!$entity) {
            return "Submit your class definition first.";
        }

        return '<pre class="brush: php">' . $this->generateClassDefinition($entity) . '</pre>';
    }

    public function getName()
    {
        return 'Class';
    }

    public function generateClassDefinition(ClassEntity $entity)
    {
        $class[] = "class " . $entity->getName();
        $class[] = "{";
        $class[] = $this->getIndentation() . "/**";
        $class[] = $this->getIndentation() . " * DATASTRING: " . $entity->getName() . "";
        $class[] = $this->getIndentation() . " *";
        $class[] = $this->outputDataString($entity);
        $class[] = $this->getIndentation() . " */";
        $class[] = '';
        $class[] = $this->getIndentation() . "/**";
        $class[] = $this->getIndentation() . " * GENERATED PROPERTIES";
        $class[] = $this->getIndentation() . " */";
        $class[] = $this->outputDefinitions($entity);
        $class[] = "\n";
        $class[] = $this->getIndentation() . "/**";
        $class[] = $this->getIndentation() . " * GENERATED CONSTRUCTOR";
        $class[] = $this->getIndentation() . " */";
        $class[] = $this->outputConstructor($entity);
        $class[] = "\n";
        $class[] = $this->getIndentation() . "/**";
        $class[] = $this->getIndentation() . " * GENERATED GETTERS/SETTERS";
        $class[] = $this->getIndentation() . " */";
        $class[] = '';
        $class[] = $this->outputFunctions($entity);
        $class[] = $this->getIndentation() . "/**";
        $class[] = $this->getIndentation() . " * END GENERATED GETTERS/SETTERS";
        $class[] = $this->getIndentation() . " */";
        $class[] = '}';

        return implode("\n", $class);
    }

    public function outputConstructor(ClassEntity $entity)
    {
        // Get the property names
        $propertyNames = array();
        foreach($entity->getMembers() as $member) {
            if ($member->getType() == 'property') {
                $propertyNames[] = $member->getName();
            }
        }

        // Create the code block line by line
        $lines = array();
        if (count($propertyNames) == 0) {
            $lines[] = "public function __construct()";
        } else {
            $lines[] = "public function __construct($" . implode(", $", $propertyNames) . ")";
        }
        $lines[] = "{";

        foreach($entity->getMembers() as $member) {
            if ($member->getType() == 'setter') {
                $lines[] = $this->getIndentation() . '$this->set' . ucFirst($member->getName()) . '($' . $member->getName() . ');';
            }
        }

        $lines[] = '}';

	foreach($lines as $key => $line) {
            $lines[$key] = $this->getIndentation() . $line;
        }
        return implode("\n", $lines);
    }

    public function outputFunctions(ClassEntity $entity)
    {
        $definitions = '';
        $members = $entity->getMembers();
        foreach($members as $member) {
            switch($member->getType()) {
                case 'getter':
                    $parts = array(
                        'doc' =>  array(
                            'Get the ' . $member->getName(),
                            '',
                            '@return ' . $member->getMemberType() . ' The ' . $member->getName()
                        ),
                        'signature' =>
                            $signature = $member->getAccess() . ' function get' . ucfirst($member->getName()) . '()',
                        'body' => array(
                            'return $this->' . $member->getname() . ';'
                        )
                    );

                    break;

                case 'setter':
                    // if the type starts with a capital letter it's a classname, and we add it to the setter signature
                    $typedSet = ucfirst($member->getMemberType()) == $member->getMemberType();

                    $parts = array(
                        'doc' =>  array(
                            'Set the ' . $member->getName(),
                            '',
                            '@param ' . $member->getMemberType() . ' $' . $member->getName() . ' The ' . $member->getName(),
                            '@return ' . $entity->getName(),
                        ),
                        'signature' =>
                            $signature = $member->getAccess() . ' function set' . ucfirst($member->getName()) . '(' . ($typedSet ? $member->getMemberType() . ' ' : '') . '$' . $member->getName() . ')',
                        'body' => array(
                            '$this->' . $member->getname() . ' = $' . $member->getName() . ';',
                            '',
                            'return $this;'
                        )
                    );

                    break;

                case 'function':
                    $parts = array(
                        'doc' =>  array($member->getName()),
                        'signature' => $signature = $member->getAccess() . ' function ' . $member->getName() . '()',
                        'body' => array()
                    );
                    break;

                default:
                    $parts = array();
                    break;

            }

            if (empty($parts)) {
                continue;
            }

            // output
            $definitions .= $this->getIndentation() . "/**\n";

            foreach($parts['doc'] as $docLine) {
                $definitions .= $this->getIndentation() . " * " . $docLine . "\n";
            }

            $definitions .= $this->getIndentation() . " */\n";
            $definitions .= $this->getIndentation() . $parts['signature'] . "\n";
            $definitions .= $this->getIndentation() . "{\n";

            foreach($parts['body'] as $bodyLine) {
                $definitions .= $this->getIndentation(2) . $bodyLine . "\n";
            }

            $definitions .= $this->getIndentation() . "}\n";
            $definitions .= "\n";
        }

        return $definitions;
    }

    public function outputDefinitions(ClassEntity $entity)
    {
        $definitions = '';
        $members = $entity->getMembers();
        foreach($members as $member) {
            if ($member->getType() == 'property') {
                $definitions .= "\n";
                $definitions .= $this->getIndentation() . "/**\n";
                $definitions .= $this->getIndentation() . " * @var " . $member->getMemberType() . "\n";
                $definitions .= $this->getIndentation() . " */\n";

                $definitions .= $this->getIndentation() . $member->getAccess() . " $" . $member->getName() . ";\n";
            }
        }

        return $definitions;
    }

    public function outputDataString(ClassEntity $entity)
    {
        $dataString = '';
        $members = $entity->getMembers();
        foreach($members as $member) {
            if ($member->getType() != 'getter' && $member->getType() != 'setter') {
                $dataString .= $this->getIndentation() . " * " . $member->getName() . ':' . $member->getMemberType() . ':' . $member->getAccess() . "\n";
            }
        }

        return $this->getIndentation() . ' ' . trim($dataString);
    }
}
