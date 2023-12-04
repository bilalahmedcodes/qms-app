<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VoiceAudit>
 */
class VoiceAuditFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $evaluators = [816409, 297859, 191664, 900824, 581231, 504418];
        $associates = [698377, 230183, 63232, 300026, 938009, 965908];
        $team_leads = [299837,518106,708248,586755,517942];
        return [
            'user_id' => "297859",
            'associate_id' => $this->faker->randomElement($associates),
            'team_lead_id' => $this->faker->randomElement($team_leads),
            'manager_id' => 10139,
            'campaign_id' => 4,
            'project_id' => $this->faker->randomElement($array = [76,77,78]),
            'call_date' => now(),
            'percentage' => $this->faker->randomFloat($nbMaxDecimals = null, $min = 50, $max = 98),
            'customer_name' => $this->faker->name(),
            'customer_phone' => 12345678,
            'recording_duration' => '00:20:01',
            'recording_link' => $this->faker->imageUrl($width = 640, $height = 480),
            'client_outcome' => $this->faker->randomElement($array = ['accepted', 'rejected']),
            'call_type' => $this->faker->randomElement($array = ['general', 'sales']),
            'notes' => $this->faker->text($maxNbChars = 100),
            'evaluation_time' => '00:04:25',
        ];
    }
}
