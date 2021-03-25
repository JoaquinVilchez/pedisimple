<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Rinvex\Subscriptions\Traits\HasSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasSubscriptions;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForWhatsApp()
    {
        // return '+549'.$this->restaurant->notification_characteristic.$this->restaurant->notification_number;
        // // return '+549'.$this->restaurant->getNotificationNumber();
        return '+549' . $this->characteristic . $this->phone;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhone()
    {
        return $this->characteristic . $this->phone;
    }

    public function checkSubscriptionStatus()
    {
        if ($this->subscription($this->restaurant->id)->onTrial()) {
            return 'trial';
        } else {
            if ($this->subscription($this->restaurant->id)->active()) {
                return 'active';
            } elseif ($this->subscription($this->restaurant->id)->canceled()) {
                return 'canceled';
            } elseif ($this->subscription($this->restaurant->id)->ended()) {
                return 'ended';
            }
        }
    }

    public function checkUnpaidSubscriptions()
    {
        $limit_grace_days_plan = app('rinvex.subscriptions.plan')->find(env('BASIC_PLAN_ID'))->grace_period;

        if ($this->hasGraceDays() > 0 && $this->hasGraceDays() <= $limit_grace_days_plan) {
            return 1;
        } elseif ($this->hasGraceDays() > $limit_grace_days_plan && $this->hasGraceDays() <= ($limit_grace_days_plan * 2)) {
            return 2;
        }
    }

    public function getRemainingFreeDays()
    {
        $trial_ends_at = app('rinvex.subscriptions.plan_subscription')->where('subscriber_id', $this->id)->first()->trial_ends_at;

        return $trial_ends_at->floatDiffInDays();
    }

    public function getRemainingSubscriptionDays()
    {
        $subscription_ends_at = app('rinvex.subscriptions.plan_subscription')->where('subscriber_id', $this->id)->first()->ends_at;
        return $subscription_ends_at->diffInDays(Carbon::today());
    }

    public function subscriptionStartsAt()
    {
        return Carbon::parse(app('rinvex.subscriptions.plan_subscription')->where('subscriber_id', $this->id)->first()->starts_at)->format('d/m/Y');
    }

    public function subscriptionEndsAt()
    {
        return Carbon::parse(app('rinvex.subscriptions.plan_subscription')->where('subscriber_id', $this->id)->first()->ends_at)->format('d/m/Y');
    }

    public function hasGraceDays()
    {
        if ($this->checkSubscriptionStatus() == 'ended') {
            $subscription_ends_at = app('rinvex.subscriptions.plan_subscription')->where('subscriber_id', $this->id)->first()->ends_at;
            $difference = $subscription_ends_at->diffInDays(Carbon::today());
            $limit_grace_days_plan = app('rinvex.subscriptions.plan')->find(env('BASIC_PLAN_ID'))->grace_period;

            return $subscription_ends_at->diffInDays(Carbon::today());
        }
    }

    public function subscriptionIsActive()
    {
        $status = $this->checkSubscriptionStatus();
        if ($status == 'ended' && ($this->hasGraceDays() > 0 && $this->hasGraceDays() <= 30)) {
            $status = 'active';
        }
        return $status;
    }

    public function freeSubscription()
    {
        // app('rinvex.subscriptions.plan_subscription')
    }
}
