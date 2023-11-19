<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $generatedFirstName = $this->faker->firstName;
        $generatedLastName = $this->faker->lastName;
        $generatedUsername = $generatedFirstName . $generatedLastName;
        $generatedEmail = $generatedUsername . '@example.com';
        
        return [
            'title' => $this->faker->randomElement(['Dr', 'Mr', 'Mrs', 'Ms', 'Mx', 'Professor']),
            'student_id' => $this->generateRandomNumericID(),
            'forename_1' => $generatedFirstName,
            'forename_2' => $generatedFirstName,
            'surname' => $generatedLastName,
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'date_of_birth' => $this->faker->date,
            'username' => substr($generatedUsername, 0, 6), // Get the first 6 characters
            'email' => $generatedEmail,
        ];
    }

    public function generateRandomNumericID() {
        $id = $this->faker->numerify('########');
        while (strlen($id) < 8) {
            $id = $this->faker->numerify('########');
        }
        return $id;
    }
}
