<?php

namespace App\Helpers\General;

use App\Models\Auth\User;
use App\Models\Earning;
use App\Models\Withdraw;
use Auth;

/**
 * Class HtmlHelper.
 */
class EarningHelper
{

    /**
     *  Earning for teacher
     * @param App\Models\Order $order
     * @return null
     **/
    public function insert($order)
    {
        $orderItems = $order->items;
        foreach ($orderItems as $items) {
            if ($items->item_type == 'App\Models\Bundle') {
                $formationsPrice = $items->item->formations->sum('price');
                foreach ($items->item->formations as $formations) {
                    $teacherId = implode('', $formations->teachers->pluck('id')->toArray());
                    $commissionForTeacher = (($items->item->price / $formationsPrice) * config('commission_rate') * $formations->price) / 100;
                    $data = [
                        'user_id' => $teacherId,
                        'order_id' => $order->id,
                        'formation_id' => $formations->id,
                        'formation_price' => $formations->price,
                        'amount' => $commissionForTeacher,
                        'rate' => config('commission_rate'),
                    ];
                    Earning::create($data);
                }
            }
            if ($items->item_type == 'App\Models\Formation') {
                $teacherId = implode('', $items->item->teachers->pluck('id')->toArray());
                $commissionForTeacher = (config('commission_rate') * $items->item->price) / 100;
                $data = [
                    'user_id' => $teacherId,
                    'order_id' => $order->id,
                    'formation_id' => $items->item->id,
                    'formation_price' => $items->item->price,
                    'amount' => $commissionForTeacher,
                    'rate' => config('commission_rate'),
                ];
                Earning::create($data);
            }
        }
    }

    /**
     * Remove earning for teacher
     * @param App\Models\Order $order
     * @return null
     **/

    public function remove($order)
    {
        if ($order->status == 1) {
            $earnings = Earning::where('order_id', $order->id)->get();
            if ($earnings->count() > 0) {
                foreach ($earnings as $withdraw) {
                    $data = [
                        'user_id' => $withdraw->teacher_id,
                        'amount' => $withdraw->amount,
                        'status' => 3,
                        'remarks' => 'Admin order removed',
                    ];
                    Withdraw::create($data);
                }
            }
        }
    }

    /**
     * Total earning for teacher
     * @return number
     **/

    public function totalEarning($id = null)
    {
        if ($id) {
            $user = User::find($id);
            return $user->earnings->sum('amount');
        }
        return Auth::user()->earnings->sum('amount');
    }

    /**
     * Total earning for teacher
     * @return number
     **/

    public function totalWithdrawal($id = null)
    {
        if ($id) {
            $user = User::find($id);
            return $user->withdraws->where('status', '=', 1)->sum('amount');
        }
        return Auth::user()->withdraws->where('status', '=', 1)->sum('amount');
    }

    /**
     * Total withdrawal pending for teacher
     * @return number
     **/

    public function totalWithdrawalPending($id = null)
    {
        if ($id) {
            $user = User::find($id);
            return $user->withdraws->where('status', '=', 0)->sum('amount');
        }
        return Auth::user()->withdraws->where('status', '=', 0)->sum('amount');
    }

    /**
     * Total balance teacher
     * @return number
     **/

    public function totalBalance($id = null)
    {
        return $this->totalEarning($id) - ($this->totalWithdrawal($id) + $this->totalWithdrawalPending($id));
    }
}
