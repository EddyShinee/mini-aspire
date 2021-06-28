<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Loans;
use App\Models\LoansPackage;
use App\Transformer\LoansTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\XmlConfiguration\Constant;
use Tymon\JWTAuth\JWTAuth;

class LoansController extends ApiController
{
    protected $loansTransformer;

    public function __construct(LoansTransformer $loansTransformer)
    {
        $this->loansTransformer = $loansTransformer;
    }

    public function getLoans(Request $request)
    {
        $user = auth()->user();

        $listLoans = Loans::where('user_id', $user->id)->get();

        if (empty($listLoans) || !isset($listLoans) || count($listLoans) == 0) {
            return $this->apiSuccess("User does not have loans");
        }

        return $this->apiSuccess($this->loansTransformer->transform($listLoans));

    }

    public function doLoans(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loans_package_id' => 'required',
            'loan' => 'required',
            'duration' => 'required',
            'fee' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiErrorWithCode($validator->errors(), 404);
        }

        $data = $validator->validated();
        $loansPackage = LoansPackage::where('id', $data['loans_package_id'])
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->first();


        if (!isset($loansPackage) || empty($loansPackage)) {
            return $this->apiErrorWithCode("Package does not exist", 404);

        }
        $user = auth()->user();
        $loan = [
            'user_id' => $user->id,
            'loans_package_id' => $data['loans_package_id'],
            'loan' => $data['loan'],
            'duration' => $data['duration'],
            'frequency' => $loansPackage->frequency,
            'interest_rate' => $loansPackage->interest_rate,
            'fee' => $data['fee'],
            'status' => 1,
            'payment_period' => 0,
            'total' => $data['fee'] + $data['loan'] + ($data['loan'] * $loansPackage->interest_rate),
            'remain' => 0,
            'updated_at' => now(),
            'created_at' => now(),
        ];

        $result = Loans::insert($loan);

        if (!$result) {
            return $this->apiErrorWithCode("Create loans fails", 400);
        }

        return $this->apiSuccess($result);
    }

    public function updateLoans(Request $request, $loansId)
    {
        $validator = Validator::make($request->all(), [
            'loans_package_id' => 'integer',
            'loan' => 'integer',
            'duration' => 'date',
            'fee' => 'integer',
        ]);

        if ($validator->fails()) {
            return $this->apiErrorWithCode($validator->errors(), 404);
        }

        $data = $validator->validated();
        $loansPackage = LoansPackage::where('id', $data['loans_package_id'])
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->first();


        if (!isset($loansPackage) || empty($loansPackage)) {
            return $this->apiErrorWithCode("Package does not exist", 400);

        }

        $user = auth()->user();
        $loan = Loans::where('id', $loansId)->first();
        if (empty($loan) || !isset($loan)) {
            return $this->apiErrorWithCode("Loans does not exist", 400);
        }

        $fee = isset($data['fee']) ? $data['fee'] : $loan->fee;
        $loan = isset($data['loan']) ? $data['loan'] : $loan->loan;
        $duration = isset($data['duration']) ? $data['duration'] : $loan->duration;
        $loan = [
            'user_id' => $user->id,
            'loans_package_id' => $data['loans_package_id'],
            'loan' => $loan,
            'duration' => $duration,
            'frequency' => $loansPackage->frequency,
            'interest_rate' => $loansPackage->interest_rate,
            'fee' => $fee,
            'status' => 1,
            'payment_period' => 0,
            'total' => $fee + $loan + ($loan * $loansPackage->interest_rate),
            'remain' => 0,
            'updated_at' => now(),
            'created_at' => now(),
        ];

        $result = Loans::where('id', $loansId)
            ->update($loan);

        if (!$result) {
            return $this->apiErrorWithCode("Update loans fails", 400);
        }

        return $this->apiSuccess($result);
    }
}
