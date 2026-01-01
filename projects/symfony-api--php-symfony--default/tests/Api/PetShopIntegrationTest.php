<?php

declare(strict_types=1);

namespace App\Tests\Api;

use PHPUnit\Framework\TestCase;
use App\Handler\PetShop\PetsHandler;
use App\Handler\PetShop\CreationHandler;
use App\Handler\PetShop\DetailsHandler;
use PetShopApi\Api\PetsApiInterface;
use PetShopApi\Api\CreationApiInterface;
use PetShopApi\Api\DetailsApiInterface;
use PetShopApi\Model\Pet;
use PetShopApi\Model\NewPet;

/**
 * Integration tests for PetShop API.
 *
 * These tests verify:
 * 1. Handler implementations satisfy interfaces
 * 2. Generated models exist
 */
class PetShopIntegrationTest extends TestCase
{
    public function testPetsHandlerImplementsInterface(): void
    {
        $handler = new PetsHandler();
        $this->assertInstanceOf(PetsApiInterface::class, $handler);
    }

    public function testCreationHandlerImplementsInterface(): void
    {
        $handler = new CreationHandler();
        $this->assertInstanceOf(CreationApiInterface::class, $handler);
    }

    public function testDetailsHandlerImplementsInterface(): void
    {
        $handler = new DetailsHandler();
        $this->assertInstanceOf(DetailsApiInterface::class, $handler);
    }

    public function testGeneratedModelsExist(): void
    {
        $this->assertTrue(class_exists(Pet::class), 'Pet model should exist');
        $this->assertTrue(class_exists(NewPet::class), 'NewPet model should exist');
    }

    public function testGeneratedInterfacesExist(): void
    {
        $this->assertTrue(interface_exists(PetsApiInterface::class), 'PetsApiInterface should exist');
        $this->assertTrue(interface_exists(CreationApiInterface::class), 'CreationApiInterface should exist');
        $this->assertTrue(interface_exists(DetailsApiInterface::class), 'DetailsApiInterface should exist');
    }
}
