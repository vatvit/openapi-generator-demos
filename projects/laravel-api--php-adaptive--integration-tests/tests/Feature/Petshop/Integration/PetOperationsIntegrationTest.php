<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop\Integration;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;
use PetshopApi\Model\NewPet;
use App\Handlers\Petshop\PetsHandler;
use App\Handlers\Petshop\SearchHandler;
use App\Handlers\Petshop\CreationHandler;
use App\Handlers\Petshop\RetrievalHandler;
use App\Handlers\Petshop\AdminHandler;
use App\Handlers\Petshop\ManagementHandler;

/**
 * Integration tests for Petshop pet operations.
 *
 * Tests the handler implementations with real model DTOs.
 */
class PetOperationsIntegrationTest extends TestCase
{
    private PetsHandler $petsHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->petsHandler = new PetsHandler();
    }

    // =========================================================================
    // addPet Tests
    // =========================================================================

    /**
     * Test addPet returns 201 with pet data.
     */
    public function testAddPetReturns201WithPetData(): void
    {
        $newPet = new NewPet('Fluffy');

        $response = $this->petsHandler->addPet($newPet);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertEquals('Fluffy', $data['name']);
    }

    /**
     * Test addPet with tag.
     */
    public function testAddPetWithTag(): void
    {
        $newPet = new NewPet('Buddy', 'dog');

        $response = $this->petsHandler->addPet($newPet);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Buddy', $data['name']);
        $this->assertEquals('dog', $data['tag']);
    }

    /**
     * Test addPet without tag (null).
     */
    public function testAddPetWithoutTag(): void
    {
        $newPet = new NewPet('Whiskers');

        $response = $this->petsHandler->addPet($newPet);

        $data = json_decode($response->getContent(), true);
        $this->assertNull($data['tag']);
    }

    /**
     * Test addPet generates unique IDs.
     */
    public function testAddPetGeneratesUniqueIds(): void
    {
        $pet1 = new NewPet('Pet1');
        $pet2 = new NewPet('Pet2');

        $response1 = $this->petsHandler->addPet($pet1);
        $response2 = $this->petsHandler->addPet($pet2);

        $data1 = json_decode($response1->getContent(), true);
        $data2 = json_decode($response2->getContent(), true);

        $this->assertNotEquals($data1['id'], $data2['id']);
    }

    /**
     * Test addPet via CreationHandler returns same structure.
     */
    public function testAddPetViaCreationHandler(): void
    {
        $handler = new CreationHandler();
        $newPet = new NewPet('CreatedPet', 'cat');

        $response = $handler->addPet($newPet);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('CreatedPet', $data['name']);
        $this->assertEquals('cat', $data['tag']);
    }

    /**
     * Test addPet via ManagementHandler returns same structure.
     */
    public function testAddPetViaManagementHandler(): void
    {
        $handler = new ManagementHandler();
        $newPet = new NewPet('ManagedPet');

        $response = $handler->addPet($newPet);

        $this->assertEquals(201, $response->getStatusCode());
    }

    // =========================================================================
    // findPetById Tests
    // =========================================================================

    /**
     * Test findPetById returns 200 with pet data.
     */
    public function testFindPetByIdReturns200WithPetData(): void
    {
        $response = $this->petsHandler->findPetById(123);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertEquals(123, $data['id']);
    }

    /**
     * Test findPetById returns correct ID.
     */
    public function testFindPetByIdReturnsCorrectId(): void
    {
        $response = $this->petsHandler->findPetById(456);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(456, $data['id']);
    }

    /**
     * Test findPetById includes tag.
     */
    public function testFindPetByIdIncludesTag(): void
    {
        $response = $this->petsHandler->findPetById(1);

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('tag', $data);
    }

    /**
     * Test findPetById via RetrievalHandler returns same structure.
     */
    public function testFindPetByIdViaRetrievalHandler(): void
    {
        $handler = new RetrievalHandler();

        $response = $handler->findPetById(789);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(789, $data['id']);
    }

    // =========================================================================
    // findPets Tests
    // =========================================================================

    /**
     * Test findPets returns 200 with pets array.
     */
    public function testFindPetsReturns200WithPetsArray(): void
    {
        $response = $this->petsHandler->findPets();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);
    }

    /**
     * Test findPets returns pets with required fields.
     */
    public function testFindPetsReturnsPetsWithRequiredFields(): void
    {
        $response = $this->petsHandler->findPets();

        $data = json_decode($response->getContent(), true);
        $this->assertNotEmpty($data);

        $pet = $data[0];
        $this->assertArrayHasKey('id', $pet);
        $this->assertArrayHasKey('name', $pet);
        $this->assertArrayHasKey('tag', $pet);
    }

    /**
     * Test findPets with tag filter.
     */
    public function testFindPetsWithTagFilter(): void
    {
        $response = $this->petsHandler->findPets(['cat']);

        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);

        // All returned pets should have 'cat' tag
        foreach ($data as $pet) {
            $this->assertEquals('cat', $pet['tag']);
        }
    }

    /**
     * Test findPets with limit.
     */
    public function testFindPetsWithLimit(): void
    {
        $response = $this->petsHandler->findPets(null, 2);

        $data = json_decode($response->getContent(), true);
        $this->assertLessThanOrEqual(2, count($data));
    }

    /**
     * Test findPets with tag filter and limit.
     */
    public function testFindPetsWithTagFilterAndLimit(): void
    {
        $response = $this->petsHandler->findPets(['cat'], 1);

        $data = json_decode($response->getContent(), true);
        $this->assertLessThanOrEqual(1, count($data));
    }

    /**
     * Test findPets via SearchHandler returns same structure.
     */
    public function testFindPetsViaSearchHandler(): void
    {
        $handler = new SearchHandler();

        $response = $handler->findPets();

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);
    }

    /**
     * Test findPets returns multiple pets.
     */
    public function testFindPetsReturnsMultiplePets(): void
    {
        $response = $this->petsHandler->findPets();

        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThan(1, count($data));
    }

    /**
     * Test findPets pets have unique IDs.
     */
    public function testFindPetsPetsHaveUniqueIds(): void
    {
        $response = $this->petsHandler->findPets();

        $data = json_decode($response->getContent(), true);
        $ids = array_column($data, 'id');
        $uniqueIds = array_unique($ids);

        $this->assertCount(count($ids), $uniqueIds);
    }

    // =========================================================================
    // deletePet Tests
    // =========================================================================

    /**
     * Test deletePet returns 204.
     */
    public function testDeletePetReturns204(): void
    {
        $response = $this->petsHandler->deletePet(123);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * Test deletePet returns no meaningful content.
     */
    public function testDeletePetReturnsNoMeaningfulContent(): void
    {
        $response = $this->petsHandler->deletePet(456);

        $data = json_decode($response->getContent(), true);
        // 204 responses should have null or empty content
        $this->assertTrue($data === null || $data === []);
    }

    /**
     * Test deletePet via AdminHandler returns 204.
     */
    public function testDeletePetViaAdminHandler(): void
    {
        $handler = new AdminHandler();

        $response = $handler->deletePet(789);

        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * Test deletePet via ManagementHandler returns 204.
     */
    public function testDeletePetViaManagementHandler(): void
    {
        $handler = new ManagementHandler();

        $response = $handler->deletePet(999);

        $this->assertEquals(204, $response->getStatusCode());
    }

    // =========================================================================
    // Handler Interface Consistency Tests
    // =========================================================================

    /**
     * Test all handlers with addPet return consistent structure.
     */
    public function testAllAddPetHandlersReturnConsistentStructure(): void
    {
        $handlers = [
            new PetsHandler(),
            new CreationHandler(),
            new ManagementHandler(),
        ];

        $pet = new NewPet('ConsistencyTest', 'test');

        foreach ($handlers as $handler) {
            $response = $handler->addPet($pet);
            $data = json_decode($response->getContent(), true);

            $this->assertArrayHasKey('id', $data, get_class($handler) . ' should return id');
            $this->assertArrayHasKey('name', $data, get_class($handler) . ' should return name');
            $this->assertArrayHasKey('tag', $data, get_class($handler) . ' should return tag');
        }
    }

    /**
     * Test all handlers with findPets return consistent structure.
     */
    public function testAllFindPetsHandlersReturnConsistentStructure(): void
    {
        $handlers = [
            new PetsHandler(),
            new SearchHandler(),
        ];

        foreach ($handlers as $handler) {
            $response = $handler->findPets();
            $data = json_decode($response->getContent(), true);

            $this->assertIsArray($data, get_class($handler) . ' should return array');
            $this->assertNotEmpty($data, get_class($handler) . ' should return non-empty array');
        }
    }
}
