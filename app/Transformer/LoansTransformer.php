<?php


namespace App\Transformer;

use League\Fractal\TransformerAbstract;

class LoansTransformer extends TransformerAbstract
{
    public function transform($loans)
    {
        return $loans;
    }
}
