<?php

namespace App;

use App\Mail\CancelledSubscription;
use App\Mail\InactiveSubscription;
use App\Mail\NewSubscription;
use App\Mail\RenewSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\OpeningHours\OpeningHours;
use Illuminate\Support\Facades\Mail;
use App\Mail\UpdateStatusMail;

class restaurant extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function restaurantCategories()
    {
        return $this->belongsToMany(RestaurantCategory::class, 'relation_restaurant_category', 'restaurant_id', 'category_restaurant_id');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function availableProducts()
    {
        return Product::where('restaurant_id', $this->id)->where('state', 'available')->where('temporary', false)->get();
    }

    public function shippingMethod()
    {
        switch ($this->shipping_method) {
            case 'pickup':
                return 'Retiro en local';
                break;
            case 'delivery':
                return 'Delivery';
                break;
            case 'delivery-pickup':
                return 'Retiro y Delivery';
                break;
        }
    }

    public function stateStyle()
    {
        switch ($this->state) {
            case 'cancelled':
                return 'badge badge-danger';
                break;
            case 'active':
                return 'badge badge-success';
                break;
            case 'pending':
                return 'badge badge-warning';
                break;
        }
    }

    public function translateState()
    {
        switch ($this->state) {
            case 'pending':
                return 'Pendiente';
                break;
            case 'active':
                return 'Activo';
                break;
            case 'cancelled':
                return 'Cancelado';
                break;
        }
    }

    public function getPhone()
    {
        if ($this->second_characteristic == null && $this->second_phone == null) {
            return $this->characteristic . '-' . $this->phone;
        } else {
            return $this->characteristic . '-' . $this->phone . ' | ' . $this->second_characteristic . '-' . $this->second_phone;
        }
    }

    function getSchedule()
    {
        $days = OpeningDateTime::where('restaurant_id', $this->id)->get()->toArray();
        if (count($days) > 0) {
            $schedule = array(0, 1, 2, 3, 4, 5, 6);
            foreach ($days as $day) {
                $replace_day = (array($day['weekday'] => $day));
                $schedule = array_replace_recursive($schedule, $replace_day);
            }
        } elseif ($days == null) {
            $schedule = null;
        }

        return $schedule;
    }

    public function newOrders()
    {
        $newOrders = Order::where('restaurant_id', $this->id)->where('state', 'pending')->get();

        return count($newOrders);
    }

    public function acceptedOrders()
    {
        $acceptedOrders = Order::where('restaurant_id', $this->id)->where('state', 'accepted')->get();

        return count($acceptedOrders);
    }

    public function closedOrders()
    {
        $closedOrders = Order::where('restaurant_id', $this->id)->where('state', 'closed')->get();

        return count($closedOrders);
    }

    public function getNotificationNumber()
    {
        return $this->notification_characteristic . $this->notification_number;
    }

    public function showCoverPage()
    {
        $restaurantCategories = [];
        foreach ($this->restaurantCategories as $category) {
            array_push($restaurantCategories, $category->id);
        }

        $restaurantCategoriesQuantity = count($restaurantCategories);

        $availablesCoverPages = [];

        for ($i = 0; $i < $restaurantCategoriesQuantity; $i++) {
            if (Storage::exists('public/coverpages/' . $restaurantCategories[$i] . '_1.png')) {
                array_push($availablesCoverPages, $restaurantCategories[$i]);
            }
        }

        $availablesCoverPagesQuantity = count($availablesCoverPages);

        if ($availablesCoverPagesQuantity <= 0) {
            return asset('storage/coverpages/generalwood.jpg');
        } else {
            $categoryID = rand(0, $availablesCoverPagesQuantity - 1);

            $randomNumber = rand(1, 5);

            while (Storage::exists('public/coverpages/' . $availablesCoverPages[$categoryID] . '_' . $randomNumber . '.png') == false) {
                $randomNumber = rand(1, 5);
            }

            return asset('storage/coverpages/' . $availablesCoverPages[$categoryID] . '_' . $randomNumber . '.png');
        }

        // return array($restaurantCategoriesQuantity,$availablesCoverPagesQuantity);

    }

    public function getOpeningHoursData()
    {

        $days = $this->getSchedule();

        $monday = [];
        if (isset($days[0]['state']) && $days[0]['state'] == 'open') {
            $first_turn = substr($days[0]['start_hour_1'], 0, -3) . '-' . substr($days[0]['end_hour_1'], 0, -3);
            if ($first_turn != null && $first_turn != '-') {
                array_push($monday, $first_turn);
            }
            $second_turn = substr($days[0]['start_hour_2'], 0, -3) . '-' . substr($days[0]['end_hour_2'], 0, -3);
            if ($second_turn != null && $second_turn != '-') {
                array_push($monday, $second_turn);
            }
        }

        $tuesday = [];
        if (isset($days[1]['state']) && $days[1]['state'] == 'open') {
            $first_turn = substr($days[1]['start_hour_1'], 0, -3) . '-' . substr($days[1]['end_hour_1'], 0, -3);
            if ($first_turn != null && $first_turn != '-') {
                array_push($tuesday, $first_turn);
            }
            $second_turn = substr($days[1]['start_hour_2'], 0, -3) . '-' . substr($days[1]['end_hour_2'], 0, -3);
            if ($second_turn != null && $second_turn != '-') {
                array_push($tuesday, $second_turn);
            }
        }

        $wednesday = [];
        if (isset($days[2]['state']) && $days[2]['state'] == 'open') {
            $first_turn = substr($days[2]['start_hour_1'], 0, -3) . '-' . substr($days[2]['end_hour_1'], 0, -3);
            if ($first_turn != null && $first_turn != '-') {
                array_push($wednesday, $first_turn);
            }
            $second_turn = substr($days[2]['start_hour_2'], 0, -3) . '-' . substr($days[2]['end_hour_2'], 0, -3);
            if ($second_turn != null && $second_turn != '-') {
                array_push($wednesday, $second_turn);
            }
        }

        $thursday = [];
        if (isset($days[3]['state']) && $days[3]['state'] == 'open') {
            $first_turn = substr($days[3]['start_hour_1'], 0, -3) . '-' . substr($days[3]['end_hour_1'], 0, -3);
            if ($first_turn != null && $first_turn != '-') {
                array_push($thursday, $first_turn);
            }
            $second_turn = substr($days[3]['start_hour_2'], 0, -3) . '-' . substr($days[3]['end_hour_2'], 0, -3);
            if ($second_turn != null && $second_turn != '-') {
                array_push($thursday, $second_turn);
            }
        }

        $friday = [];
        if (isset($days[4]['state']) && $days[4]['state'] == 'open') {
            $first_turn = substr($days[4]['start_hour_1'], 0, -3) . '-' . substr($days[4]['end_hour_1'], 0, -3);
            if ($first_turn != null && $first_turn != '-') {
                array_push($friday, $first_turn);
            }
            $second_turn = substr($days[4]['start_hour_2'], 0, -3) . '-' . substr($days[4]['end_hour_2'], 0, -3);
            if ($second_turn != null && $second_turn != '-') {
                array_push($friday, $second_turn);
            }
        }

        $saturday = [];
        if (isset($days[5]['state']) && $days[5]['state'] == 'open') {
            $first_turn = substr($days[5]['start_hour_1'], 0, -3) . '-' . substr($days[5]['end_hour_1'], 0, -3);
            if ($first_turn != null && $first_turn != '-') {
                array_push($saturday, $first_turn);
            }
            $second_turn = substr($days[5]['start_hour_2'], 0, -3) . '-' . substr($days[5]['end_hour_2'], 0, -3);
            if ($second_turn != null && $second_turn != '-') {
                array_push($saturday, $second_turn);
            }
        }

        $sunday = [];
        if (isset($days[6]['state']) && $days[6]['state'] == 'open') {
            $first_turn = substr($days[6]['start_hour_1'], 0, -3) . '-' . substr($days[6]['end_hour_1'], 0, -3);
            if ($first_turn != null && $first_turn != '-') {
                array_push($sunday, $first_turn);
            }
            $second_turn = substr($days[6]['start_hour_2'], 0, -3) . '-' . substr($days[6]['end_hour_2'], 0, -3);
            if ($second_turn != null && $second_turn != '-') {
                array_push($sunday, $second_turn);
            }
        }

        $openingHours = OpeningHours::create([
            'overflow' => true,
            'monday'     => $monday,
            'tuesday'    => $tuesday,
            'wednesday'  => $wednesday,
            'thursday'   => $thursday,
            'friday'     => $friday,
            'saturday'   => $saturday,
            'sunday'     => $sunday,
        ]);

        return $openingHours;
    }

    public function updateStatus($status, $plan_id = null)
    {
        $user = User::find($this->user->id);

        $transaction = DB::transaction(function () use ($status, $user, $plan_id) {
            try {

                $data = [
                    'first_name' => $user->first_name,
                    'restaurant' => $user->restaurant->name
                ];

                if ($status == 'active') {

                    if ($this->getSchedule() == null) {
                        DB::rollback();
                        return false;
                    } else {
                        if ($user->subscription(strval($this->id)) != null) {
                            $this->update(['state' => $status]);
                            $user->subscription(strval($this->id))->renew();
                            Mail::to($user->email)->send(new RenewSubscription($data));
                        } else {
                            $this->update(['state' => $status]);
                            $plan = app('rinvex.subscriptions.plan')->find($plan_id);
                            $user->newSubscription(strval($this->id), $plan);
                            Mail::to($user->email)->send(new NewSubscription($data));
                        }

                        $this->update(['state' => $status]);

                        // $data = [
                        //     'name' => $this->name,
                        //     'slug' => $this->slug,
                        //     'user_name' => $this->user->first_name,
                        // ];

                        // if ($status == 'active') {
                        //     Mail::to($this->user->email)->send(new UpdateStatusMail($data));
                        // }

                        DB::commit();
                        return true;
                    }
                } elseif ($status == 'pending') {
                    $this->update(['state' => $status]);
                    $user->subscription(strval($this->id))->ended();
                    Mail::to($user->email)->send(new InactiveSubscription($data));
                    DB::commit();
                    return true;
                } elseif ($status == 'cancelled') {
                    $this->update(['state' => $status]);
                    $user->subscription(strval($this->id))->cancel();
                    Mail::to($user->email)->send(new CancelledSubscription($data));
                    DB::commit();
                    return true;
                }
            } catch (\Throwable $th) {
                DB::rollback();
                dd($th);
                return false;
            }
        });

        return $transaction;

        // if ($transaction) {
        //     return redirect()->back()->with('success_message', 'Estado actualizado con éxito');
        // } else {
        //     return redirect()->back()->with('error_message', 'Hubo un error y no se pudo actualizar el estado');
        // }
    }
}
