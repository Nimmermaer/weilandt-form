<?php

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Twig_Node_Expression_GetAttr extends Twig_Node_Expression {
	public function __construct( Twig_Node_Expression $node, Twig_Node_Expression $attribute, Twig_Node_Expression $arguments = NULL, $type, $lineno ) {
		parent::__construct( array( 'node' => $node, 'attribute' => $attribute, 'arguments' => $arguments ),
		                     array(
			                     'type'                => $type,
			                     'is_defined_test'     => FALSE,
			                     'ignore_strict_check' => FALSE,
			                     'disable_c_ext'       => FALSE
		                     ),
		                     $lineno );
	}

	public function compile( Twig_Compiler $compiler ) {
		if ( function_exists( 'twig_template_get_attributes' ) && ! $this->getAttribute( 'disable_c_ext' ) ) {
			$compiler->raw( 'twig_template_get_attributes($this, ' );
		} else {
			$compiler->raw( '$this->getAttribute(' );
		}

		if ( $this->getAttribute( 'ignore_strict_check' ) ) {
			$this->getNode( 'node' )->setAttribute( 'ignore_strict_check', TRUE );
		}

		$compiler->subcompile( $this->getNode( 'node' ) );

		$compiler->raw( ', ' )->subcompile( $this->getNode( 'attribute' ) );

		// only generate optional arguments when needed (to make generated code more readable)
		$needFourth = $this->getAttribute( 'ignore_strict_check' );
		$needThird  = $needFourth || $this->getAttribute( 'is_defined_test' );
		$needSecond = $needThird || Twig_Template::ANY_CALL !== $this->getAttribute( 'type' );
		$needFirst  = $needSecond || NULL !== $this->getNode( 'arguments' );

		if ( $needFirst ) {
			if ( NULL !== $this->getNode( 'arguments' ) ) {
				$compiler->raw( ', ' )->subcompile( $this->getNode( 'arguments' ) );
			} else {
				$compiler->raw( ', array()' );
			}
		}

		if ( $needSecond ) {
			$compiler->raw( ', ' )->repr( $this->getAttribute( 'type' ) );
		}

		if ( $needThird ) {
			$compiler->raw( ', ' )->repr( $this->getAttribute( 'is_defined_test' ) );
		}

		if ( $needFourth ) {
			$compiler->raw( ', ' )->repr( $this->getAttribute( 'ignore_strict_check' ) );
		}

		$compiler->raw( ')' );
	}
}
