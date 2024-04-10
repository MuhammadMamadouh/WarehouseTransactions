<?php

namespace App\Classes\SalesOrder\BToB;

use App\Classes\WarehouseTransaction;
use App\Interfaces\ICanceable;
use App\Interfaces\IDeliverable;


abstract class BToBSalesOrder extends WarehouseTransaction  implements IDeliverable, ICanceable
{

}
