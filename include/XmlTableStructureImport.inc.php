<?php

class XmlTableStructureImport extends DBI {

    protected $xmlfile;
    protected $xml;

    public function getXmlFile($file) {
        $this->xmlfile = $file;
        $this->xml = GH::getXmlFile($this->xmlfile);
        return;
    }

    public function writeNewTable() {
        self::dropTable();
        self::createTable();
        self::createFields();
        self::createIndexes();
        self::createPrimaryIndex();
        return;
    }

    /*
     * SQL Tabelle löschen -> Neu-Initialisierung
     */

    private function dropTable() {
        $table = $this->xml->filetype;
        return parent::exec("DROP TABLE IF EXISTS " . $table . ";");
    }

    /**
     * SQL Tabelle erstellen (aus XML-Dateinamen)
     */
    private function createTable() {
        return parent::exec("CREATE TABLE IF NOT EXISTS " . $this->xml->filetype . " (count MEDIUMINT NOT NULL AUTO_INCREMENT, KEY (count));");
    }

    /*
     * Felder aus XML-File: Erstellen in Tabelle
     */

    private function createFields() {
        foreach ($this->xml->sdawfieldset->field as $field) {
            parent::exec("ALTER TABLE " . $this->xml->filetype . " ADD `" . $field->title . "` " . $field->type . "(" . $field->length . ") NOT NULL;");
        }
        return;
    }

    /*
     * Indexes erstellen aus XML-Datei
     */

    private function createIndexes() {
        foreach ($this->xml->keys->index as $index) {
            parent::exec("CREATE INDEX `IDX_" . $index . "` ON `" . $this->xml->filetype . "` (" . $index . ");");
        }
        return;
    }

    /*
     * Primï¿½rindex erstellen aus XML-atei
     */

    private function createPrimaryIndex() {
        return parent::exec("ALTER TABLE " . $this->xml->filetype . " ADD PRIMARY KEY (" . $this->xml->keys->primary . ");");
    }

}

?>