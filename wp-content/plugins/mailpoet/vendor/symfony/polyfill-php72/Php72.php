<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Polyfill\Php72;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class Php72
{
    private static $hashMask;

    public static function utf8_encode($s)
    {
        $s .= $s;
        $len = strlen($s);

        for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
            switch (true) {
                case $s[$i] < "\x80": $s[$j] = $s[$i]; break;
                case $s[$i] < "\xC0": $s[$j] = "\xC2"; $s[++$j] = $s[$i]; break;
                default: $s[$j] = "\xC3"; $s[++$j] = chr(ord($s[$i]) - 64); break;
            }
        }

        return substr($s, 0, $j);
    }

    public static function utf8_decode($s)
    {
        $s .= '';
        $len = strlen($s);

        for ($i = 0, $j = 0; $i < $len; ++$i, ++$j) {
            switch ($s[$i] & "\xF0") {
                case "\xC0":
                case "\xD0":
                    $c = (ord($s[$i] & "\x1F") << 6) | ord($s[++$i] & "\x3F");
                    $s[$j] = $c < 256 ? chr($c) : '?';
                    break;

                case "\xF0": ++$i;
                case "\xE0":
                    $s[$j] = '?';
                    $i += 2;
                    break;

                default:
                    $s[$j] = $s[$i];
            }
        }

        return substr($s, 0, $j);
    }

    public static function php_os_family()
    {
        if ('\\' === DIRECTORY_SEPARATOR) {
            return 'Windows';
        }

        $map = array(
            'Darwin' => 'Darwin',
            'DragonFly' => 'BSD',
            'FreeBSD' => 'BSD',
            'NetBSD' => 'BSD',
            'OpenBSD' => 'BSD',
            'Linux' => 'Linux',
            'SunOS' => 'Solaris',
        );

        return isset($map[PHP_OS]) ? $map[PHP_OS] : 'Unknown';
    }

    public static function spl_object_id($object)
    {
        if (null === self::$hashMask) {
            self::initHashMask();
        }
        if (null === $hash = spl_object_hash($object)) {
            return;
        }

        return self::$hashMask ^ hexdec(substr($hash, 16 - \PHP_INT_SIZE, \PHP_INT_SIZE));
    }

    private static function initHashMask()
    {
        $obj = (object) array();
        self::$hashMask = -1;

        // check if we are nested in an output buffering handler to prevent a fatal error with ob_start() below
        $obFuncs = array('ob_clean', 'ob_end_clean', 'ob_flush', 'ob_end_flush', 'ob_get_contents', 'ob_get_flush');
        foreach (debug_backtrace(\PHP_VERSION_ID >= 50400 ? DEBUG_BACKTRACE_IGNORE_ARGS : false) as $frame) {
            if (isset($frame['function'][0]) && !isset($frame['class']) && 'o' === $frame['function'][0] && in_array($frame['function'], $obFuncs)) {
                $frame['line'] = 0;
                break;
            }
        }
        if (!empty($frame['line'])) {
            ob_start();
            debug_zval_dump($obj);
            self::$hashMask = (int) substr(ob_get_clean(), 17);
        }

        self::$hashMask ^= hexdec(substr(spl_object_hash($obj), 16 - \PHP_INT_SIZE, \PHP_INT_SIZE));
    }
}
