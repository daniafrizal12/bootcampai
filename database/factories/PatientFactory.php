<?php

namespace Database\Factories;

use App\Enums\BloodType;
use App\Enums\Gender;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Patient>
     */
    protected $model = Patient::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement([Gender::Male, Gender::Female]);
        $firstName = $gender === Gender::Male ? fake('id_ID')->firstNameMale() : fake('id_ID')->firstNameFemale();
        $lastName = fake('id_ID')->lastName();
        $name = "{$firstName} {$lastName}";

        $commonAllergies = [
            ['Amoxicillin', 'Penisilin'],
            ['Kacang-kacangan'],
            ['Seafood', 'Udang'],
            ['Aspirin'],
            ['Sulfa'],
            ['Debu', 'Dingin'],
            null,
            null,
            null, // Higher probability of no allergies
        ];

        return [
            'medical_record_number' => 'RM-' . date('Ym') . '-' . fake()->unique()->numerify('####'),
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'date_of_birth' => fake()->dateTimeBetween('-65 years', '-1 years')->format('Y-m-d'),
            'gender' => $gender,
            'national_id' => fake()->unique()->numerify('31710###########'),
            'phone' => '08' . fake()->numerify('##########'),
            'address' => fake('id_ID')->address(),
            'blood_type' => fake()->randomElement([BloodType::A, BloodType::B, BloodType::AB, BloodType::O]),
            'allergies' => fake()->randomElement($commonAllergies),
            'photo' => null,
        ];
    }

    /**
     * Set patient gender as male.
     */
    public function male(): static
    {
        return $this->state(fn (array $attributes) => [
            'gender' => Gender::Male,
        ]);
    }

    /**
     * Set patient gender as female.
     */
    public function female(): static
    {
        return $this->state(fn (array $attributes) => [
            'gender' => Gender::Female,
        ]);
    }
}
