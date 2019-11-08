<?php

use Faker\Factory as Faker;
use Tests\TestCase;
use App\Product;

define('PRODUCTTOGET', 6);
define('PRODUCTTOEDIT', 20);
define('PRODUCTTODELETE', 32);

class ProductTest extends TestCase
{
    // ------------------------------ Create cases --------------------------------
    /**
     * @ID CREATE-1
     * Should create a product.
     * @method POST
     * @route /products
     */
    public function testShouldCreateAProducts()
    {
        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'products',
                "attributes" => [
                    "name" => $faker->word,
                    "price" => $faker->randomFloat(4, 1, 100),
                ]
            ]
        ];

        // Act
        $response = $this->call('POST', '/products', $product);

        //Assert
        $this->assertEquals(201, $response->status());
        $this->seeJsonStructure([ 'data' => [
            'type',
            'id',
            'attributes' => [
                "name",
                "price"
            ],
            "links" => [
                "self"
            ]
        ]
        ]);
    }

    /**
     * @ID CREATE-2
     * Should create a product.
     * @method POST
     * @route /products
     */
    public function testShouldCreateAProductsWithoutNameFiled()
    {
        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'products',
                "attributes" => [
                    "price" => $faker->randomFloat(4, 1, 100),
                ]
            ]
        ];

        // Act
        $response = $this->call('POST', '/products', $product);

        //Assert
        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-1',
                'title' => 'UnprocessableEntity',
            ]
        ]);
    }

    /**
     * @ID CREATE-3
     * Should create a product.
     * @method POST
     * @route /products
     */
    public function testShouldCreateAProductsWithoutPriceFiled()
    {
        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'product',
                "attributes" => [
                    "name" => $faker->word,
                ]
            ]
        ];

        // Act
        $response = $this->call('POST', '/products', $product);

        //Assert
        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-1',
                'title' => 'UnprocessableEntity',
            ]
        ]);
    }

    /**
     * @ID CREATE-4
     * Should create a product.
     * @method POST
     * @route /products
     */
    public function testShouldCreateAProductsWithAStringAsAPrice()
    {
        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'product',
                "attributes" => [
                    "name" => $faker->word,
                    "price" => $faker->word,
                ]
            ]
        ];

        // Act
        $response = $this->call('POST', '/products', $product);

        //Assert
        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-1',
                'title' => 'UnprocessableEntity',
            ]
        ]);
    }

    /**
     * @ID CREATE-5
     * Should create a product.
     * @method POST
     * @route /products
     */
    public function testShouldCreateAProductsWithANegativePrice()
    {
        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'products',
                "attributes" => [
                    "name" => $faker->word,
                    "price" => $faker->randomFloat(4, -100, 0),
                ]
            ]
        ];

        // Act
        $response = $this->call('POST', '/products', $product);

        //Assert
        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-1',
                'title' => 'UnprocessableEntity',
            ]
        ]);
    }
    // ------------------------------ Edit cases --------------------------------
    /**
     * @ID UPDATE-1
     * Should edit a product.
     * @method PUT
     * @route /products/{id}
     */
    public function testShouldEditAProduct()
    {
        // Arrange
        $faker = Faker::create();
        $new_product = new Product();
        $new_product->name = $faker->word;
        $new_product->price = $faker->randomFloat(4, 1, 100);
        $new_product->save();
        $productId = $new_product->id;

        $product = [
            "data" => [
                "type" => 'products',
                "attributes" => [
                    "name" => $faker->word,
                    "price" => $faker->randomFloat(4, 1, 100),
                ]
            ]
        ];

        // Act
        $response = $this->call('PUT', '/products/'.$productId, $product);

        //Assert
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure([ 'data' => [
            'type',
            'id',
            'attributes' => [
                "name",
                "price"
            ],
            "links" => [
                "self"
            ]
        ]
        ]);
    }

    /**
     * @ID UPDATE-2
     * Should edit a product.
     * @method PUT
     * @route /products/{id}
     */
    public function testShouldntEditAProductWithAStringAsPrice()
    {
        // Arrange
        $faker = Faker::create();
        $new_product = new Product();
        $new_product->name = $faker->word;
        $new_product->price = $faker->randomFloat(4, 1, 100);
        $new_product->save();
        $productId = $new_product->id;

        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'products',
                "attributes" => [
                    "name" => $faker->word,
                    "price" => $faker->word,
                ]
            ]
        ];

        // Act
        $response = $this->call('PUT', '/products/'.$productId, $product);

        //Assert
        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-1',
                'title' => 'UnprocessableEntity',
            ]
        ]);
    }
    /**
     * @ID UPDATE-3
     * Should edit a product.
     * @method PUT
     * @route /products/{id}
     */
    public function testShouldntEditAProductWithANegativePrice()
    {
        // Arrange
        $faker = Faker::create();
        $new_product = new Product();
        $new_product->name = $faker->word;
        $new_product->price = $faker->randomFloat(4, 1, 100);
        $new_product->save();
        $productId = $new_product->id;

        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'products',
                "attributes" => [
                    "name" => $faker->word,
                    "price" => $faker->randomFloat(4, -100, 0),
                ]
            ]
        ];

        // Act
        $response = $this->call('PUT', '/products/'.$productId, $product);

        //Assert
        $this->assertEquals(422, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-1',
                'title' => 'UnprocessableEntity',
            ]
        ]);
    }
    /**
     * @ID UPDATE-4
     * Should edit a product.
     * @method PUT
     * @route /products/{id}
     */
    public function testShouldntEditAnInexistentProduct()
    {
        // Arrange
        $productId = 0;

        // Arrange
        $faker = Faker::create();
        $product = [
            "data" => [
                "type" => 'products',
                "attributes" => [
                    "name" => $faker->word,
                    "price" => $faker->randomFloat(4, 1, 100),
                ]
            ]
        ];

        // Act
        $response = $this->call('PUT', '/products/'.$productId, $product);

        //Assert
        $this->assertEquals(404, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-2',
                'title' => 'NotFound',
            ]
        ]);
    }

    // ------------------------------ Show sinlge cases -------------------------
    /**
     * @ID SHOW-1
     * Should return a single product.
     * @method GET
     * @route /products/{id}
     */
    public function testShouldReturnAProduct()
    {
        // Arrange
        $faker = Faker::create();
        $new_product = new Product();
        $new_product->name = $faker->word;
        $new_product->price = $faker->randomFloat(4, 1, 100);
        $new_product->save();
        $productId = $new_product->id;

        // Act
        $response = $this->call('GET', '/products/'.$productId);

        //Assert
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure([ 'data' => [
            'type',
            'id',
            'attributes' => [
                "name",
                "price"
            ],
            "links" => [
                "self"
            ]
        ]
        ]);
    }
    /**
     * @ID SHOW-2
     * Should return a single product.
     * @method GET
     * @route /products/{id}
     */
    public function testShouldReturnAnInexistentProduct()
    {
        // Arrange
        $productId = 0;

        // Act
        $response = $this->call('GET', '/products/'.$productId);

        //Assert
        $this->assertEquals(404, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-2',
                'title' => 'NotFound',
            ]
        ]);
    }
    // ------------------------------ Show all cases ----------------------------
    /**
     * @ID LIST-1
     * Should return all the products.
     * @method GET
     * @route /products
     */
    public function testShouldReturnAllProducts()
    {
        // Act
        $response = $this->call('GET', '/products');

        //Assert
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure([['data' => [
            'type',
            'id',
            'attributes' => [
                "name",
                "price"
            ],
            "links" => [
                "self"
            ]
        ]]]);
    }
    /**
     * @ID LIST-2
     * Should return all the products.
     * @method GET
     * @route /products
     */
    public function testShouldReturnAnEmptyListProducts()
    {
        // Arrange
        Product::truncate();

        // Act
        $response = $this->call('GET', '/products');

        //Assert
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure([ '*' => [] ]);
    }
    // ------------------------------ Delete cases ------------------------------
    /**
     * @ID DELETE-1
     * Delete a product.
     * @method DELETE
     * @route /products/{id}
     */
    public function testShouldDeleteAProduct()
    {
        // Arrange
        $faker = Faker::create();
        $new_product = new Product();
        $new_product->name = $faker->word;
        $new_product->price = $faker->randomFloat(4, 1, 100);
        $new_product->save();
        $productId = $new_product->id;

        // Act
        $response = $this->call('DELETE', '/products/'.$productId);

        //Assert
        $this->assertEquals(204, $response->status());
    }
    /**
     * @ID DELETE-2
     * Delete a product.
     * @method DELETE
     * @route /products/{id}
     */
    public function testShouldntDeleteAnInexistentProduct()
    {
        // Arrange
        $productId = 0;

        // Act
        $response = $this->call('DELETE', '/products/'.$productId);

        //Assert
        $this->assertEquals(404, $response->status());
        $this->seeJson([
            'errors' => [
                'code' => 'ERROR-2',
                'title' => 'NotFound',
            ]
        ]);
    }
}