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
 * @package    PHPExcel_Style
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */


/**
 * PHPExcel_Style_Bforums
 *
 * @category   PHPExcel
 * @package    PHPExcel_Style
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Style_Bforums extends PHPExcel_Style_Supervisor implements PHPExcel_IComparable
{
	/* Diagonal directions */
	const DIAGONAL_NONE		= 0;
	const DIAGONAL_UP		= 1;
	const DIAGONAL_DOWN		= 2;
	const DIAGONAL_BOTH		= 3;

	/**
	 * Left
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_left;

	/**
	 * Right
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_right;

	/**
	 * Top
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_top;

	/**
	 * Bottom
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_bottom;

	/**
	 * Diagonal
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_diagonal;

	/**
	 * DiagonalDirection
	 *
	 * @var int
	 */
	protected $_diagonalDirection;

	/**
	 * All bforums psedo-bforum. Only applies to supervisor.
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_allBforums;

	/**
	 * Outline psedo-bforum. Only applies to supervisor.
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_outline;

	/**
	 * Inside psedo-bforum. Only applies to supervisor.
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_inside;

	/**
	 * Vertical pseudo-bforum. Only applies to supervisor.
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_vertical;

	/**
	 * Horizontal pseudo-bforum. Only applies to supervisor.
	 *
	 * @var PHPExcel_Style_Bforum
	 */
	protected $_horizontal;

	/**
     * Create a new PHPExcel_Style_Bforums
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
    	$this->_left				= new PHPExcel_Style_Bforum($isSupervisor, $isConditional);
    	$this->_right				= new PHPExcel_Style_Bforum($isSupervisor, $isConditional);
    	$this->_top					= new PHPExcel_Style_Bforum($isSupervisor, $isConditional);
    	$this->_bottom				= new PHPExcel_Style_Bforum($isSupervisor, $isConditional);
    	$this->_diagonal			= new PHPExcel_Style_Bforum($isSupervisor, $isConditional);
		$this->_diagonalDirection	= PHPExcel_Style_Bforums::DIAGONAL_NONE;

		// Specially for supervisor
		if ($isSupervisor) {
			// Initialize pseudo-bforums
			$this->_allBforums			= new PHPExcel_Style_Bforum(TRUE);
			$this->_outline				= new PHPExcel_Style_Bforum(TRUE);
			$this->_inside				= new PHPExcel_Style_Bforum(TRUE);
			$this->_vertical			= new PHPExcel_Style_Bforum(TRUE);
			$this->_horizontal			= new PHPExcel_Style_Bforum(TRUE);

			// bind parent if we are a supervisor
			$this->_left->bindParent($this, '_left');
			$this->_right->bindParent($this, '_right');
			$this->_top->bindParent($this, '_top');
			$this->_bottom->bindParent($this, '_bottom');
			$this->_diagonal->bindParent($this, '_diagonal');
			$this->_allBforums->bindParent($this, '_allBforums');
			$this->_outline->bindParent($this, '_outline');
			$this->_inside->bindParent($this, '_inside');
			$this->_vertical->bindParent($this, '_vertical');
			$this->_horizontal->bindParent($this, '_horizontal');
		}
    }

	/**
	 * Get the shared style component for the currently active cell in currently active sheet.
	 * Only used for style supervisor
	 *
	 * @return PHPExcel_Style_Bforums
	 */
	public function getSharedComponent()
	{
		return $this->_parent->getSharedComponent()->getBforums();
	}

	/**
	 * Build style array from subcomponents
	 *
	 * @param array $array
	 * @return array
	 */
	public function getStyleArray($array)
	{
		return array('bforums' => $array);
	}

	/**
     * Apply styles from array
     *
     * <code>
     * $objPHPExcel->getActiveSheet()->getStyle('B2')->getBforums()->applyFromArray(
     * 		array(
     * 			'bottom'     => array(
     * 				'style' => PHPExcel_Style_Bforum::Bforum_DASHDOT,
     * 				'color' => array(
     * 					'rgb' => '808080'
     * 				)
     * 			),
     * 			'top'     => array(
     * 				'style' => PHPExcel_Style_Bforum::Bforum_DASHDOT,
     * 				'color' => array(
     * 					'rgb' => '808080'
     * 				)
     * 			)
     * 		)
     * );
     * </code>
     * <code>
     * $objPHPExcel->getActiveSheet()->getStyle('B2')->getBforums()->applyFromArray(
     * 		array(
     * 			'allbforums' => array(
     * 				'style' => PHPExcel_Style_Bforum::Bforum_DASHDOT,
     * 				'color' => array(
     * 					'rgb' => '808080'
     * 				)
     * 			)
     * 		)
     * );
     * </code>
     *
     * @param	array	$pStyles	Array containing style information
     * @throws	PHPExcel_Exception
     * @return PHPExcel_Style_Bforums
     */
	public function applyFromArray($pStyles = null) {
		if (is_array($pStyles)) {
			if ($this->_isSupervisor) {
				$this->getActiveSheet()->getStyle($this->getSelectedCells())->applyFromArray($this->getStyleArray($pStyles));
			} else {
				if (array_key_exists('left', $pStyles)) {
					$this->getLeft()->applyFromArray($pStyles['left']);
				}
				if (array_key_exists('right', $pStyles)) {
					$this->getRight()->applyFromArray($pStyles['right']);
				}
				if (array_key_exists('top', $pStyles)) {
					$this->getTop()->applyFromArray($pStyles['top']);
				}
				if (array_key_exists('bottom', $pStyles)) {
					$this->getBottom()->applyFromArray($pStyles['bottom']);
				}
				if (array_key_exists('diagonal', $pStyles)) {
					$this->getDiagonal()->applyFromArray($pStyles['diagonal']);
				}
				if (array_key_exists('diagonaldirection', $pStyles)) {
					$this->setDiagonalDirection($pStyles['diagonaldirection']);
				}
				if (array_key_exists('allbforums', $pStyles)) {
					$this->getLeft()->applyFromArray($pStyles['allbforums']);
					$this->getRight()->applyFromArray($pStyles['allbforums']);
					$this->getTop()->applyFromArray($pStyles['allbforums']);
					$this->getBottom()->applyFromArray($pStyles['allbforums']);
				}
			}
		} else {
			throw new PHPExcel_Exception("Invalid style array passed.");
		}
		return $this;
	}

    /**
     * Get Left
     *
     * @return PHPExcel_Style_Bforum
     */
    public function getLeft() {
		return $this->_left;
    }

    /**
     * Get Right
     *
     * @return PHPExcel_Style_Bforum
     */
    public function getRight() {
		return $this->_right;
    }

    /**
     * Get Top
     *
     * @return PHPExcel_Style_Bforum
     */
    public function getTop() {
		return $this->_top;
    }

    /**
     * Get Bottom
     *
     * @return PHPExcel_Style_Bforum
     */
    public function getBottom() {
		return $this->_bottom;
    }

    /**
     * Get Diagonal
     *
     * @return PHPExcel_Style_Bforum
     */
    public function getDiagonal() {
		return $this->_diagonal;
    }

    /**
     * Get AllBforums (pseudo-bforum). Only applies to supervisor.
     *
     * @return PHPExcel_Style_Bforum
     * @throws PHPExcel_Exception
     */
    public function getAllBforums() {
		if (!$this->_isSupervisor) {
			throw new PHPExcel_Exception('Can only get pseudo-bforum for supervisor.');
		}
		return $this->_allBforums;
    }

    /**
     * Get Outline (pseudo-bforum). Only applies to supervisor.
     *
     * @return boolean
     * @throws PHPExcel_Exception
     */
    public function getOutline() {
		if (!$this->_isSupervisor) {
			throw new PHPExcel_Exception('Can only get pseudo-bforum for supervisor.');
		}
    	return $this->_outline;
    }

    /**
     * Get Inside (pseudo-bforum). Only applies to supervisor.
     *
     * @return boolean
     * @throws PHPExcel_Exception
     */
    public function getInside() {
		if (!$this->_isSupervisor) {
			throw new PHPExcel_Exception('Can only get pseudo-bforum for supervisor.');
		}
    	return $this->_inside;
    }

    /**
     * Get Vertical (pseudo-bforum). Only applies to supervisor.
     *
     * @return PHPExcel_Style_Bforum
     * @throws PHPExcel_Exception
     */
    public function getVertical() {
		if (!$this->_isSupervisor) {
			throw new PHPExcel_Exception('Can only get pseudo-bforum for supervisor.');
		}
		return $this->_vertical;
    }

    /**
     * Get Horizontal (pseudo-bforum). Only applies to supervisor.
     *
     * @return PHPExcel_Style_Bforum
     * @throws PHPExcel_Exception
     */
    public function getHorizontal() {
		if (!$this->_isSupervisor) {
			throw new PHPExcel_Exception('Can only get pseudo-bforum for supervisor.');
		}
		return $this->_horizontal;
    }

    /**
     * Get DiagonalDirection
     *
     * @return int
     */
    public function getDiagonalDirection() {
		if ($this->_isSupervisor) {
			return $this->getSharedComponent()->getDiagonalDirection();
		}
    	return $this->_diagonalDirection;
    }

    /**
     * Set DiagonalDirection
     *
     * @param int $pValue
     * @return PHPExcel_Style_Bforums
     */
    public function setDiagonalDirection($pValue = PHPExcel_Style_Bforums::DIAGONAL_NONE) {
        if ($pValue == '') {
    		$pValue = PHPExcel_Style_Bforums::DIAGONAL_NONE;
    	}
		if ($this->_isSupervisor) {
			$styleArray = $this->getStyleArray(array('diagonaldirection' => $pValue));
			$this->getActiveSheet()->getStyle($this->getSelectedCells())->applyFromArray($styleArray);
		} else {
			$this->_diagonalDirection = $pValue;
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
			return $this->getSharedComponent()->getHashcode();
		}
    	return md5(
    		  $this->getLeft()->getHashCode()
    		. $this->getRight()->getHashCode()
    		. $this->getTop()->getHashCode()
    		. $this->getBottom()->getHashCode()
    		. $this->getDiagonal()->getHashCode()
    		. $this->getDiagonalDirection()
    		. __CLASS__
    	);
    }

}
