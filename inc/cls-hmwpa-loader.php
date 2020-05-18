<?php
/**
 * General action, hooks loader
*/
class HMWPA_Loader {

	protected $hmwpa_actions;
	protected $hmwpa_filters;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->hmwpa_actions = array();
		$this->hmwpa_filters = array();
	}

	function add_action( $hook, $component, $callback ){
		$this->hmwpa_actions = $this->add( $this->hmwpa_actions, $hook, $component, $callback );
	}

	function add_filter( $hook, $component, $callback ){
		$this->hmwpa_filters = $this->add( $this->hmwpa_filters, $hook, $component, $callback );
	}

	private function add( $hooks, $hook, $component, $callback ){
		$hooks[] = array( 'hook' => $hook, 'component' => $component, 'callback' => $callback );
		return $hooks;
	}

	public function hmwpa_run(){
		foreach( $this->hmwpa_filters as $hook ){
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
		foreach( $this->hmwpa_actions as $hook ){
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}
}
?>