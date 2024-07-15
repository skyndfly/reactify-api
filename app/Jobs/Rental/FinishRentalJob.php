<?php

namespace App\Jobs\Rental;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FinishRentalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $id;
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var Rental $model */
        $model = Rental::find($this->id);
        if (!$model){
            Log::error("Rental with ID {$this->id} not found.");
        }
        $model->updateStatus(Rental::STATUS_COMPLETED);

        /** @var Car $car */
        $car = $model->car();
        $car->updateAvailabilityActive();

    }
}
