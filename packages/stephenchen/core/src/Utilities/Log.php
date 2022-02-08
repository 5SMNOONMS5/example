<?php

namespace Stephenchen\Core\Utilities;

use Illuminate\Support\Facades\Log as LaravelLog;

final class Log
{
    /**
     * Beautify the log output with `emergency` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function emergency(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        // @TODO: Line notify or something else

        LaravelLog::emergency("========= $title  ========= \n");
        LaravelLog::emergency("$messages \n");
    }

    /**
     * Beautify the log output with `alert` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function alert(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        // @TODO: Line notify or something else

        LaravelLog::alert("========= $title  ========= \n");
        LaravelLog::alert("$messages \n");
    }

    /**
     * Beautify the log output with `critical` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function critical(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        // @TODO: Line notify or something else

        LaravelLog::critical("========= $title  ========= \n");
        LaravelLog::critical("$messages \n");
    }

    /**
     * Beautify the log output with `error` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function error(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        LaravelLog::error("========= $title  ========= \n");
        LaravelLog::error("$messages \n");
    }

    /**
     * Beautify the log output with `warning` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function warning(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        LaravelLog::warning("========= $title  ========= \n");
        LaravelLog::warning("$messages \n");
    }

    /**
     * Beautify the log output with `notice` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function notice(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        LaravelLog::notice("========= $title  ========= \n");
        LaravelLog::notice("$messages \n");
    }

    /**
     * Beautify the log output with `info` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function info(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        LaravelLog::info("========= $title  ========= \n");
        LaravelLog::info("$messages \n");
    }

    /**
     * Beautify the log output with `debug` level
     *
     * @param string $title
     * @param mixed  $messages
     */
    public static function debug(string $title, $messages): void
    {
        $messages = Helpers::toString($messages);

        LaravelLog::debug("========= $title  ========= \n");
        LaravelLog::debug("$messages \n");
    }
}
