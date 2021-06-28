<?php


namespace App\Transformer;

use App\Models\LoansPackage;
use League\Fractal\TransformerAbstract;

class LoansPackageTransformer extends TransformerAbstract
{
    public function transform($loansPackage)
    {
        return $loansPackage;
    }
}
