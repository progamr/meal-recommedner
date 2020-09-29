<?php

namespace Tests\Feature;

use Tests\TestCase;

class RecommendFormTest extends TestCase
{
    /**
     * Test form rendering correctly when visiting the appropriate route.
     *
     * @return void
     */
    public function testForBasicRenderWhenVisitingCorrectRoute()
    {
        $response = $this->get('/');

        $response->assertSee('Meal Name');
    }

    /**
     * Test form validation scenario.
     *
     * @return void
     */
    public function testReturningValidationMessagesInSessionInCaseOfThereIsInputErrors()
    {
        $response = $this->post('/find-restaurants-v2', [
            'meal_name' => '',
        ]);

        $response->assertSessionHasErrors(['meal_name' => 'The meal name field is required.']);

    }

    /**
     * Test meal that doesn't exist should show a no results found message scenario.
     *
     * @return void
     */
    public function testShowingNoResultMessageWhenSubmittingAMEalThatDoesntExit()
    {
        $response = $this->post('/find-restaurants-v2', [
            'meal_name' => 'Foo Meal',
        ]);

        $response->assertSee('Sorry, No restaurants found for this meal');

    }

    /**
     * Testing existing meal name should return recommended restaurants scenario.
     *
     * @return void
     */
    public function testShowingRestaurantsResultsWhenSubmittingExistingMealName()
    {
        $response = $this->post('/find-restaurants-v2', [
            'meal_name' => 'Fried Chicken',
        ]);

        $response->assertSee('table');
    }
}
