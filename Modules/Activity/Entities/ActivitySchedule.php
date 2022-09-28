<?php

namespace Modules\Activity\Entities;

use App\Models\Carteira;
use App\Models\Empresa;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ActivitySchedule
 * @package Modules\Activity\Entities
 *
 * @property integer id
 * @property string description
 * @property string status
 * @property string tax_regime
 * @property Date goal
 * @property Date deadline
 * @property string recurrence
 * @property string observation
 * @property Date last_execution
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class ActivitySchedule extends Model
{
    use SoftDeletes;

    const REGIME_ALL = "Todas";
    const REGIME_PRESUMED = 'Presumido';
    const REGIME_SN = 'SN';
    const REGIME_ISENTO = 'Isento';

    const REGIMES = [
        self::REGIME_ALL,
        self::REGIME_PRESUMED,
        self::REGIME_SN,
        self::REGIME_ISENTO,
    ];

    const RECURRENCE_ONLY = 'only';
    const RECURRENCE_WEEKLY = 'weekly';
    const RECURRENCE_MONTHLY = 'monthly';
    const RECURRENCE_SEMIANNUAL = 'semiannual';
    const RECURRENCE_YEARLY = 'yearly';

    const RECURRENCES = [
        self::RECURRENCE_ONLY,
        self::RECURRENCE_WEEKLY,
        self::RECURRENCE_MONTHLY,
        self::RECURRENCE_SEMIANNUAL,
        self::RECURRENCE_YEARLY,
    ];

    const STATUS_ALL = 'todas';
    const STATUS_ONBOARDING = 'onboarding';
    const STATUS_DESABLED = 'desativada';
    const STATUS_ACTIVE = 'ativa';
    const STATUS_FROZEN = 'congelada';

    const STATUSES = [
        self::STATUS_ALL,
        self::STATUS_ONBOARDING,
        self::STATUS_DESABLED,
        self::STATUS_ACTIVE,
        self::STATUS_FROZEN,
    ];

    const COMPANY_STATUS_ONBOARDING = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    const COMPANY_STATUS_DISABLE = [71];
    const COMPANY_STATUS_ACTIVE = [70, 80, 99, 100];
    const COMPANY_STATUS_FROZEN = [81];

    protected $fillable = [
        'description',
        'goal',
        'deadline',
        'tax_regime',
        'recurrence',
        'observation',
        'status',
    ];

    protected $with = [
        'wallters',
    ];

    public function wallters()
    {
        return $this->belongsToMany(Carteira::class, 'activity_schedule_wallets', 'activity_schedules_id', 'carteira_id');
    }

    public function executableCheck()
    {
        if (empty($this->last_execution)) {
            return true;
        }

        switch ($this->recurrence) {
            case self::RECURRENCE_ONLY:
                return $this->activitiesOnly();

            case self::RECURRENCE_WEEKLY:
                return $this->activitiesWeekly();

            case self::RECURRENCE_MONTHLY:
                return $this->activitiesMonthly();

            case self::RECURRENCE_SEMIANNUAL:
                return $this->activitiesSemiannual();

            case self::RECURRENCE_YEARLY:
                return $this->activitiesYearly();
        }

        return false;
    }

    public function activitiesOnly()
    {
        return empty($this->last_execution);
    }

    public function activitiesWeekly()
    {
        if (Carbon::now()->diff($this->last_execution)->days < 7) {
            return false;
        }

        return true;
    }

    public function activitiesMonthly()
    {
        if (Carbon::now()->diff($this->last_execution)->m <= 0) {
            return false;
        }

        return true;
    }

    public function activitiesSemiannual()
    {
        if (Carbon::now()->diff($this->last_execution)->m < 6) {
            return false;
        }

        return true;
    }

    public function activitiesYearly()
    {
        if (Carbon::now()->diff($this->last_execution)->y <= 0) {
            return false;
        }

        return true;
    }

    public function execute()
    {
        $this->getCompanies()->each(function ($company) {
            $newGoal = new Carbon($this->goal);
            $newDeadline = new Carbon($this->deadline);

            if (!empty($this->last_execution)) {
                $today = Carbon::now();

                switch ($this->recurrence) {
                    case self::RECURRENCE_YEARLY:
                        $diffGoal = $today->diffInYears($newGoal);
                        $newGoal = $newGoal->addYear($diffGoal);

                        $diffDeadline = $today->diffInYears($newDeadline);
                        $newDeadline = $newDeadline->addYear($diffDeadline);
                        break;

                    case self::RECURRENCE_SEMIANNUAL:
                        $diffGoal = $today->diffInMonths($newGoal) / 6;
                        $newGoal = $newGoal->addYear($diffGoal);

                        $diffDeadline = $today->diffInMonths($newDeadline) / 6;
                        $newDeadline = $newDeadline->addYear($diffDeadline);
                        break;

                    case self::RECURRENCE_MONTHLY:
                        $diffGoal = $today->diffInMonths($newGoal);
                        $newGoal = $newGoal->addMonth($diffGoal);

                        $diffDeadline = $today->diffInMonths($newDeadline);
                        $newDeadline = $newDeadline->addMonth($diffDeadline);
                        break;

                    case self::RECURRENCE_WEEKLY:
                        $diffGoal = $today->diffInWeeks($newGoal);
                        $newGoal = $newGoal->addYear($diffGoal);

                        $diffDeadline = $today->diffInWeeks($newDeadline) / 6;
                        $newDeadline = $newDeadline->addYear($diffDeadline);
                        break;
                }
            }

            $activity = new Activity();
            $activity->empresa_id = $company->id;
            $activity->description = $this->description;
            $activity->goal = $newGoal->toDateString();
            $activity->deadline = $newDeadline->toDateString();
            $activity->tax_regime = $this->tax_regime;
            $activity->observation = $this->observation;
            $activity->activity_schedule_id = $this->id;

            $activity->save();
        });

        $this->last_execution = Carbon::now()->toDateString();
        $this->save();
    }

    public function getCompanies()
    {
        $wallterIds = $this->wallters()->select('carteira_id')->get();

        if ($wallterIds->count() > 0) {
            $waltersCompanies = CarteiraEmpresa::query()
                ->select('empresa_id')
                ->whereIn('carteira_id', $wallterIds)
                ->get();
        } else {
            $waltersCompanies = CarteiraEmpresa::query()->select('empresa_id')->get();
        }

        $statusFilter = [];
        switch ($this->status) {
            case self::STATUS_ALL:
                $statusFilter = array_merge(
                    self::COMPANY_STATUS_ONBOARDING,
                    self::COMPANY_STATUS_DISABLE,
                    self::COMPANY_STATUS_ACTIVE,
                    self::COMPANY_STATUS_FROZEN
                );
                break;

            case self::STATUS_ONBOARDING:
                $statusFilter = self::COMPANY_STATUS_ONBOARDING;
                break;

            case self::STATUS_DESABLED:
                $statusFilter = self::COMPANY_STATUS_DISABLE;
                break;

            case self::STATUS_ACTIVE:
                $statusFilter = self::COMPANY_STATUS_ACTIVE;
                break;

            case self::STATUS_FROZEN:
                $statusFilter = self::COMPANY_STATUS_FROZEN;
                break;
        }

        if ($this->tax_regime === self::REGIME_ALL) {
            $companies = Empresa::query()
                ->whereIn('id', $waltersCompanies)
                ->whereIn('status_id', $statusFilter)
                ->get();
        } else {
            $companies = Empresa::query()
                ->whereIn('id', $waltersCompanies)
                ->where('regime_tributario',$this->tax_regime)
                ->whereIn('status_id', $statusFilter)
                ->get();
        }

        return $companies;
    }
}
