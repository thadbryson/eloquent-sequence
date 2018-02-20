<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Exceptions;

use Psr\Log\InvalidArgumentException;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\ExceptionModel;

class MethodMoveTest extends SequenceTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setClass(ExceptionModel::class);
    }

    /** @test */
    public function use_move_method_on_second_element_to_move_on_top()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model2->move(0);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_move_method_on_first_element_to_move_to_bottom()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model1->move(1);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_move_method_on_first_element_to_move_to_bottom_with_overflow_position()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        try {
            $model1->move(2);
        } catch (InvalidArgumentException $ex) {
            return;
        }

        $this->fail('Expected "InvalidArgumentException" to be fired. Nothing happened.');
    }

    /** @test */
    public function use_move_method_on_second_element_to_move_to_top_with_overflow_position()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        try {
            $model2->move(-1);
        } catch (InvalidArgumentException $ex) {
            return;
        }

        $this->fail('Expected "InvalidArgumentException" to be fired. Nothing happened.');
    }
}
