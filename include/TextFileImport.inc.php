<?php

class TextFileImport extends DBI {

    protected $defsfile;
    protected $defs;
    protected $sdawfile;

    public function getDefs($path) {
        return $this->defs->$path;
    }

    public function loadDefsFile($defsfile) {
        $this->defsfile = $defsfile;
        $this->defs = GH::getXmlFile($this->defsfile); // debug: echo "<pre>"; print_r($defs);
        return;
    }

    public function loadSdawFile($sdawfile) {
        $this->sdawfile = $sdawfile;
        $sdawfilehandle = fopen($this->sdawfile, "r+");
        if (flock($sdawfilehandle, LOCK_EX | LOCK_NB)) { // do an exclusive lock on USER
            $file = file($this->sdawfile);
            $ver = new VERSION;
            $ver->setHeaderDefs(GH::getXmlFile($GLOBALS['STAKopfDatenFile']));
            //print_r($ver); die;
            foreach ($file as $line) {
                if (substr($line, 0, 1) == $this->defs->dataidentifier) {
                    $sql = "INSERT INTO " . $this->defs->filetype . "  (";
                    $sqlfieldlist = "";
                    $sqlvalues = "";
                    foreach ($this->defs->sdawfieldset->field as $field) {
                        $sqlfieldlist .= $field->title . ",";
                        if ($field->type == 'Char') {
                            $sqlvalues .= parent::gqstr(substr($line, $field->startpos - 1, intval($field->length))) . ",";
                        } else {
                            $sqlvalues .= substr($line, $field->startpos - 1, intval($field->length)) . ",";
                        }
                    }
                    $sql .= substr($sqlfieldlist, 0, -1) . ") VALUES (" . substr($sqlvalues, 0, -1) . ");";
                    parent::sqldebug(false);
                    parent::exec($sql);
                } elseif (substr($line, 0, 1) == $ver->headerdefs->dataidentifier) {
                    $ver->setVersionData($line);
                    //print "<hr>";
                   if  ($ver->registerFile()!=1) trigger_error("Datei $sdawfile bereits vorhanden.", E_USER_NOTICE);
                }
            }
            return;
        } else
            return "File $this->sdawfile locked!";
    }

}

?>