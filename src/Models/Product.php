<?php

namespace App\Models;

use App\Models\AbstractModel;


class Product extends AbstractModel
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $description;
    protected $table='products';

    
    public function read()
    {
        $query = 'SELECT * FROM '.$this->table.' ORDER BY id ';
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        try{
            $query = 'INSERT INTO '.$this->table.'(sku,name,price,description)
            VALUES (:sku, :name, :price, :description)';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':sku',$this->sku);
            $stmt->bindParam(':name',$this->name);
            $stmt->bindParam(':price',$this->price);
            $stmt->bindParam(':description',$this->description);

            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        }
        catch(\PDOException $e) {
            return false;

        }
    }


    public function delete()
    {
        try{
            $arrayOfIds = explode(',', $this->id);
            $idsPlaceHOlder = str_repeat ('?, ',  count($arrayOfIds) - 1) . '?';
            $query = 'DELETE FROM '.$this->table.' WHERE id IN ('.$idsPlaceHOlder.')';
            $stmt = $this->conn->prepare($query);

            $stmt->execute($arrayOfIds);

            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        }
        catch(\PDOException $e){
            $errorCode = $e->getCode();
            if($errorCode=='42000'){
                return false;
            }

        }


    }
    
    public function setId($id)
    {
        return $this->id = $id;
    }

    public function setSku($sku)
    {
        return $this->sku = $sku;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function setPrice($price)
    {
        return $this->price = $price;
    }

    public function setDescription($description)
    {
        return $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }
}