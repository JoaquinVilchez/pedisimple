<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = app('rinvex.subscriptions.plan')->all();
        return view('admin.subscriptions.plans.list')->with('plans', $plans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscriptions.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'frequency' => 'required',
            'freedays' => 'required|min:1|max:31',
            'gracedays' => 'required|min:1|max:31'
        ]);

        try {
            app('rinvex.subscriptions.plan')->create([
                'name' => $request->name,
                'description' => '',
                'price' => $request->price,
                'signup_fee' => 0,
                'invoice_period' => $request->frequency,
                'invoice_interval' => 'month',
                'trial_period' => $request->freedays,
                'trial_interval' => 'day',
                'grace_period' => $request->gracedays,
                'grace_interval' => 'day',
                'sort_order' => 1,
                'currency' => 'ARS',
            ]);

            return redirect()->route('plan.index')->with('success_message', 'Plan creado con éxito');
        } catch (\Throwable $th) {
            return redirect()->route('plan.index')->with('error_message', 'Hubo un error. No se pudo crear el plan');
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
        $plan = app('rinvex.subscriptions.plan')->find($id);
        return view('admin.subscriptions.plans.edit')->with('plan', $plan);
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
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'frequency' => 'required',
            'freedays' => 'required|min:1|max:31',
            'gracedays' => 'required|min:1|max:31'
        ]);

        try {
            DB::table('plans')->where('id', $id)->update([
                'name' => '{"es": "' . $request->name . '"}',
                'price' => $request->price,
                'trial_period' => $request->freedays,
                'invoice_period' => $request->frequency,
                'grace_period' => $request->gracedays
            ]);

            return redirect()->route('plan.index')->with('success_message', 'Plan editado con éxito');
        } catch (\Throwable $th) {
            return redirect()->route('plan.index')->with('error_message', 'Hubo un error. No se pudo editar el plan');
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
            $subscriptions = DB::table('plan_subscriptions')->where('plan_id', $request->planid)->get();
            if ($subscriptions->count() == 0) {
                DB::table('plans')->where('id', $request->planid)->delete();
                return redirect()->route('plan.index')->with('success_message', 'Plan eliminado con éxito');
            } else {
                return redirect()->route('plan.index')->with('error_message', 'No se puede eliminar porque hay comercios suscritos a este plan.');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plan.index')->with('error_message', 'Hubo un error. No se pudo eliminar el plan');
        }
    }
}
