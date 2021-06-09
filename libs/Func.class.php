<?php
    class Func{
        public function uploadFile($file,$sUrl,$arFileType,$maxSize){
            $fileName   = $file['name'];
            $fileSize   = $file['size'];//tra ve byte = 8 bits
            $tmpFileName = $file['tmp_name'];
            $errCode    = '';  
            $ext        = $this->getExtension($fileName);
            //echo $ext; die;
            if(!in_array($ext,$arFileType)){
                $errCode = '101';//khong dung file type
            }
            if($fileSize>$maxSize){
                $errCode = '102';//Vuot qua size cho phep
            }
            if($errCode===''){
                $newfileName =time().'_'.$fileName;
                $new_sUrl = $sUrl.'/'.$newfileName;
                if(move_uploaded_file($tmpFileName,$new_sUrl)){
                    $errCode = $new_sUrl;
                }else{
                    $errCode = '303';//khong len toi server
                }
            } 
            return $errCode; 
        }
        public function getExtension($str){
            $arExt = explode('.',$str);
            $ext = end($arExt);
            return strtolower($ext);
        }
        public function redir($url){
            header("Location: $url");
        }
    }