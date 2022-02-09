<?php

namespace Stephenchen\Core\Utilities;

final class ToTree
{
    /**
     * ToTree constructor.
     */
    public function __construct()
    {

    }

    /**
     * 把 flatten array 轉成 tree
     *
     * @param array $flattenArray
     * @param string $parentIDName
     * @param int $root
     * @return array
     */
    public function convert(array $flattenArray, string $parentIDName, $root = 0)
    {
        $parents = [];
        foreach ($flattenArray as $flat) {
            $parents[ $flat[ $parentIDName ] ][] = $flat;
        }

        // The root key is not exits
        if (!Helpers::isArrayHasKey($parents, $root)) {
            return [];
        }

        return $this->createBranch($parents, $parents[ $root ]);
    }

    /**
     * Recursive branch extrusion
     *
     * @param $parents
     * @param $children
     * @return array
     */
    private function createBranch(&$parents, $children)
    {
        $tree = [];
        foreach ($children as $child) {
            if (isset($parents[ $child[ 'id' ] ])) {
                $child[ 'children' ] =
                    $this->createBranch($parents, $parents[ $child[ 'id' ] ]);
            }
            $tree[] = $child;
        }
        return $tree;
    }
}
