<?php

class Images
{
    private $image;
    private $image_type;

    // Метод получает информацию о изображениях из БД для вывода на странице
    public static function getImages()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM image WHERE status = 1 ORDER BY count_opened DESC';
        $result = $db->prepare($sql);
        $result->execute();

        $images = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $images[$i]['id'] = $row['id'];
            $images[$i]['count_opened'] = $row['count_opened'];
            $images[$i]['name_photo'] = $row['name_photo'];
            $images[$i]['surname'] = $row['surname'];
            $images[$i]['status'] = $row['status'];
            $images[$i]['date'] = $row['date'];
            $images[$i]['name'] = $row['name'];
            $images[$i]['type'] = $row['type'];
            $i++;
        }
        return $images;
    }


    //вставляет имя, фамилию, название фото в БД
    public static function loadImages($name, $surname, $name_photo, $type, $status = 0)
    {
        $db = Db::getConnection();

        if ($status == 1) {
            $sql = 'INSERT INTO image (name, surname, name_photo, status, type) VALUE (:name, :surname, :name_photo, :status, :type)';
            $result = $db->prepare($sql);
            $result->bindParam(':name', $name, PDO::PARAM_STR);
            $result->bindParam(':surname', $surname, PDO::PARAM_STR);
            $result->bindParam(':name_photo', $name_photo, PDO::PARAM_STR);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            $result->bindParam(':type', $type, PDO::PARAM_STR);
        } else {
            $sql = 'INSERT INTO image (name, surname, name_photo, type) VALUE (:name, :surname, :name_photo, :type)';
            $result = $db->prepare($sql);
            $result->bindParam(':name', $name, PDO::PARAM_STR);
            $result->bindParam(':surname', $surname, PDO::PARAM_STR);
            $result->bindParam(':name_photo', $name_photo, PDO::PARAM_STR);
            $result->bindParam(':type', $type, PDO::PARAM_STR);
        }

        if ($result->execute()) {
            //возвращаю id добавленной записи
            return $db->lastInsertId();

        }
    }

    //Метод получает расширение изображения
    public static function getExtensionImage($id){
        $db = Db::getConnection();
        $sql = 'SELECT type FROM image WHERE id = ?';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute(array($id));
        return $result->fetch();
    }


    public static function loadMaxAndMinImages($id, $type)
    {
        $path = PATH . "/views/original_image/{$id}{$type}";
        copy($_FILES['user_file']['tmp_name'], $path);

        $image = new Images();
        $image->load($path);
        $image->resizeToWidth(367);
        $pathMinImage = PATH . "/views/min_image/{$id}{$type}";
        $image->save($pathMinImage);
    }


    //Метод увеличивает количество просмотров определённого изоюражения
    public static function countOfViewsImage($id)
    {
        $db = Db::getConnection();
        $sql = 'UPDATE image SET count_opened = count_opened + 1 WHERE id = ?';
        $result = $db->prepare($sql);
        $result->execute(array($id));
    }

    function load($filename)
    {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 90, $permissions = null)
    {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    function getWidth()
    {
        return imagesx($this->image);
    }

    function getHeight()
    {
        return imagesy($this->image);
    }

    function resizeToHeight($height)
    {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    function resizeToWidth($width)
    {
        $ratio = $width / $this->getWidth();
        $height = $this->getHeight() * $ratio;
        $this->resize($width, $height);
    }

    function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }


    // Метод получает информацию о всех изображениях из БД для вывода в админ панеле
    public static function getImagesForAdmin()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM image ORDER BY id DESC';
        $result = $db->prepare($sql);
        $result->execute();

        $images = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $images[$i]['id'] = $row['id'];
            $images[$i]['path_original_image'] = $row['path_original_image'];
            $images[$i]['path_min_image'] = $row['path_min_image'];
            $images[$i]['count_opened'] = $row['count_opened'];
            $images[$i]['name_photo'] = $row['name_photo'];
            $images[$i]['surname'] = $row['surname'];
            $images[$i]['status'] = $row['status'];
            $images[$i]['date'] = $row['date'];
            $images[$i]['name'] = $row['name'];
            $i++;
        }
        return $images;
    }


    // Метод получает информацию о изображениях по его id из БД для вывода в админ панеле
    public static function getImageForAdminById($id)
    {

        $db = Db::getConnection();
        $sql = "SELECT * FROM image WHERE id = ?";
        $result = $db->prepare($sql);

        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute(array($id));
        return $result->fetch();
    }


    // Метод меняет информацию о изображениях по его id в БД
    public static function updateImage($id, $name, $surname, $name_photo, $status, $type = false)
    {
        $db = Db::getConnection();
        if ($type){
            $sql = 'UPDATE image SET name = ?, surname = ?, name_photo = ?, status = ?, type = ? WHERE id = ?';
            $result = $db->prepare($sql);
            $result->execute(array($name, $surname, $name_photo, $status, $type, $id));
        } else {
            $sql = 'UPDATE image SET name = ?, surname = ?, name_photo = ?, status = ? WHERE id = ?';
            $result = $db->prepare($sql);
            $result->execute(array($name, $surname, $name_photo, $status, $id));
        }
    }


    // Метод удаляет информацию о изображениях по его id из БД
    public static function deleteImage($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM image WHERE id = ?';
        $result = $db->prepare($sql);
        $result->execute(array($id));
    }
}


