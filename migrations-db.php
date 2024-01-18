<?php

use App\DB\DBConnectionFactory;

return DBConnectionFactory::getInstance()->getConnection();
