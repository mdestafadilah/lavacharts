<?php

namespace Khill\Lavacharts\Support\Traits;

use Khill\Lavacharts\Values\Label;
use Khill\Lavacharts\Values\ElementId;
use Khill\Lavacharts\Support\Traits\ElementIdTrait as HasElementId;

/**
 * Trait RenderableTrait
 *
 * This class is the parent to charts, dashboards, and controls since they
 * will need to be rendered onto the page.
 *
 * @package    Khill\Lavacharts\Support
 * @since      3.1.0
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2016, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */
trait RenderableTrait
{
    use HasElementId;

    /**
     * The renderable's unique label.
     *
     * @var \Khill\Lavacharts\Values\Label
     */
    protected $label;

    /**
     * The renderable's unique elementId.
     *
     * @var \Khill\Lavacharts\Values\ElementId
     */
    protected $elementId;

    /**
     * Status for if a chart is directly renderable or if it is part of a dashboard.
     *
     * @var bool
     */
    protected $renderableStatus = true;

    /**
     * Sets the renderable's ElementId or generates on from a string
     *
     * @param \Khill\Lavacharts\Values\Label     $label
     * @param \Khill\Lavacharts\Values\ElementId $elementId
     */
    public function initRenderable(Label $label, ElementId $elementId = null)
    {
        $this->label = $label;

        if ($elementId === null) {
            $this->generateElementId();
        } else {
            $this->elementId = $elementId;
        }
    }

    /**
     * Creates and/or sets the Label.
     *
     * @param  string|\Khill\Lavacharts\Values\Label $label
     * @throws \Khill\Lavacharts\Exceptions\InvalidLabel
     */
    public function setLabel($label)
    {
        if ($label instanceof Label) {
            $this->label = $label;
        } else {
            $this->label = new Label($label);
        }
    }

    /**
     * Returns the label.
     *
     * @return \Khill\Lavacharts\Values\Label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns the label.
     *
     * @return \Khill\Lavacharts\Values\Label
     */
    public function getLabelStr()
    {
        return (string) $this->label;
    }

    /**
     * Sets the renderable status of the Chart
     *
     * @since  3.1.0
     * @param bool $renderable
     */
    public function setRenderable($renderable)
    {
        $this->renderableStatus = (bool) $renderable;
    }

    /**
     * Returns the status of the renderability of the chart.
     *
     * @since  3.1.0
     * @return bool
     */
    public function isRenderable()
    {
        return $this->renderableStatus;
    }

    /**
     * Generate an ElementId
     *
     * This method removes invalid characters from the chart label
     * to use as an elementId.
     *
     * @access private
     * @link   http://stackoverflow.com/a/11330527/2503458
     */
    private function generateElementId()
    {
        $string = strtolower($this->getLabelStr());
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", "-", $string);

        $this->setElementId($string);
    }
}
