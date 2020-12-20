<?php

use Webmozart\Assert\Assert;

/**
 * Hook to add the modinfo module to the frontpage.
 *
 * @param array &$hookinfo  hookinfo
 */
function sanitycheck_hook_sanitycheck(array &$hookinfo): void
{
    Assert::keyExists($hookinfo, 'errors');
    Assert::keyExists($hookinfo, 'info');

    $hookinfo['info'][] = '[sanitycheck] At least the sanity check itself is working :)';
}
