<?php

use Exception;
use SimpleSAML\Configuration;
use SimpleSAML\Logger;
use SimpleSAML\Module;
use Webmozart\Assert\Assert;

/**
 * Hook to run a cron job.
 *
 * @param array &$croninfo  Output
 */
function sanitycheck_hook_cron(array &$croninfo): void
{
    Assert::keyExists($croninfo, 'summary');
    Assert::keyExists($croninfo, 'tag');

    Logger::info('cron [sanitycheck]: Running cron in cron tag [' . $croninfo['tag'] . '] ');

    try {
        $sconfig = Configuration::getOptionalConfig('config-sanitycheck.php');

        $cronTag = $sconfig->getString('cron_tag', null);
        if ($cronTag === null || $cronTag !== $croninfo['tag']) {
            return;
        }

        $info = [];
        $errors = [];
        $hookinfo = [
            'info' => &$info,
            'errors' => &$errors,
        ];

        Module::callHooks('sanitycheck', $hookinfo);

        if (count($errors) > 0) {
            foreach ($errors as $err) {
                $croninfo['summary'][] = 'Sanitycheck error: ' . $err;
            }
        }
    } catch (Exception $e) {
        $croninfo['summary'][] = 'Error executing sanity check: ' . $e->getMessage();
    }
}
