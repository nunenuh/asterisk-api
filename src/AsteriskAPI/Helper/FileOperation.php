<?php

namespace AsteriskAPI\Helper;

class FileOperation {

    private $path;

    /**
     * membutuh keberaaan file path yang dikirim dari class Asterisk
     * @param type $path array
     */
    function __construct($path) {
        $this->path = $path;
    }

    public function logpre($var, $details = false) {
        if ($details == false) {
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        } else {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
    }

    /**
     * method ini akan melakukan pengecekan tentang file dari path yang dikirim 
     * apakah file benar atau salah
     * @return boolean 
     */
    public function isFile() {
        return is_file($this->path);
    }

    /**
     * method ini akan melakukan pengecekan terhadap path apakah dia directori atau bukan 
     * @return boolean
     */
    public function isDir() {
        return is_dir($this->path);
    }

    /**
     * method ini melakukan pengecekan apakah file yang ada dalam path itu ADA atau tidak ada
     * dan berupa file atau bukan
     * @return boolean
     */
    public function isExist() {
        return file_exists($this->path);
    }

    /**
     * method ini akan mencari jumlah baris yang ada dalam file
     * @return int 
     * 
     * kalau bernilai 0 maka file tidak ada atau file merupakan directory
     */
    public function countLine() {
        if ($this->isExist() && $this->isFile()) {
            return count(file($this->path));
        } else {
            return 0;
        }
    }

    /**
     * akan melakukan pembacaan file
     * @return boolean 
     */
    public function read() {
        if ($this->isExist() && $this->isFile()) {
            return file_get_contents($this->path);
        } else {
            return false;
        }
    }

    /**
     * akan melakukan pembacaan data berdasarkan id yang dikirim
     * @param type $num number
     * @return boolean 
     */
    public function readByLine($num) {
        if ($this->isExist() && $this->isFile()) {
            $ar = file($this->path);
            return $ar[($num - 1)];
        } else {
            return false;
        }
    }

    /**
     * melakukan penyimpanan data kedalam file
     * @param type $data array onject
     * @return boolean 
     */
    public function write($data) {
        if ($this->isExist() && $this->isFile()) {
            return file_put_contents($this->path, $data);
        } else {
            return false;
        }
    }

    /**
     * akan melakukan penyimpanan data didalam file dan langsung di baris baru atau
     * langsung enter
     * @param type $data array
     * @return boolean 
     */
    public function writeNewline($data) {
        if ($this->isExist() && $this->isFile()) {
            $tmp = file($this->path);
            $c = count($tmp);
            $tmp[$c] = $data;
            $tmp = $this->myImplode("\n", $tmp);
            return $this->write($tmp);
        } else {
            return false;
        }
    }

    /**
     *
     * @param type $num number
     * @param type $data array
     * @return boolean 
     */
    public function writeByLine($num, $data) {
        if ($this->isExist() && $this->isFile()) {
            $tmp = file($this->path); //simpan sementara
            $ctmp = count($tmp);
            $out = ''; //wadah untuk untuk di return
            $lt = 0;
            $lo = 0;
            while ($lt < $ctmp) {
                if ($lt != ($num - 1)) {
                    $out[$lo] = $tmp[$lt];
                    $lo++;
                } else {
                    if (!empty($tmp[$lt])) {
                        $out[$lo] = $tmp[$lt];
                        $lo++; //enter
                        $out[$lo] = $data;
                        $lo++; //enter
                    } else {
                        $out[$lo] = $data;
                        $lo++;
                    }
                }
                $lt++;
            }

//            $this->logpre($out);

            $out = $this->myImplode("\n", $out);
            return $this->write($out);
        } else {
            return false;
        }
    }

    /**
     * melakukan penghapusan berdasarkan id
     * @param type $num number
     * @return boolean 
     */
    public function removeByLine($num) {
        if ($this->isExist() && $this->isFile()) {
            $tmp = file($this->path); //simpan sementara
            $out = ''; //wadah untuk untuk di return
            $l = 0;
            foreach ($tmp as $key => $val) {
                if ($key != ($num - 1)) {
                    $out[$l]=$val;
                    $l++;
                    
                }
            }
            $out = $this->myImplode("\n", $out);
            return $this->write($out);
        } else {
            return false;
        }
    }
    
    /**
     * melakukan penghapusan data dari baris pertama sampai baris terakhir
     * @param type $numStart number
     * @param type $numEnd number
     * @return boolean 
     */
    public function removeByLines($numStart, $numEnd) {
        if ($this->isExist() && $this->isFile()) {
            $tmp = file($this->path); //simpan sementara
            $out = ''; //wadah untuk untuk di return
            $l = 0;
            foreach ($tmp as $key => $val) {
                if (!($key >=($numStart - 1) && $key <=($numEnd-1))) {
                    $out[$l]=$val;
                    $l++; 
                }
            }
            $out = $this->myImplode("\n", $out);
            return $this->write($out);
        } else {
            return false;
        }
    }

    /**
     *
     * @param type $num number
     * @param type $data array
     */
    public function replaceByLine($num, $data) {
        if ($this->isExist() && $this->isFile()) {
            $tmp = file($this->path);
            $tmp[($num - 1)] = $data;
            $tmp = $this->myImplode("\n", $tmp);
            $this->write($tmp);
        } else {
            
        }
    }

    /**
     *
     * @param type $glue escape
     * @param type $array array
     * @return string|boolean 
     */
    private function myImplode($glue, $array) {
        if (is_array($array)) {
            $out = '';
            foreach ($array as $val) {
                $pos = strpos($val, $glue);
                if ($pos !== false) {
                    $out = $out . $val;
                } else {
                    $out = $out . $val . $glue;
                }
            }
            return $out;
        } else {
            return false;
        }
    }

}

?>