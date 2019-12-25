<?php

namespace Receipt\Repositories;

use App\Repository;
use Receipt\Entities\Transaction;

class TransactionRepository extends Repository
{
    public function model()
    {
        return Transaction::class;
    }
}
