 
 **Show Products**
----
  Returns json data of all products.

* **URL**

  /listing/products

* **Method:**

  `GET`
  
*  **URL Params**
   
   None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `
{
id: "2",
sku: "JVC990",
name: "Acme Disc",
price: "50.60",
description: "Size: 700 MB"
},
{
id: "3",
sku: "SKUTest000",
name: "NameTest000",
price: "25.00",
description: "Size: 200 MB"
},
{
id: "4",
sku: "SKUTest001",
name: "NameTest001",
price: "25.00",
description: "Weight: 200 KG"
},
{
id: "5",
sku: "SKUTest002",
name: "NameTest002",
price: "25.00",
description: "Dimension: 200x200x200"
}`
 

 
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/listing/products",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
----
 **Create Product**
----
  Returns json data of the new product.

* **URL**

  /listing/products

* **Method:**

  `POST`
  
*  **URL Params**
  
   None

* **Data Params**

  `sku:String `
  
  `name:String `
  
  `price:Float string `
  
  `description:String `

* **Success Response:**

  * **Code:** 201 <br />
    **Content:** `
{
id: "2",
sku: "JVC990",
name: "Acme Disc",
price: "50.60",
description: "Size: 700 MB"
}`
 
* **Error Response:**

  * **Code:** 400 <br />
    **Content:** `{ message : "Error Could not make product either sku duplicated or a field is empty" }`

 
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/listing/products",
      dataType: "json",
      data: {sku: "JVC990", name: "Acme Disc", price: "50.60", description: "Size: 700 MB"},
      type : "POST",
      success : function(r) {
        console.log(r);
      }
    });
  ```
----
 **Delete Product/s**
----
  Deletes multiple or single product.

* **URL**

  /listing/products

* **Method:**

  `GET`
  
*  **URL Params**
  
   None

* **Data Params**

  `id: Comma Seperated string containing 1 or more id`

* **Success Response:**

  * **Code:** 204 <br />
    **Content:**
    
    no content
 
* **Error Response:**

  * **Code:** 404 <br />
    **Content:** `{ message : "Error could not find product with such id" }`

 
* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/listing/products",
      dataType: "json",
      data:{id:"2,5,7,15"},
      type : "DELETE",
      success : function(r) {
        console.log(r);
      }
    });
  ```
 
