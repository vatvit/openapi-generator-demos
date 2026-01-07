<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionEnum;
use TicTacToeApi\Model\GameMode;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\Mark;
use TicTacToeApi\Model\Winner;

/**
 * Tests that verify the generated enum classes have correct structure.
 */
class EnumGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Enums to test
     */
    private array $expectedEnums = [
        'GameMode' => GameMode::class,
        'GameStatus' => GameStatus::class,
        'Mark' => Mark::class,
        'Winner' => Winner::class,
    ];

    /**
     * Test that all expected enum classes exist.
     */
    public function testAllEnumClassesExist(): void
    {
        foreach ($this->expectedEnums as $name => $class) {
            $this->assertTrue(
                enum_exists($class),
                "Enum {$name} should exist"
            );
        }
    }

    /**
     * Test that all enums are backed by string.
     */
    public function testAllEnumsAreStringBacked(): void
    {
        foreach ($this->expectedEnums as $name => $class) {
            $reflection = new ReflectionEnum($class);
            $this->assertTrue(
                $reflection->isBacked(),
                "Enum {$name} should be backed"
            );
            $this->assertSame(
                'string',
                $reflection->getBackingType()->getName(),
                "Enum {$name} should be backed by string"
            );
        }
    }

    /**
     * Test that GameMode has expected cases.
     */
    public function testGameModeHasExpectedCases(): void
    {
        $cases = GameMode::cases();
        $caseNames = array_map(fn($case) => $case->name, $cases);

        $expectedCases = ['PVP', 'AI_EASY', 'AI_MEDIUM', 'AI_HARD'];

        foreach ($expectedCases as $expected) {
            $this->assertContains(
                $expected,
                $caseNames,
                "GameMode should have case '{$expected}'"
            );
        }
    }

    /**
     * Test that GameStatus has expected cases.
     */
    public function testGameStatusHasExpectedCases(): void
    {
        $cases = GameStatus::cases();
        $caseNames = array_map(fn($case) => $case->name, $cases);

        $expectedCases = ['PENDING', 'IN_PROGRESS', 'COMPLETED', 'ABANDONED'];

        foreach ($expectedCases as $expected) {
            $this->assertContains(
                $expected,
                $caseNames,
                "GameStatus should have case '{$expected}'"
            );
        }
    }

    /**
     * Test that Mark has expected cases.
     */
    public function testMarkHasExpectedCases(): void
    {
        $cases = Mark::cases();
        $caseNames = array_map(fn($case) => $case->name, $cases);

        $this->assertContains('X', $caseNames, "Mark should have case 'X'");
        $this->assertContains('O', $caseNames, "Mark should have case 'O'");
    }

    /**
     * Test that Winner has expected cases.
     */
    public function testWinnerHasExpectedCases(): void
    {
        $cases = Winner::cases();
        $caseNames = array_map(fn($case) => $case->name, $cases);

        // PERIOD represents "no winner yet" (.)
        $expectedCases = ['X', 'O', 'PERIOD'];

        foreach ($expectedCases as $expected) {
            $this->assertContains(
                $expected,
                $caseNames,
                "Winner should have case '{$expected}'"
            );
        }
    }

    /**
     * Test that enums can be created from string values.
     */
    public function testEnumsCanBeCreatedFromValues(): void
    {
        // Test GameMode::from()
        $mode = GameMode::from('pvp');
        $this->assertSame(GameMode::PVP, $mode);

        // Test GameStatus::from()
        $status = GameStatus::from('pending');
        $this->assertSame(GameStatus::PENDING, $status);

        // Test Mark::from()
        $mark = Mark::from('X');
        $this->assertSame(Mark::X, $mark);
    }

    /**
     * Test that enum values are lowercase (matching OpenAPI spec).
     */
    public function testGameModeValuesAreLowercase(): void
    {
        $this->assertSame('pvp', GameMode::PVP->value);
        $this->assertSame('ai_easy', GameMode::AI_EASY->value);
        $this->assertSame('ai_medium', GameMode::AI_MEDIUM->value);
        $this->assertSame('ai_hard', GameMode::AI_HARD->value);
    }

    /**
     * Test that GameStatus values are lowercase.
     */
    public function testGameStatusValuesAreLowercase(): void
    {
        $this->assertSame('pending', GameStatus::PENDING->value);
        $this->assertSame('in_progress', GameStatus::IN_PROGRESS->value);
        $this->assertSame('completed', GameStatus::COMPLETED->value);
        $this->assertSame('abandoned', GameStatus::ABANDONED->value);
    }
}
