<?php
/**
 * Code the ruleset must accept.
 *
 * @package YourMark\CodingStandards
 */

namespace YourMark\CodingStandards\Fixtures;

/**
 * Exercises the house exceptions to WPCS.
 */
class Pass {

	/**
	 * Short arrays, non-Yoda comparisons and a namespaced hook name.
	 *
	 * @param string $status Status to check.
	 * @return array<string, bool>
	 */
	public function check( string $status ): array {
		$is_active = $status === 'active';

		do_action( 'yourmark/fixtures/checked', $status );

		return [ 'active' => $is_active ];
	}
}
