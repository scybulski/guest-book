<?php

namespace App\Http\Requests;

use App\Values\PaginationValue;
use App\Helpers\NumbersHelper;

class PaginatedIndexRequest implements Request
{
    public function getData(): array
    {
        return [
            'page' => $this->getPageValue(),
            'pageSize' => $this->getPageSizeValue(),
        ];
    }

    public function getPaginationValue(): PaginationValue
    {
        return new PaginationValue(
            ...$this->getData(),
        );
    }

    protected function getPageValue(): ?int
    {
        $page = $_GET['page'] ?? null;

        if ($page !== null) {
            $page = intval($page);

            $page = max($page, 0);
        }

        return $page;
    }

    protected function getPageSizeValue(): ?int
    {
        $pageSize = $_GET['pageSize'] ?? null;

        if ($pageSize !== null) {
            $pageSize = intval($pageSize);

            $pageSize = NumbersHelper::clamp($pageSize, 1, 500);
        }

        return $pageSize;
    }
}
