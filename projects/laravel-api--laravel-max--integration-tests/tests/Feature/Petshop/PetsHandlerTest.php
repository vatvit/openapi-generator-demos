<?php

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use App\Handlers\Petshop\PetsHandler;
use PetshopApi\Api\Handlers\PetsApiHandlerInterface;
use PetshopApi\Api\Http\Resources\AddPet200Resource;
use PetshopApi\Api\Http\Resources\AddPet0Resource;
use PetshopApi\Api\Http\Resources\DeletePet204Resource;
use PetshopApi\Api\Http\Resources\DeletePet0Resource;
use PetshopApi\Api\Http\Resources\FindPetById200Resource;
use PetshopApi\Api\Http\Resources\FindPetById0Resource;
use PetshopApi\Api\Http\Resources\FindPets200Resource;
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

    public function test_add_pet_returns_200_resource(): void
    {
        $newPet = new NewPet(name: 'Rex', tag: 'dog');

        $result = $this->handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Resource::class, $result);
    }

    public function test_add_pet_increments_id(): void
    {
        PetsHandler::resetPets();
        $handler = new PetsHandler();

        // Initial pets have IDs 1, 2, 3 from constructor
        $newPet = new NewPet(name: 'New Pet', tag: 'new');
        $result = $handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Resource::class, $result);
    }

    public function test_add_pet_without_tag(): void
    {
        $newPet = new NewPet(name: 'Tagless Pet');

        $result = $this->handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Resource::class, $result);
    }

    // --- deletePet tests ---

    public function test_delete_pet_returns_204_for_existing_pet(): void
    {
        // Pet with ID 1 is created in constructor
        $result = $this->handler->deletePet(1);

        $this->assertInstanceOf(DeletePet204Resource::class, $result);
    }

    public function test_delete_pet_returns_error_for_non_existing_pet(): void
    {
        $result = $this->handler->deletePet(999);

        $this->assertInstanceOf(DeletePet0Resource::class, $result);
    }

    public function test_delete_pet_twice_returns_error_second_time(): void
    {
        $this->handler->deletePet(1);
        $result = $this->handler->deletePet(1);

        $this->assertInstanceOf(DeletePet0Resource::class, $result);
    }

    // --- findPetById tests ---

    public function test_find_pet_by_id_returns_200_for_existing_pet(): void
    {
        $result = $this->handler->findPetById(1);

        $this->assertInstanceOf(FindPetById200Resource::class, $result);
    }

    public function test_find_pet_by_id_returns_error_for_non_existing_pet(): void
    {
        $result = $this->handler->findPetById(999);

        $this->assertInstanceOf(FindPetById0Resource::class, $result);
    }

    public function test_find_all_initial_pets(): void
    {
        // Initial pets have IDs 1, 2, 3
        for ($id = 1; $id <= 3; $id++) {
            $result = $this->handler->findPetById($id);
            $this->assertInstanceOf(FindPetById200Resource::class, $result);
        }
    }

    // --- findPets tests ---

    public function test_find_pets_returns_200_resource(): void
    {
        $result = $this->handler->findPets();

        $this->assertInstanceOf(FindPets200Resource::class, $result);
    }

    public function test_find_pets_with_tag_filter(): void
    {
        $result = $this->handler->findPets(['cat']);

        $this->assertInstanceOf(FindPets200Resource::class, $result);
    }

    public function test_find_pets_with_multiple_tags(): void
    {
        $result = $this->handler->findPets(['cat', 'dog']);

        $this->assertInstanceOf(FindPets200Resource::class, $result);
    }

    public function test_find_pets_with_limit(): void
    {
        $result = $this->handler->findPets(null, 1);

        $this->assertInstanceOf(FindPets200Resource::class, $result);
    }

    public function test_find_pets_with_tag_and_limit(): void
    {
        $result = $this->handler->findPets(['dog'], 5);

        $this->assertInstanceOf(FindPets200Resource::class, $result);
    }

    // --- Integration tests ---

    public function test_add_then_find_pet(): void
    {
        $newPet = new NewPet(name: 'Integration Test Pet', tag: 'test');
        $addResult = $this->handler->addPet($newPet);

        $this->assertInstanceOf(AddPet200Resource::class, $addResult);

        // The pet was added with a new ID (after initial 1,2,3)
        $findResult = $this->handler->findPetById(4);
        $this->assertInstanceOf(FindPetById200Resource::class, $findResult);
    }

    public function test_add_then_delete_pet(): void
    {
        $newPet = new NewPet(name: 'Delete Test Pet', tag: 'delete');
        $this->handler->addPet($newPet);

        $deleteResult = $this->handler->deletePet(4);
        $this->assertInstanceOf(DeletePet204Resource::class, $deleteResult);

        // Pet should no longer exist
        $findResult = $this->handler->findPetById(4);
        $this->assertInstanceOf(FindPetById0Resource::class, $findResult);
    }
}
