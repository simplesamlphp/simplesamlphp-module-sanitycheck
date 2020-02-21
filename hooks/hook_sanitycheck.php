<?php

use Webmozart\Assert\Assert;

/**
 * Hook to add the modinfo module to the frontpage.
 *
 * @param array &$hookinfo  hookinfo
 * @return void
 */
function sanitycheck_hook_sanitycheck(array &$hookinfo)
{
    Assert::keyExists($hookinfo, 'errors');
    Assert::keyExists($hookinfo, 'info');

    $hookinfo['info'][] = '[sanitycheck] At least the sanity check itself is working :)';
}
