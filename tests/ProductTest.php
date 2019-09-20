<?php

use Faker\Factory as Faker;
use Tests\TestCase;

define('PRODUCTTOGET', 6);
define('PRODUCTTOEDIT', 7);
define('PRODUCTTODELETE', 8);

class ProductTest extends TestCase
{
    /**
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
        $this->seeJsonStructure([ '*' => [
            'id',
            'name',
            'price'
        ]
        ]);
    }

    /**
     * Should return a single product.
     * @method GET
     * @route /products/{id}
     */
    public function testShouldReturnAProducts()
    {
        // Arrange
        $productId = PRODUCTTOGET;

        // Act
        $response = $this->call('GET', '/products/'.$productId);

        //Assert
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure([ '*' => [
            'id',
            'name',
            'price'
        ]
        ]);
    }

    /**
     * Should create a product.
     * @method POST
     * @route /products
     */
    public function testShouldCreateAProducts()
    {
        // Arrange
        $faker = Faker::create();
        $product = [
            "name" => $faker->word,
            "price" => $faker->randomFloat,
        ];

        // Act
        $response = $this->call('POST', '/products', $product);

        //Assert
        $this->assertEquals(201, $response->status());
        $this->seeJsonStructure([ '*' => [
            'id',
            'name',
            'price'
        ]
        ]);
    }

    /**
     * Should edit a product.
     * @method PUT
     * @route /products/{id}
     */
    public function testShouldEditAProduct()
    {
        // Arrange
        $productId = PRODUCTTOEDIT;

        // Arrange
        $faker = Faker::create();
        $product = [
            "name" => $faker->word,
            "price" => $faker->randomFloat,
        ];

        // Act
        $response = $this->call('PUT', '/products/'.$productId, $product);

        //Assert
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure([ '*' => [
            'id',
            'name',
            'price'
        ]
        ]);
    }

    /**
     * Delete a product.
     * @method DELETE
     * @route /products/{id}
     */
    public function testShouldDeleteAProduct()
    {
        // Arrange
        $productId =  PRODUCTTODELETE;

        // Act
        $response = $this->call('DELETE', '/products/'.$productId);

        //Assert
        $this->assertEquals(200, $response->status());
        $this->assertEquals('"Product deleted"', $response->content());
    }
}