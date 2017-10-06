<?php

namespace App\Utils;

use MicrosoftAzure\Storage\Blob\Internal\IBlob;
use League\Flysystem\Azure\AzureAdapter;

class ExtendedAzureFlysystemAdapter extends AzureAdapter
{
	protected $endpoint;
	/**
     * Constructor.
     *
     * @param IBlob  $azureClient
     * @param string $container
     */
    public function __construct(IBlob $azureClient, $container, $endpoint, $prefix = null)
    {
        $this->client = $azureClient;
        $this->container = $container;
        $this->endpoint = $endpoint;
        $this->setPathPrefix($prefix);
    }

    public function getUrl($file)
    {
    	return $this->endpoint . $this->container .'/'. $file;
    }
}