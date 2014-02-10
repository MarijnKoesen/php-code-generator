<?php
namespace html;


use model\ClassEntity;

class MapperGenerator  extends AbstractGenerator
{
    public function generateCode(ClassEntity $entity=null)
    {
        if (!$entity) {
            return "Submit your class definition first.";
        }

        $code = array();
        $code[] = sprintf('class ' . $entity->getName() . 'ArrayMapper');
        $code[] = sprintf('{');

        $code = array_merge($code, $this->getFromArray($entity));
        $code[] = '';
        $code = array_merge($code, $this->getToArray($entity));

        $code[] = sprintf('}');

        $html = implode("\n", $code);

        return '<pre class="brush: php">' . $html . '</pre>';
    }

    public function getName()
    {
        return 'Mapper';
    }

    public function getFromArray(ClassEntity $entity)
    {
        $an = preg_match("/^[AEIOU]/i", $entity->getName()) ? 'an' : 'a';

        $code = array();
        $code[] = sprintf('%s/**', $this->getIndentation());
        $code[] = sprintf('%s * Create %s %s from an array', $this->getIndentation(), $an, $entity->getName());
        $code[] = sprintf('%s *', $this->getIndentation(), $entity->getName());
        $code[] = sprintf('%s * @param array $data The array to convert to an %s', $this->getIndentation(), $entity->getName());
        $code[] = sprintf('%s * @return %s The %s', $this->getIndentation(), $entity->getName(), $entity->getName());
        $code[] = sprintf('%s */', $this->getIndentation());
        $code[] = sprintf('%sfunction fromArray(array $data)', $this->getIndentation());
        $code[] = sprintf('%s{', $this->getIndentation());

        // body
        $code[] = sprintf('%s$%s = new %s();', $this->getIndentation(2), lcfirst($entity->getName()), $entity->getName());
        $code[] = '';

        $members = $entity->getMembers();
        foreach($members as $member) {
            if ($member->getType() != 'property') {
                continue;
            }

            $code[] = sprintf("%sif (isset(\$data['%s'])) {", $this->getIndentation(2), $member->getName());
            $code[] = sprintf("%s$%s->set%s(\$data['%s']);", $this->getIndentation(3), lcfirst($entity->getName()), ucfirst($member->getName()), $member->getName());
            $code[] = sprintf("%s}", $this->getIndentation(2));
            $code[] = '';
        }
        $code[] = sprintf('%sreturn $%s;', $this->getIndentation(2), lcFirst($entity->getName()));

        // end body
        $code[] = sprintf('%s}', $this->getIndentation());

        return $code;
    }

    public function getToArray(ClassEntity $entity=null)
    {
        $code = array();
        $code[] = sprintf('%s/**', $this->getIndentation());
        $code[] = sprintf('%s * Create the data array for the %s', $this->getIndentation(), $entity->getName());
        $code[] = sprintf('%s *', $this->getIndentation(), $entity->getName());
        $code[] = sprintf('%s * @param %s $%s The %s to convert to an array', $this->getIndentation(), $entity->getName(), lcfirst($entity->getName()), $entity->getName());
        $code[] = sprintf('%s * @return array The data array for the %s', $this->getIndentation(), $entity->getName());
        $code[] = sprintf('%s */', $this->getIndentation());
        $code[] = sprintf('%sfunction toArray(%s $%s)', $this->getIndentation(), $entity->getName(), lcfirst($entity->getName()));
        $code[] = sprintf('%s{', $this->getIndentation());

        // body
        $code[] = sprintf('%s$data = array(', $this->getIndentation(2), lcfirst($entity->getName()));

        $members = $entity->getMembers();
        foreach($members as $member) {
            if ($member->getType() != 'property') {
                continue;
            }

            $code[] = sprintf("%s'%s' => $%s->get%s(),",
                $this->getIndentation(3),
                $member->getName(),
                lcfirst($entity->getName()),
                ucfirst($member->getName())
            );
        }
        $code[] = sprintf('%s);', $this->getIndentation(2));
        $code[] = sprintf('');
        $code[] = sprintf('%sreturn $data;', $this->getIndentation(2));

        // end body
        $code[] = sprintf('%s}', $this->getIndentation());

        return $code;
    }
}