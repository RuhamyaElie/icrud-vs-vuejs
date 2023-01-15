<?php

class icrud
{
    private $table;
    private $attrs;
    private $type;
    private $id;
    private $dataBase;
    
    public function __construct(array $table, array $attrs, bool $type)
    {
        $this->table = $this->magic($table, false);
        $this->attrs = $attrs;
        $this->id = array_shift($attrs);
        $this->type = $type == false ? PDO::FETCH_ASSOC : PDO::FETCH_OBJ;
        $this->DBConn();
    }

    private function DBConn ()
    {
        return $this->dataBase = new PDO('mysql:host=localhost; dbname=icrud', 'root', '');
    }

    private function magic (array $table, bool $prepReq, bool $prepUpdate=false)
    {
        $strTab = [];
        $strTabUp = [];
        foreach ($table as $key => $value) {
            $strTab[] = $prepReq == false && $prepUpdate == false ? $value.',' : ':'.$value.',';
            $strTabUp[] = $prepUpdate == true ? $value.'=:'.$value.',' : false;
        }
        return $prepUpdate == true ? substr(implode($strTabUp), 0, -1) : substr(implode($strTab), 0, -1);
    }

    private function request (array $attrs, array $datas): array
    {
        $formData = [];
        foreach ($attrs as $key => $attr) {
            $formData[$attrs[$key]] = $datas[$key];
        }
        return $formData;
    }

    public function create (array $datas)
    {
        $tmpAttrs = $this->attrs;
        array_unshift($datas, null);
        $prepAttrs = $this->magic($tmpAttrs, false);
        $reqAttrs = $this->magic($tmpAttrs, true);

        $save = function () use ($tmpAttrs, $prepAttrs, $reqAttrs, $datas) {
            $request = $this->dataBase->prepare("INSERT INTO {$this->table} ($prepAttrs) VALUES ($reqAttrs)");
            return $request->execute($this->request($tmpAttrs, $datas));
        };
        return $save();
    }

    public function read (array $fields=null, string $cond=null, array $value=null, $limit=null)
    {
        $fields = (isset($fields) && !empty($fields)) ? $this->magic($fields, false) : '*';
        $cond = isset($cond) ? $cond : '1';
        $lmt = (gettype($limit) === 'integer') ? $limit : 10;
        $limit = (gettype($limit) === 'array') ? $this->magic($limit, false) : $lmt;

        $type = function (object $all_datas) {
            $listDatas = [];
            $tmp = [];
            while ($datas = $all_datas->fetch($this->type)) {
                $listDatas [] = $datas;
            }
            return $tmp = !empty($listDatas) ? $listDatas : "empty";
        };

        $display = function () use ($value, $fields, $type, $cond, $limit) {
            if (isset($value)) {
                $prepare = $this->dataBase->prepare("SELECT {$fields} FROM {$this->table} WHERE {$cond} limit {$limit}");
                $prepare->execute($value);
                return $type($prepare);
            } else {
                $query = $this->dataBase->query("SELECT {$fields} FROM {$this->table} WHERE {$cond} LIMIT {$limit}");
                return $type($query);
                // condition and value
            }
        };
        return $display();
    }

    public function update (int $id, array $datas)
    {
        $attrs = $this->attrs;
        array_shift($attrs);
        array_push($attrs, $this->id);
        array_push($datas, $id);
        $reqUp = $this->magic($attrs, false, true);
        $cond = $this->id.'=:'.$this->id;
        
        $update = $this->dataBase->prepare("UPDATE {$this->table} SET {$reqUp} WHERE {$cond}");
        return $update->execute($this->request($attrs, $datas));
    }

    public function delete (int $id)
    {
        $cond = $this->id.'=:'.$this->id;
        // var_dump([$this->id => $id]);
        $delete = $this->dataBase->prepare("DELETE FROM {$this->table} WHERE {$cond}");
        $delete->execute([$this->id => $id]);
    }
}

?>