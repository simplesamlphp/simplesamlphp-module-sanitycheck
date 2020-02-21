<?php

use SimpleSAML\Module;
use SimpleSAML\Locale\Translate;
use SimpleSAML\XHTML\Template;

/**
 * Hook to add the sanitycheck link to the config page.
 *
 * @param \SimpleSAML\XHTML\Template &$template The template that we should alter in this hook.
 * @return void
 */
function sanitycheck_hook_configpage(Template &$template): void
{
    $template->data['links']['sanitycheck'] = [
        'href' => Module::getModuleURL('sanitycheck/index.php'),
        'text' => Translate::noop('Sanity check of your SimpleSAMLphp setup'),
    ];
    $template->getLocalization()->addModuleDomain('sanitycheck');
}
