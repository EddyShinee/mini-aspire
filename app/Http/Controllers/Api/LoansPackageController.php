<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\LoansPackage;
use App\Transformer\LoansPackageTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LoansPackageController extends ApiController
{
    protected $loansPackageTransformer;

    public function __construct(LoansPackageTransformer $loansPackageTransformer)
    {
        $this->loansPackageTransformer = $loansPackageTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listPackage = LoansPackage::where('is_deleted', 0)->get();
        if ($listPackage === null || count($listPackage) === 0) {
            return $this->apiErrorWithCode("Data does not exist", 404);
        }
        return $this->apiSuccess($this->loansPackageTransformer->transform($listPackage));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\LoansPackage $loansPackage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($id === null) {
            return $this->apiErrorWithCode("This package does not exist", 404);
        }
        $package = LoansPackage::where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        if (!isset($package) || empty($package)) {
            return $this->apiErrorWithCode("Package does not exist", 404);

        }
        return $this->apiSuccess($this->loansPackageTransformer->transform($package));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\LoansPackage $loansPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(LoansPackage $loansPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LoansPackage $loansPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == null) {
            return $this->apiErrorWithCode("Wrong ID type or Not input ID", 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'frequency' => 'required|integer',
            'interest_rate' => 'required|numeric',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->apiErrorWithCode($validator->errors(), 404);
        }

        $package = LoansPackage::where('id', $id)
            ->where("is_deleted", 0)
            ->first();

        if (!isset($package) || empty($package)) {
            return $this->apiErrorWithCode("Package does not exist", 404);

        }

        $package = $package->update($validator->validated());

        if (!$package) {
            return $this->apiErrorWithCode("Updated failed!", 404);
        }
        return $this->apiSuccess($this->loansPackageTransformer->transform($package));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\LoansPackage $loansPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($id == null) {
            return $this->apiErrorWithCode("Wrong ID type or Not input ID", 404);
        }


        $validator = Validator::make($request->all(), [
            'is_deleted' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->apiErrorWithCode($validator->errors(), 404);
        }


        $package = LoansPackage::where('id', $id)
            ->where("is_deleted", 0)
            ->first();

        if (!isset($package) || empty($package)) {
            return $this->apiErrorWithCode("Package does not exist", 404);

        }
        $package = $package->update($validator->validated());

        if ($package != 1) {
            return $this->apiErrorWithCode("Updated failed!", 404);
        }
        return $this->apiSuccess($this->loansPackageTransformer->transform($package));
    }
}
