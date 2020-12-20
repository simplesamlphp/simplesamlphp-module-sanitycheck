<?php

use SimpleSAML\Locale\Translate;
use SimpleSAML\Module;
use Webmozart\Assert\Assert;

/**
 * Hook to add the modinfo module to the frontpage.
 *
 * @param array &$links  The links on the frontpage, split into sections.
 */
function sanitycheck_hook_frontpage(array &$links): void
{
    Assert::keyExists($links, 'links');

    $links['config']['sanitycheck'] = [
        'href' => Module::getModuleURL('sanitycheck/index.php'),
        'text' => Translate::noop('Sanity check of your SimpleSAMLphp setup'),
    ];
}
