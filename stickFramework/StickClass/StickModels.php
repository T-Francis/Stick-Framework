<?php
namespace StickFramework\StickClass;
use StickFramework\StickFramework as StickFramework;
use StickFramework\StickClass\StickDatabase as StickDatabase;
use StickFramework\StickClass\StickQueryBuilder as StickQueryBuilder;

/**
 * [StickModels description]
 */
class StickModels
{
    /**
     * [getDatabase description]
     * @return [type] [description]
     */
    protected function getDatabase(){
        return new StickDatabase(
                            StickFramework::getSettings()['db']['dbDriver'],
                            StickFramework::getSettings()['db']['dbHost'],
                            StickFramework::getSettings()['db']['dbName'],
                            StickFramework::getSettings()['db']['dbLogin'],
                            StickFramework::getSettings()['db']['dbPsw'],
                            StickFramework::getSettings()['db']['dbCharset']
                            );

    }

    /**
     * [setValues description]
     * @param [type] $datas [description]
     * @param [type] $table [description]
     */
    protected function setValues($datas,$table=null){
        if ($table != null) {
            $table = $this->unsetPrefix($table);
            @$this->values->$table = $datas;
        } else {
            foreach ($datas as $key => $value) {
                @$this->values->$key = $value;
            }
        }
        return $this;
    }

    /**
     * [getQueryBuilder description]
     * @return [type] [description]
     */
    protected function getQueryBuilder(){
        return new StickQueryBuilder;
    }

    /**
     * [getCollation description]
     * @return [type] [description]
     */
    private function getCollation(){
        return StickFramework::getSettings()['db']['dbCollation'];
    }

    /**
     * [getPrefix description]
     * @return [type] [description]
     */
    private function getPrefix(){
        return StickFramework::getSettings()['db']['prefix'];
    }

    /**
     * [getTable description]
     * @return [type] [description]
     */
    private function getTable(){
        if (is_null(@$this->table)) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = $this->getPrefix().strtolower($class_name). 's';
        }
        return $this->table;
    }

    /**
     * [getAll description]
     * @return [type] [description]
     */
    public function getAll(){
        $datas = $this->getDatabase()->runQuery('SELECT * FROM '.$this->getTable());
        $this->setValues($datas);
        return $this;
    }

    public function haveOne($targetTable){
        $targetTable = $targetTable;
        // SELECT * FROM $targetTable WHERE $ownerId = (SELECT $ownerId FROM $ownerTable WHERE $ownerId = 1 LIMIT 1);
        // SELECT * FROM stck_posts WHERE userId = (SELECT userId FROM stck_users WHERE userId = 1 LIMIT 1);
        $req = 'SELECT * FROM '.$targetTable.' WHERE '.$this->primaryKey.' = '.$this->values->userId.' LIMIT 1;';
        $datas = $this->getDatabase()->runQuery($req,true);
        $this->setValues($datas,$targetTable);
        return $this;
    }

    /**
     * [getManyToMany description]
     * @param  [type] $targetTable [description]
     * @param  [type] $pivot       [description]
     * @return [type]              [description]
     */
    public function getManyToMany($targetTable,$pivot){
        $targetTable = $this->checkPrefix($targetTable);
        $pivot = $this->checkPrefix($pivot);

        $req = 'SELECT * FROM '.$pivot.' JOIN '.$targetTable.' ON '.$pivot.'.groupId = '.$targetTable.'.groupId WHERE '.$pivot.'.'.$this->primaryKey.' = '.$this->values->userId.';';

        $datas = $this->getDatabase()->runQuery($req,true);
        $this->setValues($datas,$targetTable);
        return $this;
    }

    /**
     * [checkPrefix description]
     * @param  [type] $targetTable [description]
     * @param  [type] $pivot       [description]
     * @return [type]              [description]
     */
    public function checkPrefix($toPrefix){
        if ($this->getPrefix() != "") {
            $toPrefix = $this->getPrefix().$toPrefix;
        }
        return $toPrefix;
    }

    public function unsetPrefix($unsetPrefix){
        if ($this->getPrefix() != "") {
            $unsetPrefix = str_replace($this->getPrefix(),'',$unsetPrefix);
        }
        return $unsetPrefix;
    }

    /**
     * [getById description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getById($id){
        if (@$this->primaryKey===null) {
            return 'No primary Key Specified';
        }
        $datas = $this->getDatabase()->runQuery('SELECT * FROM '.$this->getTable().' WHERE '.$this->primaryKey.' = '.$id,true);
        $this->setValues($datas);
        return $this;
    }

    /**
     * [create description]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function create($params){
        $tableChamps = $this->champs;
        $insertChamps = '(';
        $insertValues = '(';
        foreach ($tableChamps as $key => $value) {
            $insertChamps .= $value.',';
            $insertValues .= ':'.$value.',';
        }
        $insertChamps = rtrim($insertChamps, ',');
        $insertValues = rtrim($insertValues, ',');
        $insertChamps .= ')';
        $insertValues .= ')';
        $req = 'INSERT INTO '.$this->getTable().' '.$insertChamps.' VALUES '.$insertValues.';';
        $this->getDatabase()->preparedQuery($req,$params);
        return true;
    }

}

?>
