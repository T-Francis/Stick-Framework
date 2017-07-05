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

    public $table;
    public $primaryId;
    public $primaryKey;
    public $champs;
    public $values;
    public $relateds;

    /**
     * [__construct description]
     */
    public function __construct(){
        $this->table = null;
        $this->primaryId = null;
        $this->primaryKey = null;
        $this->champs = null;
        $this->values = null;
        $this->relateds = array();
    }


/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************
                                                                        GETTERS AND SETTERS PART BELOW
/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************/

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
     * [getPrefix description]
     * @return [type] [description]
     */
    private function getPrefix(){
        return StickFramework::getSettings()['db']['prefix'];
    }


    /**
     * [checkPrefix description]
     * @param  [type] $relatedTable [description]
     * @param  [type] $pivot       [description]
     * @return [type]              [description]
     */
    private function checkPrefix($toPrefix){
        if ($this->getPrefix() != "") {
            $toPrefix = $this->getPrefix().$toPrefix;
        }
        return $toPrefix;
    }


    /**
     * [unsetPrefix description]
     * @param [type] $unsetPrefix [description]
     */
    private function unsetPrefix($unsetPrefix){
        if ($this->getPrefix() != "") {
            $unsetPrefix = str_replace($this->getPrefix(),'',$unsetPrefix);
        }
        return $unsetPrefix;
    }


    /**
     * [getTable description]
     * @return [type] [description]
     */
    private function getTable(){
        if ($this->table===null) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = $this->getPrefix().strtolower($class_name). 's';
        }
        return $this->table;
    }


    /**
     * [setValues description]
     * @param [type] $datas [description]
     * @param [type] $table [description]
     */
    protected function setValues($datas,$table=null){
        if ($table != null) {
            $table = $this->unsetPrefix($table);
            $this->relateds[$table] = (object)$datas;
        } else {
                $this->values = $datas;
        }
        return $this;
    }


    /**
     * [setPrimaryId description]
     * @param [type] $id [description]
     */
    private function setPrimaryId($id){
        $this->primaryId = $id;
        return $this;
    }


/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************
                                                                        READ PART BELOW (select)
/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************/

    /**
     * [getAll description]
     * @return [type] [description]
     */
    public function getAll(){
        $datas = $this->getDatabase()->runQuery('SELECT * FROM '.$this->getTable());
        $this->setValues($datas);
        return $datas;
    }


    /**
     * [getById description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getById($id){
        if ($this->primaryKey===null) {
            return 'No primary Key Specified';
        }
        $datas = $this->getDatabase()->runQuery('SELECT * FROM '.$this->getTable().' WHERE '.$this->primaryKey.' = '.$id,true);
        $this->setPrimaryId($id);
        $this->setValues($datas);
        return $this;
    }


    /**
     * [getByField description]
     * @param  [type] $field [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function getByField($field,$value){
        $req = 'SELECT * FROM '.$this->getTable().' WHERE '.$field.' = :value;';
        $params = array(
            ':value' => $value
            );
        $datas = $this->getDatabase()->preparedQuery($req,$params,true);
        $this->setValues($datas);
        return $this;
    }

/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************
                                                                        CREATE / UPDATE / DELETE PART BELOW
/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************/

    /**
     * [create description]
     * @param  [type]  $params [description]
     * @param  boolean $lastId [description]
     * @return [type]          [description]
     */
    public function create($params,$lastId=false){
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
        return $this->getDatabase()->preparedQuery($req,$params,false,$lastId);
    }

    /**
     * [update description]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function update($params){
        $update = "";
        foreach ($params as $key => $value) {
            $update .= $key.' = :'.$key.',';
        }
        $update = rtrim($update, ',');
        $req = 'UPDATE '.$this->getTable().' SET  '.$update.' WHERE '.$this->primaryKey.' = '.$this->primaryId.';';
        $this->getDatabase()->preparedQuery($req,$params,false,false);
        return $this->getbyId($this->primaryId);
    }

/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************
                                                                        RELATIONSHIP PART BELOW
/***************************************************************************************************************************************************************************************
***************************************************************************************************************************************************************************************/

    /**
     * [haveOne description]
     * @param  [type] $relatedTable [description]
     * @return [type]               [description]
     */
    public function haveOne($relatedTable){
        $relatedTable = $this->checkPrefix($relatedTable);

        $req = 'SELECT * FROM '.$relatedTable.' WHERE '.$this->primaryKey.' = '.$this->primaryId.';';
        $datas = $this->getDatabase()->runQuery($req,true);
        $this->setValues($datas,$relatedTable);
        return $datas;
    }


    /**
     * [haveOneAndMany description]
     * @param  [type] $relatedTable [description]
     * @return [type]               [description]
     */
    public function haveOneAndMany($target){
        $target = new $target;
        $relatedTable = $target->getTable();
        $req = 'SELECT * FROM '.$relatedTable.' WHERE '.$this->primaryKey.' = '.$this->primaryId.';';
        $datas = $this->getDatabase()->runQuery($req,true);
        $this->setValues($datas,$relatedTable);
        return $datas;
    }


    /**
     * [haveManyToMany description]
     * @param  [type] $target [description]
     * @param  [type] $pivot  [description]
     * @return [type]         [description]
     */
    public function haveManyToMany($target,$pivot){
        $target = new $target;
        $relatedTable = $target->getTable();
        $pivot = $this->checkPrefix($pivot);
        $req = 'SELECT * FROM '.$pivot.' JOIN '.$relatedTable.' ON '.$pivot.'.'.$target->primaryKey.' = '.$relatedTable.'.'.$target->primaryKey.' WHERE '.$pivot.'.'.$this->primaryKey.' = '.$this->primaryId.';';
        $datas = $this->getDatabase()->runQuery($req,true);
        $this->setValues($datas,$relatedTable);
        return $datas;
    }

}

?>
