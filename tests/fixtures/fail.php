<?php
/**
 * Code the ruleset must reject: long arrays and Yoda conditions.
 *
 * @package YourMark\CodingStandards
 */

namespace YourMark\CodingStandards\Fixtures;

/**
 * Returns a long-syntax array.
 *
 * @param string $status Status to check.
 * @return array<string, bool>
 */
function fail( string $status ): array {
	return array( 'active' => 'active' === $status );
}
