<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = DB::table('plan_subscriptions')->get('slug');
        $plans = app('rinvex.subscriptions.plan')->all();

        $subscriptions_restaurants = [];
        foreach ($subscriptions as $subscription) {
            array_push($subscriptions_restaurants, $subscription->slug);
        }

        $restaurants = Restaurant::all();

        $subscriptions_restaurants = collect(Restaurant::find($subscriptions_restaurants));

        $available_restaurants = $restaurants->diff($subscriptions_restaurants);

        return view('admin.subscriptions.restaurants.list')->with([
            'subscribed_restaurants' => $subscriptions_restaurants,
            'available_restaurants' => $available_restaurants,
            'plans' => $plans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = Restaurant::find($request->restaurant_id)->user;
            // $plan = app('rinvex.subscriptions.plan')->find($request->plan_id);

            // $user->newSubscription(strval($user->restaurant->id), $plan);
            $restaurant = $user->restaurant;

            $restaurant->updateStatus('active', $request->plan_id);

            return redirect()->route('subscription.index')->with('success_message', 'Suscripción creada con éxito');
        } catch (\Throwable $th) {
            return redirect()->route('subscription.index')->with('error_message', 'Hubo un problema y no pudo realizarse la suscripción');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::find($id);
        $subscription = DB::table('plan_subscriptions')->where('subscriber_id', $restaurant->user->id)->first();
        return view('admin.subscriptions.restaurants.edit')->with([
            'restaurant' => $restaurant,
            'subscription' => $subscription
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $restaurant = Restaurant::find($id);
            $trial_ends_at = Carbon::createFromFormat('d/m/Y', $request->trial_ends_at);
            $subscription_starts_at = Carbon::createFromFormat('d/m/Y', $request->subscription_starts_at);
            $subscription_ends_at = Carbon::createFromFormat('d/m/Y', $request->subscription_ends_at);

            DB::table('plan_subscriptions')->where('subscriber_id', $restaurant->user->id)->update([
                'trial_ends_at' => $trial_ends_at,
                'starts_at' => $subscription_starts_at,
                'ends_at' => $subscription_ends_at
            ]);

            return redirect()->route('subscription.index')->with('success_message', 'Suscripción editada con éxito.');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('subscription.index')->with('error_message', 'Hubo un error y no se pudo editar suscripción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $user = Restaurant::find($request->restaurantid)->user;
            $user->restaurant->updateStatus('cancelled');
            DB::table('plan_subscriptions')->where('subscriber_id', $user->id)->delete();
            return redirect()->route('subscription.index')->with('success_message', 'Suscripción eliminada con éxito');
        } catch (\Throwable $th) {
            return redirect()->route('subscription.index')->with('error_message', 'Hubo un problema y no pudo eliminarse la suscripción');
        }
    }

    public function renew(Request $request)
    {
        try {
            $user = Restaurant::find($request->restaurantid)->user;
            $user->restaurant->updateStatus('active');
            return redirect()->route('subscription.index')->with('success_message', 'Suscripción renovada con éxito');
        } catch (\Throwable $th) {
            return redirect()->route('subscription.index')->with('error_message', 'Hubo un problema y no pudo renovarse la suscripción');
        }
    }
}
