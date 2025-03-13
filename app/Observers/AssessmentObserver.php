<?php

namespace App\Observers;

use App\Jobs\AssessmentRecalculated;
use App\Models\Assessment;

class AssessmentObserver
{
    public function created(Assessment $assessment)
    {
        AssessmentRecalculated::dispatchIf($assessment->is_active, $assessment->advertisement_id);
    }

    public function updated(Assessment $assessment)
    {
        AssessmentRecalculated::dispatch($assessment->advertisement_id);
    }

    public function deleted(Assessment $assessment)
    {
        AssessmentRecalculated::dispatchIf($assessment->is_active, $assessment->advertisement_id);
    }

}
