<?php

namespace Khill\Lavacharts\Dashboards\Filters;

use \Khill\Lavacharts\Configs\Options;
use \Khill\Lavacharts\Exceptions\InvalidConfigValue;
use \Khill\Lavacharts\Traits\OptionsTrait as HasOptions;
use \Khill\Lavacharts\Traits\NonEmptyStringTrait as StringCheck;
use \Khill\Lavacharts\Contracts\WrappableInterface as Wrappable;

/**
 * Filter Parent Class
 *
 * The base class for the individual filter objects, providing common
 * functions to the child objects.
 *
 *
 * @package    Khill\Lavacharts
 * @subpackage Dashbaords\Filters
 * @since      3.0.0
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2016, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */
class Filter implements Wrappable, \JsonSerializable
{
    use HasOptions, StringCheck;

    /**
     * Wrapper type when used in a dashboard
     */
    const WRAP_TYPE = 'controlType';

    /**
     * Builds a new Filter Object.
     *
     * Takes either a column label or a column index to filter. The options object will be
     * created internally, so no need to set defaults. The child filter objects will set them.
     *
     * @param  string|int $columnLabelOrIndex
     * @param  array      $config Array of options to set.
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     */
    public function __construct($columnLabelOrIndex, array $config = [])
    {
        if ($this->nonEmptyString($columnLabelOrIndex) === false && is_int($columnLabelOrIndex) === false) {
            throw new InvalidConfigValue(
                static::TYPE . '->' . __FUNCTION__,
                'string|int'
            );
        }

        if (is_string($columnLabelOrIndex) === true) {
            $config = array_merge($config, ['filterColumnLabel' => $columnLabelOrIndex]);
        }

        if (is_int($columnLabelOrIndex) === true) {
            $config = array_merge($config, ['filterColumnIndex' => $columnLabelOrIndex]);
        }

        $this->options = new Options($config);
    }

    /**
     * Returns the Filter type.
     *
     * @return string
     */
    public function getType()
    {
        return static::TYPE;
    }

    /**
     * Returns the Filter wrap type.
     *
     * @since 3.1.0
     * @return string
     */
    public function getWrapType()
    {
        return static::WRAP_TYPE;
    }

    /**
     * Custom serialization of the Filter
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->options;
    }
}
