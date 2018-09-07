<?php

class Media extends Entidad {

    var $id     = 0;
    private $datos = array(
        'tabla'    => "media",
        'manuales' => array(
            'modulo',
            'modid'
        ),
        'id'       => array('id')
    );

    function __construct($id = 0) {
        parent::__construct($id, $this -> datos);
    }

    function existe() {
        return ($this -> id == 0 ? 0 : 1);
    }

    function GetFileStore() {
        global $home;
        if (isset($this -> FileStore)) {
            return $this -> FileStore;
        }
        $dir               = md5($this -> id);
        $a                 = substr($dir, 0, 2);
        $b                 = substr($dir, 2, 2);
        $c                 = substr($dir, 4, 2);
        $d                 = substr($dir, 6, 2);
        $dir               = $home . "media/$a/$b/$c/$d";
        @mkdir($dir, 0700, true);
        $file              = $dir . "/" . $this -> id;
        //if ( (!(file_exists($file))) && (file_exists("media/imgentidad.png")) ) $file="media/imgentidad.png"
        $this -> FileStore = $file;
        return $file;
    }

    function SetFile($file, $modulo = "", $modid = 0) {
        global $db;
        
        $id  = exif_imagetype($file);
        $img = false;
        switch ($id) {
            case 1 :
                $im = imagecreatefromgif($file);
                break;
            case 2 :
                $im = imagecreatefromjpeg($file);
                break;
            case 3 :
                $im = imagecreatefrompng($file);
                break;
        }
        if ($im) {
            $data       = array(
                'id'     => null,
                'modulo' => $modulo,
                'modid'  => $modid
            );
            $this -> id = $db -> insert($this -> datos['tabla'], $data);
            imagepng($im, $this -> GetFileStore());
        } else {
            return false;
        }
    }

    function ShowImg($w = 0, $h = 0, $f = false) {
        if ($f) {
            $fi = $f;
        } else {
            $fi = $this -> GetFileStore();
        }

        $idcache = "media_" . md5($fi . "---" . $w . "-" . $h);

        $tmpdir = sys_get_temp_dir();
        if (file_exists($tmpdir."/".$idcache)) {
            if (filemtime($tmpdir."/".$idcache) > filemtime($fi)) {                
                header('Content-Type: image/png');
                echo file_get_contents($tmpdir."/".$idcache);
                exit;
            }
        }

        $x  = time();
        $im = imagecreatefrompng($fi);

        $x = time() - $x;
        if (($w > 0) || ($h > 0)) {
            if (($w == 0) || ($h == 0)) {
                if ($w == 0) {
                    $w = imagesx($im) * $h / imagesy($im);
                    $w = (int) $w;
                } else {
                    $h = imagesy($im) * $w / imagesx($im);
                    $h = (int) $h;
                }
                $thumb = imagecreatetruecolor($w, $h);
                imagecopyresampled($thumb, $im,
                        //int $dst_x , int $dst_y , int $src_x , int $src_y ,
                        0, 0, 0, 0,
                        //int $dst_w , int $dst_h , int $src_w , int $src_h )
                        $w, $h, imagesx($im), imagesy($im));
                $im    = $thumb;
            } else {
                // redimensacion tanto de w como de h
                $thumb = imagecreatetruecolor($w, $h);
                imagefill($thumb, 0, 0, imagecolorallocate($im, 255, 255, 255));
                $a     = $w / $h;
                $b     = imagesx($im) / imagesy($im);
                if ($a == $b) {
                    imagecopyresampled($thumb, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));
                } else {
                    if ($a > $b) {
                        $newh = $h;
                        $neww = (int) ($newh * imagesx($im) / imagesy($im));
                        $x    = (int) (($w - $neww) / 2);
                        $y    = 0;
                        imagecopyresampled($thumb, $im, $x, $y, 0, 0, $neww, $newh, imagesx($im), imagesy($im));
                    } else {
                        $neww = $w;
                        $newh = (int) ($neww * imagesy($im) / imagesx($im));
                        $y    = (int) (($h - $newh) / 2);
                        $x    = 0;
                        imagecopyresampled($thumb, $im, $x, $y, 0, 0, $neww, $newh, imagesx($im), imagesy($im));
                    }
                }
                $im = $thumb;
            }
        }

        header('Content-Type: image/png');
        imagepng($im, $tmpdir."/".$idcache);
        imagepng($im);
        return true;
    }

    function delete() {
        global $db;
        unlink($this -> GetFileStore());
        $db -> where('id', $this -> id);
        if ($db -> delete($this -> datos['tabla'])) {
            return 1;
        } else {
            return 0;
        }
    }

}

function CrearMediaFromImagen($file, $modulo = "", $modid = 0) {
    $m = new Media();
    $m -> SetFile($file, $modulo, $modid);    
    if ($m -> id > 0) {
        return $m;
    } else {
        return false;
    }
}

function GetMediaFromModulo($modulo, $modid) {
    global $db;

    $db -> where('modulo', $modulo);
    $db -> where('modid', $modid);
    $db -> orderBy('id', 'DESC');
    $row = $db -> getOne('media', null, '*');

    if ($db -> count > 0) {
        $m = new Media($row['id']);
        return $m;
    } else {
        return false;
    }
}
