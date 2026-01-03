<?php

declare(strict_types=1);

namespace App\Tests\Petshop;

use PHPUnit\Framework\TestCase;
use App\Handler\Petshop\PetsHandler;
use PetshopApi\Api\Handler\PetsApiHandlerInterface;
use PetshopApi\Api\Response\AddPet200Response;
use PetshopApi\Api\Response\AddPet0Response;
use PetshopApi\Api\Response\DeletePet204Response;
use PetshopApi\Api\Response\DeletePet0Response;
use PetshopApi\Api\Response\FindPetById200Response;
use PetshopApi\Api\Response\FindPetById0Response;
use PetshopApi\Api\Response\FindPets200Response;
use PetshopApi\Api\Response\FindPets0Response;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * Tests for Pets Handler Implementation
 */
class PetsHandlerTest extends TestCase
{
    private PetsHandler $handler;

    protected function setUp(): void
    {
        PetsHandler::resetPets();
        $this->handler = new PetsHandler();
    }

    public function test_handler_implements_interface(): void
    {
        $this->assertInstanceOf(
            PetsApiHandlerInterface::class,
            $this->handler,
            'Handler should implement PetsApiHandlerInterface'
        );
    }

    // --- addPet tests ---

    public function test_add_pet_returns_200_response(): void
    {
        $newPet = new NewPet(name: 'Rex', tag: 'dog');

        $result = $this->handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_add_pet_returns_correct_data(): void
    {
        PetsHandler::resetPets();
        $handler = new PetsHandler();

        $newPet = new NewPet(name: 'New Pet', tag: 'new');
        $result = $handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Response::class, $result);
        $pet = $result->getData();
        $this->assertEquals('New Pet', $pet->name);
        $this->assertEquals('new', $pet->tag);
    }

    public function test_add_pet_without_tag(): void
    {
        $newPet = new NewPet(name: 'Tagless Pet');

        $result = $this->handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Response::class, $result);
        $pet = $result->getData();
        $this->assertNull($pet->tag);
    }

    // --- deletePet tests ---

    public function test_delete_pet_returns_204_for_existing_pet(): void
    {
        // Pet with ID 1 is created in constructor
        $result = $this->handler->deletePet(1);

        $this->assertInstanceOf(DeletePet204Response::class, $result);
        $this->assertEquals(204, $result->getStatusCode());
    }

    public function test_delete_pet_returns_error_for_non_existing_pet(): void
    {
        $result = $this->handler->deletePet(999);

        $this->assertInstanceOf(DeletePet0Response::class, $result);
    }

    public function test_delete_pet_twice_returns_error_second_time(): void
    {
        $this->handler->deletePet(1);
        $result = $this->handler->deletePet(1);

        $this->assertInstanceOf(DeletePet0Response::class, $result);
    }

    // --- findPetById tests ---

    public function test_find_pet_by_id_returns_200_for_existing_pet(): void
    {
        $result = $this->handler->findPetById(1);

        $this->assertInstanceOf(FindPetById200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_find_pet_by_id_returns_correct_data(): void
    {
        $result = $this->handler->findPetById(1);

        $this->assertInstanceOf(FindPetById200Response::class, $result);
        $pet = $result->getData();
        $this->assertEquals('Fluffy', $pet->name);
        $this->assertEquals('cat', $pet->tag);
    }

    public function test_find_pet_by_id_returns_error_for_non_existing_pet(): void
    {
        $result = $this->handler->findPetById(999);

        $this->assertInstanceOf(FindPetById0Response::class, $result);
    }

    public function test_find_all_initial_pets(): void
    {
        // Initial pets have IDs 1, 2, 3
        for ($id = 1; $id <= 3; $id++) {
            $result = $this->handler->findPetById($id);
            $this->assertInstanceOf(FindPetById200Response::class, $result);
        }
    }

    // --- findPets tests ---

    public function test_find_pets_returns_200_response(): void
    {
        $result = $this->handler->findPets();

        $this->assertInstanceOf(FindPets200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_find_pets_with_tag_filter(): void
    {
        $result = $this->handler->findPets(['cat']);

        $this->assertInstanceOf(FindPets200Response::class, $result);
    }

    public function test_find_pets_with_multiple_tags(): void
    {
        $result = $this->handler->findPets(['cat', 'dog']);

        $this->assertInstanceOf(FindPets200Response::class, $result);
    }

    public function test_find_pets_with_limit(): void
    {
        $result = $this->handler->findPets(null, 1);

        $this->assertInstanceOf(FindPets200Response::class, $result);
    }

    public function test_find_pets_with_tag_and_limit(): void
    {
        $result = $this->handler->findPets(['dog'], 5);

        $this->assertInstanceOf(FindPets200Response::class, $result);
    }

    public function test_find_pets_with_non_matching_tag_returns_error(): void
    {
        $result = $this->handler->findPets(['elephant']);

        // When no pets match, handler returns error response
        $this->assertInstanceOf(FindPets0Response::class, $result);
    }

    // --- Integration tests ---

    public function test_add_then_find_pet(): void
    {
        $newPet = new NewPet(name: 'Integration Test Pet', tag: 'test');
        $addResult = $this->handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Response::class, $addResult);

        // The pet was added with a new ID (after initial 1,2,3)
        $findResult = $this->handler->findPetById(4);
        $this->assertInstanceOf(FindPetById200Response::class, $findResult);
    }

    public function test_add_then_delete_pet(): void
    {
        $newPet = new NewPet(name: 'Delete Test Pet', tag: 'delete');
        $this->handler->addPet($newPet);

        $deleteResult = $this->handler->deletePet(4);
        $this->assertInstanceOf(DeletePet204Response::class, $deleteResult);

        // Pet should no longer exist
        $findResult = $this->handler->findPetById(4);
        $this->assertInstanceOf(FindPetById0Response::class, $findResult);
    }
}
