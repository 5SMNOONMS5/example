<?php

namespace Stephenchen\Core\Utilities;

final class ToTree
{
    /**
     * @var string
     */
    private string $parentIDName;

    /**
     * ToTree constructor.
     *
     * @param string $parentIdName
     */
    public function __construct(string $parentIdName)
    {
        $this->parentIDName = $parentIdName;
    }

    /**
     * 把 flatten array 轉成 tree
     *
     * @param array $flattenArray
     * @param int $root
     * @return array
     */
    public function get(array $flattenArray, $root = 0)
    {
        $parents = [];
        foreach ($flattenArray as $flat) {
            $parents[ $flat[ $this->parentIDName ] ][] = $flat;
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
