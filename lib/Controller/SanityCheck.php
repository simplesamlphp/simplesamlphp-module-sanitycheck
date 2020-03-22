<?php

namespace SimpleSAML\Module\sanitycheck\Controller;

use SimpleSAML\Configuration;
use SimpleSAML\Module;
use SimpleSAML\Session;
use SimpleSAML\XHTML\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller class for the sanitycheck module.
 *
 * This class serves the different views available in the module.
 *
 * @package SimpleSAML\Module\sanitycheck
 */
class SanityCheck
{
    /** @var \SimpleSAML\Configuration */
    protected $config;

    /** @var \SimpleSAML\Session */
    protected $session;


    /**
     * Controller constructor.
     *
     * It initializes the global configuration and session for the controllers implemented here.
     *
     * @param \SimpleSAML\Configuration              $config The configuration to use by the controllers.
     * @param \SimpleSAML\Session                    $session The session to use by the controllers.
     *
     * @throws \Exception
     */
    public function __construct(
        Configuration $config,
        Session $session
    ) {
        $this->config = $config;
        $this->session = $session;
    }


    /**
     * Show sanity check.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string|null $output
     * @return \Symfony\Component\HttpFoundation\Response
     *   A Symfony Response-object.
     */
    public function main(Request $request, ?string $output): Response
    {
        $info = [];
        $errors = [];
        $hookinfo = [
            'info' => &$info,
            'errors' => &$errors,
        ];
        Module::callHooks('sanitycheck', $hookinfo);

        if ($output === 'text') {
            $response = new Response(
                (count($errors) === 0) ? 'OK' : 'FAIL',
                Response::HTTP_OK,
                ['content-type' => 'text/html']
            );
            return $response;
        }

        $t = new Template($this->config, 'sanitycheck:check.twig');
        $t->data['pageid'] = 'sanitycheck';
        $t->data['errors'] = $errors;
        $t->data['info'] = $info;
        return $t;
    }
}

