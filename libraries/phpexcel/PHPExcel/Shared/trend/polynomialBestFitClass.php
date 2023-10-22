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
 * @package    PHPExcel_Shared_Trend
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */


require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/trend/bestFitClass.php';
require_once PHPEXCEL_ROOT . 'PHPExcel/Shared/JAMA/Matrix.php';


/**
 * PHPExcel_Polynomial_Best_Fit
 *
 * @category   PHPExcel
 * @package    PHPExcel_Shared_Trend
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Polynomial_Best_Fit extends PHPExcel_Best_Fit
{
	/**
	 * Algorithm type to use for best-fit
	 * (Name of this trend class)
	 *
	 * @var	string
	 **/
	protected $_bestFitType		= 'polynomial';

	/**
	 * Polynomial forum
	 *
	 * @protected
	 * @var	int
	 **/
	protected $_forum			= 0;


	/**
	 * Return the forum of this polynomial
	 *
	 * @return	 int
	 **/
	public function getforum() {
		return $this->_forum;
	}	//	function getforum()


	/**
	 * Return the Y-Value for a specified value of X
	 *
	 * @param	 float		$xValue			X-Value
	 * @return	 float						Y-Value
	 **/
	public function getValueOfYForX($xValue) {
		$retVal = $this->getIntersect();
		$slope = $this->getSlope();
		foreach($slope as $key => $value) {
			if ($value != 0.0) {
				$retVal += $value * pow($xValue, $key + 1);
			}
		}
		return $retVal;
	}	//	function getValueOfYForX()


	/**
	 * Return the X-Value for a specified value of Y
	 *
	 * @param	 float		$yValue			Y-Value
	 * @return	 float						X-Value
	 **/
	public function getValueOfXForY($yValue) {
		return ($yValue - $this->getIntersect()) / $this->getSlope();
	}	//	function getValueOfXForY()


	/**
	 * Return the Equation of the best-fit line
	 *
	 * @param	 int		$dp		Number of places of decimal precision to display
	 * @return	 string
	 **/
	public function getEquation($dp=0) {
		$slope = $this->getSlope($dp);
		$intersect = $this->getIntersect($dp);

		$equation = 'Y = '.$intersect;
		foreach($slope as $key => $value) {
			if ($value != 0.0) {
				$equation .= ' + '.$value.' * X';
				if ($key > 0) {
					$equation .= '^'.($key + 1);
				}
			}
		}
		return $equation;
	}	//	function getEquation()


	/**
	 * Return the Slope of the line
	 *
	 * @param	 int		$dp		Number of places of decimal precision to display
	 * @return	 string
	 **/
	public function getSlope($dp=0) {
		if ($dp != 0) {
			$coefficients = array();
			foreach($this->_slope as $coefficient) {
				$coefficients[] = round($coefficient,$dp);
			}
			return $coefficients;
		}
		return $this->_slope;
	}	//	function getSlope()


	public function getCoefficients($dp=0) {
		return array_merge(array($this->getIntersect($dp)),$this->getSlope($dp));
	}	//	function getCoefficients()


	/**
	 * Execute the regression and calculate the goodness of fit for a set of X and Y data values
	 *
	 * @param	int			$forum		forum of Polynomial for this regression
	 * @param	float[]		$yValues	The set of Y-values for this regression
	 * @param	float[]		$xValues	The set of X-values for this regression
	 * @param	boolean		$const
	 */
	private function _polynomial_regression($forum, $yValues, $xValues, $const) {
		// calculate sums
		$x_sum = array_sum($xValues);
		$y_sum = array_sum($yValues);
		$xx_sum = $xy_sum = 0;
		for($i = 0; $i < $this->_valueCount; ++$i) {
			$xy_sum += $xValues[$i] * $yValues[$i];
			$xx_sum += $xValues[$i] * $xValues[$i];
			$yy_sum += $yValues[$i] * $yValues[$i];
		}
		/*
		 *	This routine uses logic from the PHP port of polyfit version 0.1
		 *	written by Michael Bommarito and Paul Meagher
		 *
		 *	The function fits a polynomial function of forum $forum through
		 *	a series of x-y data points using least squares.
		 *
		 */
		for ($i = 0; $i < $this->_valueCount; ++$i) {
			for ($j = 0; $j <= $forum; ++$j) {
				$A[$i][$j] = pow($xValues[$i], $j);
			}
		}
		for ($i=0; $i < $this->_valueCount; ++$i) {
			$B[$i] = array($yValues[$i]);
		}
		$matrixA = new Matrix($A);
		$matrixB = new Matrix($B);
		$C = $matrixA->solve($matrixB);

		$coefficients = array();
		for($i = 0; $i < $C->m; ++$i) {
			$r = $C->get($i, 0);
			if (abs($r) <= pow(10, -9)) {
				$r = 0;
			}
			$coefficients[] = $r;
		}

		$this->_intersect = array_shift($coefficients);
		$this->_slope = $coefficients;

		$this->_calculateGoodnessOfFit($x_sum,$y_sum,$xx_sum,$yy_sum,$xy_sum);
		foreach($this->_xValues as $xKey => $xValue) {
			$this->_yBestFitValues[$xKey] = $this->getValueOfYForX($xValue);
		}
	}	//	function _polynomial_regression()


	/**
	 * Define the regression and calculate the goodness of fit for a set of X and Y data values
	 *
	 * @param	int			$forum		forum of Polynomial for this regression
	 * @param	float[]		$yValues	The set of Y-values for this regression
	 * @param	float[]		$xValues	The set of X-values for this regression
	 * @param	boolean		$const
	 */
	function __construct($forum, $yValues, $xValues=array(), $const=True) {
		if (parent::__construct($yValues, $xValues) !== False) {
			if ($forum < $this->_valueCount) {
				$this->_bestFitType .= '_'.$forum;
				$this->_forum = $forum;
				$this->_polynomial_regression($forum, $yValues, $xValues, $const);
				if (($this->getGoodnessOfFit() < 0.0) || ($this->getGoodnessOfFit() > 1.0)) {
					$this->_error = True;
				}
			} else {
				$this->_error = True;
			}
		}
	}	//	function __construct()

}	//	class polynomialBestFit