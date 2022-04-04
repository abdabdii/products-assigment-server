<?php

namespace App\Controllers;

use App\Models\Product;
use PDO;


class ProductsController
{
    /**
     * Clears input to prepare it for the next operation
     *
     * @param  Int $idIn id of a product
     * @param  String $skuIn sku of a product
     * @param  String $nameIn name of a product
     * @param  Float $priceIn price of a product
     * @param  String $descriptionIn description of a product
     * @return Array Cleared input
     */
    private function clearInput($idIn=null, $skuIn=null, $nameIn=null, $priceIn=null, $descriptionIn=null)
    {
        $id = $idIn != ''?
            filter_var($idIn,FILTER_SANITIZE_STRING):
            null;
        $sku = trim($skuIn) != ''?
            filter_var($skuIn, FILTER_SANITIZE_STRING):
            null;
        $name = trim($nameIn) != ''?
                filter_var($nameIn, FILTER_SANITIZE_STRING):
                null;
        $price = trim($priceIn) !=''?
                strval(round(filter_var(floatval($priceIn), FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),2)):
                null;
        $description = trim($descriptionIn) != ''?
                    filter_var($descriptionIn, FILTER_SANITIZE_STRING):
                    null;
        return array(
            'id' => $id,
            'sku' => $sku,
            'name' => $name,
            'price' => $price,
            'description' => $description
        );
    }


    public static function create()
    {


        $product = new Product();
        $data = json_decode(file_get_contents('php://input'));
        $clearedOutput = (new self)->clearInput(
            null,
            $data->sku,
            $data->name,
            $data->price,
            $data->description
        );
        extract($clearedOutput);

        $product->setSku($sku);
        $product->setName($name);
        $product->setPrice($price);
        $product->setDescription($description);

        $isUnique = $product->create();
        if ($isUnique) {
            http_response_code(201);
            echo json_encode(array(
                'id' => $product->getId(),
                'sku' => $sku,
                'name' => $name,
                'price' => $price,
                'description' => $description
            ));
        } else {
            http_response_code(400);
            echo json_encode(array('message' => 
            'Error Could not make product either sku duplicated or a field is empty'));
        }
    }

    public static function read()
    {

        $product = new Product();

        $products = $product->read();

        $productCount = $products->rowCount();

        if ($productCount > 0) {
            echo json_encode($products->fetchAll(PDO::FETCH_ASSOC));
        } else {
            echo json_encode(array('message'=>'No products found'));
        }
    }

    public static function delete()
    {
        $product = new Product();
        $data = json_decode(file_get_contents('php://input'));
        $clearedOutput = (new self)->clearInput($data->id);
        extract($clearedOutput);
        $product->setId($id);
       
        $delete = $product->delete();
        if ($delete) {
            http_response_code(204);
        } else {
            http_response_code(404);
            echo json_encode(array('message' => 
            'Error could not find product with such id'));
        }
    }

    public static function notFound()
    {
        http_response_code(404);
        echo json_encode(array(
            'message' => 'Endpoint does not exist'
        ));
    }
}