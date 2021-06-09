<?php
    class Model{
        private $_db;
        public function __construct($dbName,$usr,$pwd){
            $dsn = "mysql:dbname={$dbName};port=3306;host=localhost";
            try{
                $this->_db = new PDO($dsn,$usr,$pwd);
            }catch(PDOException $e){
                echo "Not connecting to database ".$e->getMessage();
            }
        }
        public function execSQL($sql){
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            return $stmt;
        }
        public function fetchAll($sql){
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();// tra ve mang 2 chieu
        }
        public function fetchAll1($sql){
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);// tra ve mang 2 chieu
        }
        public function getOne($tbl,$where){
            $sql="SELECT * FROM {$tbl} WHERE {$where}";
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function getPost($id){
            $sql = "SELECT P.pos_id,P.pos_title,P.pos_date,P.pos_content,P.pos_total_view,P.pos_like_and_share,P.pos_short_content,P.pos_img,U.user_name
            FROM tblposts P INNER JOIN tbluser U ON P.user_id=U.user_id 
            WHERE P.pos_id = {$id}";
            print($sql); die;
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function getSelect($tbl,$fKey,$fValue,$slName,$mesHeader,$vFocus=null){
            $select = "<select name='{$slName}' class='form-control' style='width: 400px;'>
            <option value='-1'>{$mesHeader}</option>";
            $sql = "SELECT {$fKey},{$fValue} 
                    FROM {$tbl}
                    WHERE 1=1 ";
            $rs = $this->fetchAll($sql);
            if(count($rs)>0){
                foreach($rs as $row){
                    $vKey = $row[$fKey];
                    $vValue = $row[$fValue];
                    $select .="<option value='{$vKey}'>{$vValue}</option>";
                }
            }
            $select .= "</select>";
            if($vFocus!=null){
                $select = str_replace("<option value='{$vFocus}'>","<option value='{$vFocus}' selected='selected'>",$select);
            }
            return $select;
        }
        public function insert($tbl,$data){
            $arKey = array_keys($data);
            $arValue = array_values($data);
            foreach($arValue as $v){
                $arValueNew[] = "'{$v}'"; 
            }
            $lsKeys = (count($arKey)>0)?implode(',',$arKey):'';
            $lsValues = (count($arValueNew)>0)?implode(',',$arValueNew):'';
            if(strlen($lsKeys)>0&&strlen($lsValues)>0){
               $sql  = "INSERT INTO {$tbl}({$lsKeys}) VALUES({$lsValues})"; 
                if($this->execSQL($sql)){
                    return 1;
                }    
            }
        }
        public function selectField($tbl,$fKey,$slName,$mesHeader){
            $select = "<select name='{$slName}'>
                        <option value='-1'>{$mesHeader}</option>";
            $sql = "SHOW COLUMNS FROM {$tbl}";
            $rs = $this->fetchAll($sql);
            if(count($rs)>0){
                foreach($rs as $row){
                    $vKey = $row['Field'];
                    $select .="<option value='{$vKey}'>{$vKey}</option>";
               }
            }
            $select .= "</select>";
            return $select;
        }
        function update($tbl,$data,$condition){
            $arKey = array_keys($data);
            $arValue = array_values($data);
            $i=0;
            $sql = "UPDATE {$tbl} SET ";
            while($i<count($arKey)){
                $sql .= "$arKey[$i] = '$arValue[$i]' ,";
                $i++;
            }
            $sql = rtrim($sql,',');
            $sql .="WHERE $condition";
            if($this->execSQL($sql)){
                return 1;
            }     
        }
        public function delete($tbl,$condition){
            $sql = "DELETE FROM {$tbl} WHERE {$condition}";
            if($this->execSQL($sql)){
                return 1;
           }  
        }
        public function limit($current_page,$start,$limit){
            $start+=1;
            return $start;
        }
    }