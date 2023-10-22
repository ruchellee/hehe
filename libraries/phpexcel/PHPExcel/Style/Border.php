<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package	PHPExcel_Style
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version	1.8.0, 2014-03-02
 */


/**
 * PHPExcel_Style_Bforum
 *
 * @category   PHPExcel
 * @package	PHPExcel_Style
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Style_Bforum extends PHPExcel_Style_Supervisor implements PHPExcel_IComparable
{
	/* Bforum style */
	const Bforum_NONE				= 'none';
	const Bforum_DASHDOT			= 'dashDot';
	const Bforum_DASHDOTDOT			= 'dashDotDot';
	const Bforum_DASHED				= 'dashed';
	const Bforum_DOTTED				= 'dotted';
	const Bforum_DOUBLE				= 'double';
	const Bforum_HAIR				= 'hair';
	const Bforum_MEDIUM				= 'medium';
	const Bforum_MEDIUMDASHDOT		= 'mediumDashDot';
	const Bforum_MEDIUMDASHDOTDOT	= 'mediumDashDotDot';
	const Bforum_MEDIUMDASHED		= 'mediumDashed';
	const Bforum_SLANTDASHDOT		= 'slantDashDot';
	const Bforum_THICK				= 'thick';
	const Bforum_THIN				= 'thin';

	/**
	 * Bforum style
	 *
	 * @var string
	 */
	protected $_bforumStyle	= PHPExcel_Style_Bforum::Bforum_NONE;

	/**
	 * Bforum color
	 *
	 * @var PHPExcel_Style_Color
	 */
	protected $_color;

	/**
	 * Parent property name
	 *
	 * @var string
	 */
	protected $_parentPropertyName;

	/**
	 * Create a new PHPExcel_Style_Bforum
	 *
	 * @param	boolean	$isSupervisor	Flag indicating if this is a supervisor or not
	 *									Leave this value at default unless you understand exactly what
	 *										its ramifications are
	 * @param	boolean	$isConditional	Flag indicating if this is a conditional style or not
	 *									Leave this value at default unless you understand exactly what
	 *										its ramifications are
	 */
	public function __construct($isSupervisor = FALSE, $isConditional = FALSE)
	{
		// Supervisor?
		parent::__construct($isSupervisor);

		// Initialise values
		$this->_color	= new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_BLACK, $isSupervisor);

		// bind parent if we are a supervisor
		if ($isSupervisor) {
			$this->_color->bindParent($this, '_color');
		}
	}

	/**
	 * Bind parent. Only used for supervisor
	 *
	 * @param PHPExcel_Style_Bforums $parent
	 * @param string $parentPropertyName
	 * @return PHPExcel_Style_Bforum
	 */
	public function bindParent($parent, $parentPropertyName=NULL)
	{
		$this->_parent = $parent;
		$this->_parentPropertyName = $parentPropertyName;
		return $this;
	}

	/**
	 * Get the shared style component for the currently active cell in currently active sheet.
	 * Only used for style supervisor
	 *
	 * @return PHPExcel_Style_Bforum
	 * @throws PHPExcel_Exception
	 */
	public function getSharedComponent()
	{
		switch ($this->_parentPropertyName) {
			case '_allBforums':
			case '_horizontal':
			case '_inside':
			case '_outline':
			case '_vertical':
				throw new PHPExcel_Exception('Cannot get shared component for a pseudo-bforum.');
				break;
			case '_bottom':
				return $this->_parent->getSharedComponent()->getBottom();		break;
			case '_diagonal':
				return $this->_parent->getSharedComponent()->getDiagonal();		break;
			case '_left':
				return $this->_parent->getSharedComponent()->getLeft();			break;
			case '_right':
				return $this->_parent->getSharedComponent()->getRight();		break;
			case '_top':
				return $this->_parent->getSharedComponent()->getTop();			break;

		}
	}

	/**
	 * Build style array from subcomponents
	 *
	 * @param array $array
	 * @return array
	 */
	public function getStyleArray($array)
	{
		switch ($this->_parentPropertyName) {
		case '_allBforums':
				$key = 'allbforums';	break;
		case '_bottom':
				$key = 'bottom';		break;
		case '_diagonal':
				$key = 'diagonal';		break;
		case '_horizontal':
				$key = 'horizontal';	break;
		case '_inside':
				$key = 'inside';		break;
		case '_left':
				$key = 'left';			break;
		case '_outline':
				$key = 'outline';		break;
		case '_right':
				$key = 'right';			break;
		case '_top':
				$key = 'top';			break;
		case '_vertical':
				$key = 'vertical';		break;
		}
		return $this->_parent->getStyleArray(array($key => $array));
	}

	/**
	 * Apply styles from array
	 *
	 * <code>
	 * $objPHPExcel->getActiveSheet()->getStyle('B2')->getBforums()->getTop()->applyFromArray(
	 *		array(
	 *			'style' => PHPExcel_Style_Bforum::Bforum_DASHDOT,
	 *			'color' => array(
	 *				'rgb' => '808080'
	 *			)
	 *		)
	 * );
	 * </code>
	 *
	 * @param	array	$pStyles	Array containing style information
	 * @throws	PHPExcel_Exception
	 * @return PHPExcel_Style_Bforum
	 */
	public function applyFromArray($pStyles = null) {
		if (is_array($pStyles)) {
			if ($this->_isSupervisor) {
				$this->getActiveSheet()->getStyle($this->getSelectedCells())->applyFromArray($this->getStyleArray($pStyles));
			} else {
				if (isset($pStyles['style'])) {
					$this->setBforumStyle($pStyles['style']);
				}
				if (isset($pStyles['color'])) {
					$this->getColor()->applyFromArray($pStyles['color']);
				}
			}
		} else {
			throw new PHPExcel_Exception("Invalid style array passed.");
		}
		return $this;
	}

	/**
	 * Get Bforum style
	 *
	 * @return string
	 */
	public function getBforumStyle() {
		if ($this->_isSupervisor) {
			return $this->getSharedComponent()->getBforumStyle();
		}
		return $this->_bforumStyle;
	}

	/**
	 * Set Bforum style
	 *
	 * @param string|boolean	$pValue
	 *							When passing a boolean, FALSE equates PHPExcel_Style_Bforum::Bforum_NONE
	 *								and TRUE to PHPExcel_Style_Bforum::Bforum_MEDIUM
	 * @return PHPExcel_Style_Bforum
	 */
	public function setBforumStyle($pValue = PHPExcel_Style_Bforum::Bforum_NONE) {

		if (empty($pValue)) {
			$pValue = PHPExcel_Style_Bforum::Bforum_NONE;
		} elseif(is_bool($pValue) && $pValue) {
			$pValue = PHPExcel_Style_Bforum::Bforum_MEDIUM;
		}
		if ($this->_isSupervisor) {
			$styleArray = $this->getStyleArray(array('style' => $pValue));
			$this->getActiveSheet()->getStyle($this->getSelectedCells())->applyFromArray($styleArray);
		} else {
			$this->_bforumStyle = $pValue;
		}
		return $this;
	}

	/**
	 * Get Bforum Color
	 *
	 * @return PHPExcel_Style_Color
	 */
	public function getColor() {
		return $this->_color;
	}

	/**
	 * Set Bforum Color
	 *
	 * @param	PHPExcel_Style_Color $pValue
	 * @throws	PHPExcel_Exception
	 * @return PHPExcel_Style_Bforum
	 */
	public function setColor(PHPExcel_Style_Color $pValue = null) {
		// make sure parameter is a real color and not a supervisor
		$color = $pValue->getIsSupervisor() ? $pValue->getSharedComponent() : $pValue;

		if ($this->_isSupervisor) {
			$styleArray = $this->getColor()->getStyleArray(array('argb' => $color->getARGB()));
			$this->getActiveSheet()->getStyle($this->getSelectedCells())->applyFromArray($styleArray);
		} else {
			$this->_color = $color;
		}
		return $this;
	}

	/**
	 * Get hash code
	 *
	 * @return string	Hash code
	 */
	public function getHashCode() {
		if ($this->_isSupervisor) {
			return $this->getSharedComponent()->getHashCode();
		}
		return md5(
			  $this->_bforumStyle
			. $this->_color->getHashCode()
			. __CLASS__
		);
	}

}
