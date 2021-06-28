<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Loans;
use App\Models\LoansPackage;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RepaymentController extends ApiController
{
    public function doRepayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'integer',
            'payment' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->apiErrorWithCode($validator->errors(), 404);
        }

        $data = $validator->validated();

        $user = auth()->user();

        $loan = Loans::where('id', $data['loan_id'])->first();
        if (empty($loan) || !isset($loan)) {
            return $this->apiErrorWithCode("Loans does not exist", 400);
        }

        if ($loan->duration < now()) {
            return $this->apiSuccess("Loans is over duration", 200);
        }

        if ($loan->status === 3) {
            return $this->apiSuccess("Loans is already payment", 200);
        }

        if ($loan->remain - $data['payment'] < 0) {
            return $this->apiErrorWithCode("Payment is over loans, please input right loans", 200);
        }

        $paymentHistory = Repayment::where('user_id', $user->id)
            ->where('loan_id', $data['loan_id'])
            ->orderBy('id', 'DESC')
            ->first();

        if (empty($paymentHistory) || !isset($paymentHistory)) {
            $count = 0;
        } else {
            $count = $paymentHistory->payment_period + 1;
        }
        try {
            DB::beginTransaction();
            $payment = [
                'user_id' => $user->id,
                'loan_id' => $data['loan_id'],
                'payment' => $data['payment'],
                'payment_period' => $count,
                'updated_at' => now(),
                'created_at' => now(),
            ];

            $result = Repayment::insert($payment);

            if (!$result) {
                return $this->apiErrorWithCode("Payment fails!", 400);
            }

            $loan->remain = $loan->remain - $data['payment'];
            $loan->payment_period = $count;
            if ($loan->remain > 0 && $loan->remain < $loan->total) {
                $loan->status = 2;
            }
            if ($loan->remain <= 0) {
                $loan->status = 3;
            }
            $loan->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }

        return $this->apiSuccess("Loans is payment success", 200);

    }
}
