<?php
namespace codegenerator\generator;


use codegenerator\model\ClassEntity;

class InputGenerator extends AbstractGenerator
{
    public function generateCode(ClassEntity $entity=null)
    {
        $datastring = isset($_POST['datastring']) && strlen($_POST['datastring']) > 0 ? $_POST['datastring'] : $this->getDefaultDataString();

        return '
            <form method=post>
                <div class="panel panel-primary">
                    <!--
                    <div class="panel-heading">By Members</div>

                    <div class="panel-body">
                        <nobr>
                            <span style="width: 205px; display: block; float: left;"><b>Naam</b></span>
                            <span style="width: 205px; display: block; float: left;"><b>Type</b></span>
                            <span style="width: 200px; display: block; float: left;"><b>Scrope</b></span>
                        </nobr>

                        <br>

                        <nobr>
                            <input style="width: 200px" name="var_"/></input>
                            <select style="width: 200px" name="type">
                                <option value="numeric">numeric</option>
                                <option value="datetime">datetime</option>
                                <option value="string" selected>string</option>
                            </select>
                            <select style="width: 200px" name="scope">
                                <option value="protected">protected</option>
                                <option value="public" selected>public</option>
                            </select>
                            <a onClick="add()">Add</a>
                        </nobr>

                        <br>

                        <nobr>
                            <textarea style="width: 200px; height: 200px" name="vars">' . ((isset($_POST["vars"])) ? $_POST["vars"] : '') . '</textarea>
                            <textarea style="width: 200px; height: 200px" name="types">' . ((isset($_POST["types"])) ? $_POST["types"] : '') . '</textarea>
                            <textarea style="width: 200px; height: 200px" name="scopes">' . ((isset($_POST["scopes"])) ? $_POST["scopes"] : '') . '</textarea>
                        </nobr>

                        <br>

                        <input type=submit value="from rows">
                    </div>
                    -->


                    <div class="panel-heading">From Datastring</div>

                    <div class="panel-body">
                        <textarea style="width: 600px; height: 400px" name="datastring">' . $datastring . '</textarea>

                        <br><br>
                        <input type=submit name="submit" value="From DataString">
                    </div>
                </div>
            </form>';
    }

    public function getName()
    {
        return 'Input';
    }

    protected function getDefaultDataString()
    {
        return
            "/**\n"
          . " * DATASTRING: SomeClass\n"
          . " *\n"
          . " * id:int\n"
          . " * name:string\n"
          . " */";
    }
}
