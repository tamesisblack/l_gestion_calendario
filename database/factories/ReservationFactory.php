<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Reservation::class;

    public function definition(): array
    {
        $userIds  = User::where('rol_id', 3)->pluck('id')->toArray();
        $consultantIds  = User::where('rol_id', 2)->pluck('id')->toArray();

        $reservationDate = $this->faker->dateTimeBetween('now','+30 days')->format('Y-m-d');
        $startTime = $this->faker->numberBetween(9,15);
        $endTime = $startTime + 1;
        return [
            'user_id' => $this->faker->randomElement($userIds),
            'consulta_id' => $this->faker->randomElement($consultantIds),
            'reservation_date' => $reservationDate,
            'start_time' => sprintf('%02d:00',$startTime),
            'end_time' => sprintf('%02d:00',$endTime),
            'reservation_status' => $this->faker->randomElement(['pendiente','confirmada','cancelada']),
            'payment_status' => $this->faker->randomElement(['pendiente','pagado','fallido']),
            'total_amount' => 50,
        ];
    }
}
