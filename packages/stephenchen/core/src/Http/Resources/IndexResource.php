<?php

namespace Stephenchen\Core\Http\Resources;

final class IndexResource
{
    public function to(array $data, string $total)
    {
        return [
            'lists' => $data,
            'total' => $total,
        ];
    }
}
