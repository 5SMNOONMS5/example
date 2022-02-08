<?php

namespace Stephenchen\Core\Utilities;

final class DirectoryToTree
{
    /**
     * @param $directory
     * @param $allows
     *
     * @return array
     */
    public static function directoryToArray($directory, $allows)
    {
        // cf. https://stackoverflow.com/questions/7121479/listing-all-the-folders-subfolders-and-files-in-a-directory-using-php

        $results = [];
        $files   = scandir($directory);
        foreach ($files as $key => $value) {
            if (!in_array($value, $allows)) {
                $separator = DIRECTORY_SEPARATOR;
                $path      = "$directory$separator$value";
                if (is_dir($path)) {
                    $results[ $value ] = self::directoryToArray($path, $allows);
                } else {
                    $results[] = $value;
                }
            }
        }

        return $results;
    }
}
