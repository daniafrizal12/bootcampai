<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Doctor>
     */
    protected $model = Doctor::class;

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
        $specialties = [
            'Dokter Umum',
            'Spesialis Penyakit Dalam (Sp.PD)',
            'Spesialis Anak (Sp.A)',
            'Spesialis Kandungan & Kebidanan (Sp.OG)',
            'Spesialis Gigi & Mulut (Sp.Ort)',
            'Spesialis Mata (Sp.M)',
            'Spesialis Jantung & Pembuluh Darah (Sp.JP)',
            'Spesialis Kulit & Kelamin (Sp.KK)',
            'Spesialis Saraf (Sp.S)',
            'Spesialis THT-KL',
        ];

        $specialty = fake()->randomElement($specialties);

        return [
            'name' => 'dr. ' . fake()->name(),
            'license_number' => 'STR-' . fake()->unique()->numerify('########'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
            'photo' => null,
            'bio' => fake()->paragraph(2),
            'specialty' => $specialty,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the doctor is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Set specific specialty for the doctor.
     */
    public function specialty(string $specialty): static
    {
        return $this->state(fn (array $attributes) => [
            'specialty' => $specialty,
        ]);
    }
}
