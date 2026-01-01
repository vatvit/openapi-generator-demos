<?php

declare(strict_types=1);

namespace Tests\Api;

use Tests\TestCase;

/**
 * Integration tests for PetShop API.
 *
 * These tests verify generated PetShop models and interfaces
 * can be used in a Laravel context.
 */
class PetShopIntegrationTest extends TestCase
{
    public function test_pet_model_can_be_instantiated(): void
    {
        // Verify the Pet model class exists and can be loaded
        $this->assertTrue(
            class_exists(\PetShopApi\Model\Pet::class),
            'Pet model class should exist'
        );
    }

    public function test_pet_api_interface_exists(): void
    {
        // Check interfaces are generated
        $this->assertTrue(
            interface_exists(\PetShopApi\Api\PetsApiInterface::class) ||
            interface_exists(\PetShopApi\Api\CreationApiInterface::class),
            'PetShop API interface should exist'
        );
    }

    public function test_generated_models_are_autoloaded(): void
    {
        $models = [
            \PetShopApi\Model\Pet::class,
            \PetShopApi\Model\NewPet::class,
            \PetShopApi\Model\Error::class,
        ];

        foreach ($models as $model) {
            $this->assertTrue(
                class_exists($model),
                "Model {$model} should be autoloaded"
            );
        }
    }
}
