<?php

namespace App\Traits;

use App\Account;
use App\AccountsGroup;
use App\Customer;
use App\Order;
use App\Asset;
use App\Production;
use Illuminate\Database\QueryException;

trait TraitModel
{
    public function get_last_code($type)
    {
        if ($type == "asset") {
            $account = Asset::orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('INV', 8);
            }
        }

        if ($type == "sale_retur") {
            $account = Order::where('type', 'sale_retur')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('SRT', 8);
            }
        }
        
        if ($type == "topup") {
            $account = Order::where('type', 'topup')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('TOP', 8);
            }
        }

        if ($type == "transfer") {
            $account = Order::where('type', 'transfer')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('TRF', 8);
            }
        }

        if ($type == "order") {
            $account = Order::where('type', 'sale')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('ORD', 8);
            }
        }

        if ($type == "order-agent") {
            $account = Order::where('type', 'agent_sale')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('OAG', 8);
            }
        }

        if ($type == "member") {
            $account = Customer::where('type', 'member')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('MBR', 8);
            }
        }

        if ($type == "agent") {
            $account = Customer::where('type', 'agent')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('AGN', 8);
            }
        }

        if ($type == "withdraw") {
            $account = Order::where('type', 'withdraw')
                ->orderBy('id', 'desc')
                ->first();
            if ($account && (strlen($account->code) == 8)) {
                $code = $account->code;
            } else {
                $code = acc_codedef_generate('WDW', 8);
            }
        }

        return $code;
    }

    public function acc_get_last_code($accounts_group_id)
    {
        $account = Account::where('accounts_group_id', $accounts_group_id)
            ->orderBy('code', 'desc')
            ->first();
        if ($account) {
            $code = $account->code;
        } else {
            $accounts_group = AccountsGroup::select('code')->where('id', $accounts_group_id)->first();
            $accounts_group_code = $accounts_group->code;
            $code = acc_codedef_generate($accounts_group_code, 5);
        }

        return $code;
    }

    public function mbr_get_last_code()
    {
        $account = Customer::where('type', 'member')
            ->orderBy('id', 'desc')
            ->first();
        if ($account && (strlen($account->code) == 8)) {
            $code = $account->code;
        } else {
            $code = acc_codedef_generate('MBR', 8);
        }

        return $code;
    }

    public function cst_get_last_code()
    {
        $account = Customer::where('type', '!=', 'member')
            ->orderBy('id', 'desc')
            ->first();
        if ($account && (strlen($account->code) == 8)) {
            $code = $account->code;
        } else {
            $code = acc_codedef_generate('CST', 8);
        }

        return $code;
    }

    public function prd_get_last_code()
    {
        $account = Production::where('type', 'production')
            ->orderBy('id', 'desc')
            ->first();
        if ($account && (strlen($account->code) == 8)) {
            $code = $account->code;
        } else {
            $code = acc_codedef_generate('PRD', 8);
        }

        return $code;
    }

    public function ord_get_last_code()
    {
        $account = Production::where('type', 'sale')
            ->orderBy('id', 'desc')
            ->first();
        if ($account && (strlen($account->code) == 8)) {
            $code = $account->code;
        } else {
            $code = acc_codedef_generate('ORD', 8);
        }

        return $code;
    }

    public function oag_get_last_code()
    {
        $account = Production::where('type', 'agent_sale')
            ->orderBy('id', 'desc')
            ->first();
        if ($account && (strlen($account->code) == 8)) {
            $code = $account->code;
        } else {
            $code = acc_codedef_generate('OAG', 8);
        }

        return $code;
    }

    public function top_get_last_code()
    {
        $account = Production::where('type', 'topup')
            ->orderBy('id', 'desc')
            ->first();
        if ($account && (strlen($account->code) == 8)) {
            $code = $account->code;
        } else {
            $code = acc_codedef_generate('TOP', 8);
        }

        return $code;
    }

    public function get_ref_exc($id, $ref_arr, $lev_max, $id_exc)
    {
        $customer = Customer::find($id);
        $ref_id = $customer->ref_id;
        if ($ref_id > 0 && $lev_max <= 9) {
            $referal = Customer::find($ref_id);
            $ref_status = $referal->status;
            if(($ref_id != $id_exc) && ($ref_status=='active')){
            array_push($ref_arr, $ref_id);
            }
            $lev_max++;
            return $this->get_ref_exc($ref_id, $ref_arr, $lev_max, $id_exc);
        } else {
            return $ref_arr;
        }
    }

    public function get_ref($id, $ref_arr, $lev_max)
    {
        $customer = Customer::find($id);
        $ref_id = $customer->ref_id;
        if ($ref_id > 0 && $lev_max <= 9) {
            $referal = Customer::find($ref_id);
            $ref_status = $referal->status;
            if($ref_status=='active'){
            array_push($ref_arr, $ref_id);
            }
            $lev_max++;
            return $this->get_ref($ref_id, $ref_arr, $lev_max);
        } else {
            return $ref_arr;
        }
    }
}
